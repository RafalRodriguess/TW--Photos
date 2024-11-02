<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Transaction;
use App\Models\FixedExpense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de Clientes
        $totalClientes = Client::count();
    
        // Faturamento do Dia (Entradas do dia)
        $faturamentoDia = Transaction::where('type', 'entrada')
                                      ->whereDate('created_at', now()->format('Y-m-d'))
                                      ->sum('amount');
    
        // Saídas do Dia
        $saidasDia = Transaction::where('type', 'saida')
                                ->whereDate('created_at', now()->format('Y-m-d'))
                                ->sum('amount');
    
        // Faturamento do Mês (Entradas do mês)
        $faturamentoMes = Transaction::where('type', 'entrada')
                                     ->whereMonth('created_at', now()->month)
                                     ->whereYear('created_at', now()->year)
                                     ->sum('amount');
    
        // Saídas do Mês
        $saidasMes = Transaction::where('type', 'saida')
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->sum('amount');
    
        // Lucro do Mês (Faturamento - Saídas)
        $lucroMes = $faturamentoMes - $saidasMes;
    
        // Entradas e Saídas do Dia (Detalhes para a tabela)
        $dailyEntries = Transaction::where('type', 'entrada')
                                   ->whereDate('created_at', now()->format('Y-m-d'))
                                   ->get();
    
        $dailyExpenses = Transaction::where('type', 'saida')
                                    ->whereDate('created_at', now()->format('Y-m-d'))
                                    ->get();
    
        // Contas fixas para o mês atual
        $currentMonthExpenses = FixedExpense::whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)
                                            ->get();
    
        return view('dashboard', compact(
            'totalClientes', 'faturamentoDia', 'saidasDia', 'faturamentoMes', 
            'saidasMes', 'lucroMes', 'dailyEntries', 'dailyExpenses', 'currentMonthExpenses'
        ));
    }
}
