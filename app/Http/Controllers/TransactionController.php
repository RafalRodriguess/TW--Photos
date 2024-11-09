<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Client;
use App\Models\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $entradas = Transaction::with('client')->where('type', 'entrada')->get();
        
        return view('financeiro.entrada.index', compact('entradas'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('financeiro.entrada.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clients,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
        }

        $entrada = Transaction::create([
            'type' => 'entrada',
            'cliente_id' => $request->input('cliente_id'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'proof' => $proofPath
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'create_entrada',
            'description' => 'Adicionou a entrada: ' . $entrada->description
        ]);

        return redirect()->route('financeiro.entrada.index')->with('success', 'Entrada registrada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clients,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $entrada = Transaction::findOrFail($id);

        if ($request->hasFile('proof')) {
            if ($entrada->proof) {
                Storage::disk('public')->delete($entrada->proof);
            }
            $entrada->proof = $request->file('proof')->store('proofs', 'public');
        }

        $entrada->update([
            'cliente_id' => $request->input('cliente_id'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount')
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'update_entrada',
            'description' => 'Atualizou a entrada: ' . $entrada->description
        ]);

        return redirect()->route('financeiro.entrada.index')->with('success', 'Entrada atualizada com sucesso!');
    }

    public function edit($id)
    {
        $entrada = Transaction::findOrFail($id);
        $clients = Client::all();
        return view('financeiro.entrada.edit', compact('entrada', 'clients'));
    }

    public function destroy($id)
    {
        $entrada = Transaction::findOrFail($id);

        if ($entrada->proof) {
            Storage::disk('public')->delete($entrada->proof);
        }

        $entrada->delete();

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'delete_entrada',
            'description' => 'Excluiu a entrada: ' . $entrada->description
        ]);

        return redirect()->route('financeiro.entrada.index')->with('success', 'Entrada excluída com sucesso!');
    }

    public function saidaIndex()
    {
        $saidas = Transaction::with('client')->where('type', 'saida')->get();
        return view('financeiro.saida.index', compact('saidas'));
    }

    public function saidaCreate()
    {
        $clients = Client::all();
        return view('financeiro.saida.create', compact('clients'));
    }

    public function saidaStore(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clients,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
        }

        $saida = Transaction::create([
            'type' => 'saida',
            'cliente_id' => $request->input('cliente_id'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'proof' => $proofPath
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'create_saida',
            'description' => 'Adicionou a saída: ' . $saida->description
        ]);

        return redirect()->route('financeiro.saida.index')->with('message', [
            'type' => 'success',
            'content' => 'Saída registrada com sucesso!'
        ]);
    }

    public function saidaEdit($id)
    {
        $saida = Transaction::findOrFail($id);
        $clients = Client::all();
        return view('financeiro.saida.edit', compact('saida', 'clients'));
    }

    public function saidaUpdate(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clients,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $saida = Transaction::findOrFail($id);

        if ($request->hasFile('proof')) {
            if ($saida->proof) {
                Storage::disk('public')->delete($saida->proof);
            }
            $saida->proof = $request->file('proof')->store('proofs', 'public');
        }

        $saida->update([
            'cliente_id' => $request->input('cliente_id'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount')
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'update_saida',
            'description' => 'Atualizou a saída: ' . $saida->description
        ]);

        return redirect()->route('financeiro.saida.index')->with('message', [
            'type' => 'success',
            'content' => 'Saída atualizada com sucesso!'
        ]);
    }

    public function saidaDestroy($id)
    {
        $saida = Transaction::findOrFail($id);

        if ($saida->proof) {
            Storage::disk('public')->delete($saida->proof);
        }

        $saida->delete();

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'delete_saida',
            'description' => 'Excluiu a saída: ' . $saida->description
        ]);

        return redirect()->route('financeiro.saida.index')->with('message', [
            'type' => 'success',
            'content' => 'Saída excluída com sucesso!'
        ]);
    }
}
