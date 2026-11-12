<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    // 1. Abre a tela de formulário vazia
    public function create()
    {
        return view('customer.create');
    }

    // 2. Recebe os dados do formulário e salva no banco
    public function store(Request $request)
    {
        // Cria um novo registro no banco de dados usando o Model Customer
        Customer::create([
            'name'         => $request->input('name'),
            'phone'        => $request->input('phone'),
            'cep'          => $request->input('cep'),
            'street'       => $request->input('street'),
            'number'       => $request->input('number'),
            'complement'   => $request->input('complement'),
            'neighborhood' => $request->input('neighborhood'),
            'city'         => $request->input('city'),
            'state'        => $request->input('state'),
        ]);

        return redirect('/customer')->with('success', 'Cliente cadastrado com sucesso!');
    }
    public function index()
    {
        // Busca todos os clientes ordenados pelo nome
        $customers = Customer::orderBy('id', 'asc')->get();
        
        return view('customer.index', ['customers' => $customers]);
    }

   
    public function edit($id)
    {
        $customer = Customer::findOrFail($id); // Busca o cliente ou dá erro 404
        
        return view('customer.edit', ['customer' => $customer]);
    }

    // 2. Salva as edições no banco de dados
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        // Atualiza os dados do cliente com o que veio do formulário
        // (Verifique se os nomes das colunas abaixo batem com o seu banco de dados)
        $customer->update([
            'name'         => $request->input('name'),
            'phone'        => $request->input('phone'),
            'cep'          => $request->input('cep'),
            'street'       => $request->input('street'),
            'number'       => $request->input('number'),
            'complement'   => $request->input('complement'),
            'neighborhood' => $request->input('neighborhood'),
            'city'         => $request->input('city'),
            'state'        => $request->input('state'),
        ]);

        // Redireciona de volta para a lista de clientes com uma mensagem de sucesso
        return redirect('/customer')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        
        return view('customer.show', ['customer' => $customer]);
    }

    // Remove o cliente do banco de dados
    public function delete($id)
    {
        // 1. Busca o cliente pelo ID ou retorna erro 404 se não existir
        $customer = Customer::findOrFail($id);

        // 2. Apaga o registro do banco de dados
        $customer->delete();

        // 3. Redireciona para a lista de clientes com uma mensagem de sucesso
        return redirect('/customer')->with('success', 'Cliente removido com sucesso!');
    }
}