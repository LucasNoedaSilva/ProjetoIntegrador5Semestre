<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ingredient;

class ProductController extends Controller
{
    public function create(){
        $categorys = Category::all();
        $ingredients = Ingredient::all();
        return view("Product.create", compact('categorys',"ingredients"));}
     
    public function store(Request $request){
        //Product::create($request->all());
        $product = Product::create([
            'product_name' => $request->product_name,
            'product_describe' => $request->product_describe,
            'category_id' => $request->category_id,
            'product_price' => $request->product_price
        ]);
        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $id => $data) {
                if (!empty($data['amount'])) {
                    $product->ingredients()->attach($id, ['amount' => $data['amount']]);
                }
            }
        }
        return redirect('/product');}
    
    public function index(){
        return view("Product.index", ["products" => Product::all()]);}
    
    public function edit(Product $product){
        $categorys = Category::all();
        $ingredients = Ingredient::all();
        return view ("Product.edit", ["product"=>$product],compact('categorys',"ingredients"));}
    
    public function update(Request $request, Product $product){
      /*  $product->update($request->all());
        return redirect('/product'); */
        // 1. Atualiza os dados básicos do produto na instância que você já tem
    $product->update([
        'product_name'     => $request->product_name,
        'product_describe' => $request->product_describe,
        'category_id'      => $request->category_id,
        'product_price'    => $request->product_price
    ]);

    // 2. Prepara os dados para sincronizar os ingredientes
    $syncData = [];

    if ($request->has('ingredients')) {
        foreach ($request->ingredients as $id => $data) {
            // Verifica se o checkbox 'selected' foi marcado E se há quantidade
            if (isset($data['selected']) && !empty($data['amount'])) {
                // Monta o array no formato: [id_ingrediente => ['coluna_pivot' => valor]]
                $syncData[$id] = ['amount' => $data['amount']];
            }
        }
    }
    // 3. O 'sync' faz a mágica: deleta os antigos que saíram, atualiza os que ficaram
    // e insere os novos, tudo de uma vez só no banco de dados.
    $product->ingredients()->sync($syncData);

    return redirect('/product')->with('success', 'Produto atualizado com sucesso!');
        }
    
   public function show(Product $product) {
    // Calculando o custo total somando (preço do ingrediente * quantidade na receita)
    $totalProductionCost = $product->ingredients->sum(function($ingredient) {
        return $ingredient->ingredient_price * $ingredient->pivot->amount;
    });

    return view('product.show', compact('product', 'totalProductionCost'));
}
    
    public function delete(Product $product){
        $product->delete();
        return redirect('/product');}
}
