<?php

namespace App\Http\Controllers;

use App\Models\Client;  
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Método para listar todos os clientes
    public function index()
    {
        $clients = Client::all();  // Busca todos os clientes do banco de dados
        return view('clientes.index', compact('clients'));  // Envia os clientes para a view 'clients.index'
    }

    // Método para exibir o formulário de criação de clientes
    public function create()
    {
        return view('clientes.create');  // Renderiza a view de criação de cliente
    }

    // Método para salvar um novo cliente no banco de dados
    public function store(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'phone' => 'required|string',
            'country' => 'required|string',
            'address' => 'nullable|string',
            'contributor' => 'nullable|string',
        ]);
    
        // Cria o cliente no banco de dados
        Client::create($validated);
    
        // Redireciona de volta para a listagem de clientes com uma mensagem de sucesso
        return redirect()->route('clients.index')->with('success', 'Cliente cadastrado com sucesso!');
    }
    
//Metodo editar
    public function edit($id)
{
    $client = Client::findOrFail($id);  // Busca o cliente pelo ID, retorna 404 se não encontrado
    return view('clientes.edit', compact('client'));  // Passa os dados do cliente para a view
}


public function show($id)
    {
        $client = Client::with('entries')->findOrFail($id);  // Carrega o cliente e suas entradas

        return view('clientes.show', compact('client'));
    }




//Metodo Editar e salvar
public function update(Request $request, $id)
{
    // Validação dos dados
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:clients,email,' . $id,
        'phone' => 'required|string',
        'country' => 'required|string',
        'address' => 'nullable|string',
        'contributor' => 'nullable|string',
    ]);

    // Busca o cliente pelo ID e atualiza com os dados validados
    $client = Client::findOrFail($id);
    $client->update($validated);

    // Redireciona de volta para a listagem de clientes com uma mensagem de sucesso
    return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso!');
}

//Metodo Excluir
public function destroy($id)
    {
        // Busca o cliente pelo ID, e se não for encontrado, retorna um erro 404
        $client = Client::findOrFail($id);

        // Exclui o cliente do banco de dados
        $client->delete();

        // Redireciona de volta para a listagem de clientes com uma mensagem de sucesso
        return redirect()->route('clients.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
