<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(){
        $products= Product::all();
        $customers = Customer::all();
        return view("order.create",compact("products","customers"));} 

public function store(Request $request)
{
    // 1. Valida se veio algum produto
    if (!$request->has('products')) {
        return back()->withErrors(['error' => 'O pedido deve ter pelo menos um produto.']);
    }

    try {
        // Usa o DB Transaction para garantir que se der erro, nada é salvo incompleto
        DB::transaction(function () use ($request) {
            
            // 2. Salva ou Atualiza o Cliente baseado no Telefone
            $customer = \App\Models\Customer::updateOrCreate(
                ['phone' => $request->customer_phone], // Condição de busca
                [
                    'name' => $request->customer_name,
                    'cep' => $request->customer_cep,
                    'street' => $request->customer_street,
                    'number' => $request->customer_number,
                    'complement' => $request->customer_complement,
                    'neighborhood' => $request->customer_neighborhood,
                    'city' => $request->customer_city,
                    'state' => $request->customer_state,
                ]
            );

            // 3. Cria o cabeçalho do Pedido vinculando o Cliente
            $order = \App\Models\Order::create([
                'customer_id' => $customer->id, 
                'status' => $request->order_status,
                'total_price' => $request->total_price,
                'notes' => $request->notes,
                'order_date' => $request->order_date, // Salvando a data perfeitamente!
            ]);

            // 4. Salva os produtos e baixa o estoque
            foreach ($request->products as $productId => $data) {
                if (isset($data['selected'])) {
                    $product = \App\Models\Product::find($productId);
                    
                    // Vincula produto ao pedido (Tabela Pivot)
                    $order->products()->attach($productId, [
                        'quantity' => $data['quantity'],
                        'price_at_purchase' => $product->product_price
                    ]);

                    // Baixa o Estoque dos ingredientes
                    foreach ($product->ingredients as $ingredient) {
                        $needed = $ingredient->pivot->amount * $data['quantity'];
                        $ingredient->decrement('ingredient_quantity', $needed);
                    }
                }
            }
        });

        return redirect('/order')->with('success', 'Pedido gerado com sucesso!');

    } catch (\Exception $e) {
        return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}
   public function index()
{
    $orders = Order::with(['products', 'customer'])->get(); 
    return view('order.index', compact('orders'));
}

    public function edit(Order $order) {
    $products = Product::all();
    $customers = Customer::all();
    // Carregamos os produtos do pedido para facilitar a checagem no Blade
    $order->load('products'); 
    return view('order.edit', compact('order', 'products',"customers"));}

public function update(Request $request, Order $order)
{
    // 1. Validar se há produtos selecionados
    if (!$request->has('products')) {
        return back()->withErrors(['stock_error' => 'O pedido deve ter pelo menos um produto.']);
    }

    try {
        DB::transaction(function () use ($request, $order) {
            
            // --- PASSO 1: DEVOLVER O ESTOQUE ANTIGO ---
            // Sempre limpamos o estoque antigo, pois se o pedido mudar de itens, 
            // ou se for cancelado, os ingredientes antigos precisam voltar para a despensa.
            foreach ($order->products as $oldProduct) {
                foreach ($oldProduct->ingredients as $ingredient) {
                    $amountToReturn = $ingredient->pivot->amount * $oldProduct->pivot->quantity;
                    $ingredient->increment('ingredient_quantity', $amountToReturn);
                }
            }

            // Descobre se o novo status enviado é "cancelado"
            $isCanceled = $request->order_status === 'canceled';

            // Se o pedido NÃO estiver sendo cancelado, validamos e baixamos o novo estoque
            if (!$isCanceled) {
                
                // --- PASSO 2: VALIDAR SE O NOVO PEDIDO TEM ESTOQUE ---
                $newRequirements = [];
                foreach ($request->products as $productId => $data) {
                    if (isset($data['selected'])) {
                        $product = Product::with('ingredients')->find($productId);
                        foreach ($product->ingredients as $ingredient) {
                            $needed = $ingredient->pivot->amount * $data['quantity'];
                            $newRequirements[$ingredient->id] = ($newRequirements[$ingredient->id] ?? 0) + $needed;
                            
                            // Busca o estoque atualizado (já com a devolução feita no Passo 1)
                            $currentStock = DB::table('ingredients')->where('id', $ingredient->id)->value('ingredient_quantity');
                            
                            if ($currentStock < $newRequirements[$ingredient->id]) {
                                throw new \Exception("Estoque insuficiente para '{$ingredient->ingredient_name}'. Disponível: {$currentStock}.");
                            }
                        }
                    }
                }
            }

            // --- PASSO 3: ATUALIZAR O CABEÇALHO DO PEDIDO ---
            $order->update([
                'customer_name'    => $request->customer_name,
                'customer_address' => $request->customer_address,
                'status'           => $request->order_status,
                'total_price'      => $request->total_price,
                'notes'            => $request->notes,
                'order_date' => $request->order_date,
            ]);

            // --- PASSO 4: SINCRONIZAR PRODUTOS (E BAIXAR ESTOQUE SE NÃO FOR CANCELADO) ---
            $syncData = [];
            foreach ($request->products as $productId => $data) {
                if (isset($data['selected'])) {
                    $product = Product::find($productId);
                    
                    // Prepara os dados para o sync (Mantém os produtos salvos no histórico do pedido)
                    $syncData[$productId] = [
                        'quantity' => $data['quantity'],
                        'price_at_purchase' => $product->product_price
                    ];

                    // Só debita do estoque se o pedido NÃO for cancelado
                    if (!$isCanceled) {
                        foreach ($product->ingredients as $ingredient) {
                            $ingredient->decrement('ingredient_quantity', $ingredient->pivot->amount * $data['quantity']);
                        }
                    }
                }
            }

            // O sync remove as relações antigas e grava o estado atual enviado pelo form
            $order->products()->sync($syncData);
        });

        $mensagem = $request->order_status === 'canceled' 
            ? 'Pedido #'.$order->id.' CANCELADO e ingredientes devolvidos ao estoque!'
            : 'Pedido #'.$order->id.' atualizado e estoque recalculado!';

        return redirect('/order')->with('success', $mensagem);

    } catch (\Exception $e) {
        return back()->withInput()->withErrors(['stock_error' => $e->getMessage()]);
    }
}

public function show(Order $order)
{
    // Carrega os produtos e os dados da tabela pivot (quantidade e preço da época)
    $order->load('products');
    
    return view('order.show', compact('order'));
}

public function delete(Order $order)
{
    try {
        DB::transaction(function () use ($order) {
            // 1. Percorre os produtos vinculados a este pedido
            foreach ($order->products as $product) {
                // 2. Para cada produto, busca os ingredientes (a receita)
                foreach ($product->ingredients as $ingredient) {
                    // 3. Calcula quanto deve ser devolvido
                    // (Quantidade do ingrediente na receita x Quantidade de produtos pedida)
                    $amountToReturn = $ingredient->pivot->amount * $product->pivot->quantity;

                    // 4. Devolve o valor ao estoque
                    $ingredient->increment('ingredient_quantity', $amountToReturn);
                }
            }

            // 5. Deleta o pedido (as relações na tabela order_items 
            // serão deletadas automaticamente se você usou onDelete('cascade') na migration)
            $order->delete();
        });

        return redirect('/order')->with('success', 'Pedido excluído e estoque devolvido com sucesso!');

    } catch (\Exception $e) {
        return redirect('/order')->with('error', 'Erro ao excluir pedido: ' . $e->getMessage());
    }
}

// Adicione este método no seu OrderController

    public function dailyReport(Request $request)
    {
        // 1. Pega a data informada na URL (filtro) ou usa a data de hoje por padrão
        $date = $request->input('date', now()->toDateString());

        // 2. Busca os pedidos daquela data (ignorando os cancelados)
        // Usamos eager loading (with) para não sobrecarregar o banco com muitas queries
        $orders = Order::with('products.ingredients')
           ->whereDate('order_date', $date) // <--- ALTERE AQUI!
            ->where('status', '!=', 'canceled')
            ->get();

        // 3. Calcula o Total Vendido no dia
        $totalValue = $orders->sum('total_price');

        // 4. Variáveis para armazenar as somatórias
        $dishesSold = [];
        $ingredientsUsed = [];

        // 5. Varre os pedidos para agrupar os dados
        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                $qty = $product->pivot->quantity;

                // Somatória de Pratos
                if (!isset($dishesSold[$product->id])) {
                    $dishesSold[$product->id] = [
                        'name' => $product->product_name, // Supondo que a coluna seja product_name
                        'quantity' => 0,
                    ];
                }
                $dishesSold[$product->id]['quantity'] += $qty;

                // Somatória de Ingredientes usados naqueles pratos
                foreach ($product->ingredients as $ingredient) {
                    $ingQty = $ingredient->pivot->amount * $qty;

                    if (!isset($ingredientsUsed[$ingredient->id])) {
                        $ingredientsUsed[$ingredient->id] = [
                            'name' => $ingredient->ingredient_name, // Supondo que a coluna seja ingredient_name
                            'quantity' => 0,
                        ];
                    }
                    $ingredientsUsed[$ingredient->id]['quantity'] += $ingQty;
                }
            }
        }

        // 6. Transforma os arrays em Collections do Laravel para facilitar a ordenação
        $dishesSold = collect($dishesSold)->sortByDesc('quantity');
        $ingredientsUsed = collect($ingredientsUsed)->sortByDesc('quantity');

        // 7. Pega os destaques
        $bestSellingDish = $dishesSold->first(); // O prato mais vendido (primeiro da lista ordenada)
        $totalIngredientsCount = $ingredientsUsed->sum('quantity'); // Total de unidades de ingredientes usados

        return view('order.report', compact(
            'date', 
            'totalValue', 
            'dishesSold', 
            'bestSellingDish', 
            'ingredientsUsed', 
            'totalIngredientsCount'
        ));
    }
}
