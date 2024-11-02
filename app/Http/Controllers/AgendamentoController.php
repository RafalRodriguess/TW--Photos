<?php

namespace App\Http\Controllers;

use App\Models\Client; 
use App\Models\Agendamento; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgendamentoController extends Controller
{
    // Método para exibir a lista de agendamentos
    public function index()
    {
        $agendamentos = Agendamento::with('client')->get(); 
        return view('agendamentos.index', compact('agendamentos')); 
    }

    // Método para exibir a tela de criação do agendamento
    public function create()
    {
        $clientes = Client::all();
        return view('agendamentos.create', compact('clientes')); 
    }

    public function store(Request $request)
    {
        // Validação do formulário
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clients,id',
            'data' => 'required|date',
            'observacao' => 'nullable|string',
        ]);
    
        try {
            // Cria o agendamento, certificando-se de que cliente_id é usado
            Agendamento::create($validated);
            return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso!');
        } catch (\Exception $e) {
            // Log detalhado do erro
            Log::error('Erro ao criar agendamento', [
                'message' => $e->getMessage(),
                'data' => $request->all(), // Dados que estão sendo enviados
            ]);
    
            // Adiciona a mensagem de erro de depuração à sessão
            return redirect()->route('agendamentos.create')->with('error', 'Não foi possível criar o agendamento. Tente novamente.')
                ->with('error_debug', $e->getMessage());
        }
    }
    

    // Método para exibir os detalhes de um agendamento
    public function show($id)
    {
        $agendamento = Agendamento::with('client')->findOrFail($id); // Busca o agendamento pelo ID
        return view('agendamentos.show', compact('agendamento')); // Retorna a view com os detalhes do agendamento
    }

    // Método para exibir a tela de edição do agendamento
    public function edit($id)
    {
        $agendamento = Agendamento::findOrFail($id); // Busca o agendamento pelo ID
        $clientes = Client::all(); // Busca todos os clientes
        return view('agendamentos.edit', compact('agendamento', 'clientes')); // Retorna a view de edição
    }

    // Método para atualizar um agendamento
    public function update(Request $request, $id)
    {
        // Validação do formulário
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clients,id',
            'data' => 'required|date',
            'observacao' => 'nullable|string',
        ]);

        try {
            $agendamento = Agendamento::findOrFail($id); // Busca o agendamento pelo ID
            $agendamento->update($validated); // Atualiza os dados do agendamento
            return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar agendamento', ['message' => $e->getMessage()]);
            return redirect()->route('agendamentos.edit', $id)->with('error', 'Não foi possível atualizar o agendamento. Tente novamente.');
        }
    }

    // Método para excluir um agendamento
    public function destroy($id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id); // Busca o agendamento pelo ID
            $agendamento->delete(); // Exclui o agendamento
            return redirect()->route('agendamentos.index')->with('success', 'Agendamento excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir agendamento', ['message' => $e->getMessage()]);
            return redirect()->route('agendamentos.index')->with('error', 'Não foi possível excluir o agendamento. Tente novamente.');
        }
    }
}
