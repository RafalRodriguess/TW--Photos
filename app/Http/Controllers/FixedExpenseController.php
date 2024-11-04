<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\FixedExpense;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FixedExpenseController extends Controller
{
    public function index()
    {
        $fixedExpenses = FixedExpense::all();
        return view('financeiro.contas.index', compact('fixedExpenses'));
    }

    public function create()
    {
        return view('financeiro.contas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_day' => 'required|integer|min:1|max:31', // Validação para o dia do vencimento
            'proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
    
        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('comprovantes', 'public');
        }
    
        FixedExpense::create([
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'due_day' => $request->input('due_day'),
            'status' => 'pendente',
            'proof' => $proofPath,
        ]);
    
        return redirect()->route('financeiro.contas.index')->with('success', 'Conta fixa adicionada com sucesso!');
    }
    public function edit($id)
    {
        $expense = FixedExpense::findOrFail($id);
        return view('financeiro.contas.edit', compact('expense'));
    }
    public function markAsPaid($id)
    {
        $expense = FixedExpense::findOrFail($id);

        // Marcar a conta atual como paga
        $expense->update(['status' => 'pago']);
        
        // Criar uma nova transação de saída para contabilizar no total de saídas
        Transaction::create([
            'type' => 'saida',
            'amount' => $expense->amount,
            'description' => 'Conta Fixa: ' . $expense->description,
            'date' => now(),
        ]);

        // Criar uma nova conta com o mesmo `due_day` para o próximo mês
        FixedExpense::create([
            'description' => $expense->description,
            'amount' => $expense->amount,
            'due_day' => $expense->due_day, // Mantém o dia do vencimento
            'status' => 'pendente',
            'proof' => null,
        ]);

        return redirect()->route('financeiro.contas.index')->with('success', 'Conta marcada como paga e nova conta criada para o próximo mês.');
    }


    public function destroy($id)
    {
        // Encontra a despesa fixa pelo ID
        $fixedExpense = FixedExpense::findOrFail($id);

        // Exclui a despesa fixa
        $fixedExpense->delete();

        // Redireciona com uma mensagem de sucesso
        return redirect()->route('financeiro.contas.index')->with('message', [
            'type' => 'success',
            'content' => 'Despesa fixa excluída com sucesso!'
        ]);
    }
}
