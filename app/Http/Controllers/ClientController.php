<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Log;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

     

        return view('clientes.index', compact('clients'));
    }

    public function create()
    {
       

        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients',
            'phone' => 'required|string',
            'contributor' => 'nullable|string',
        ]);

        Client::create($validated);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'create_client',
            'description' => 'Cliente criado: ' . $request->input('name')
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);

     
        return view('clientes.edit', compact('client'));
    }

    public function show($id)
    {
        $client = Client::with('entries')->findOrFail($id);

     

        return view('clientes.show', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email,' . $id,
            'phone' => 'required|string',
            'country' => 'required|string',
            'address' => 'nullable|string',
            'contributor' => 'nullable|string',
        ]);

        $client = Client::findOrFail($id);
        $client->update($validated);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'update_client',
            'description' => 'Cliente editado: ' . $client->name
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'delete_client',
            'description' => 'Cliente excluído: ' . $client->name
        ]);

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
