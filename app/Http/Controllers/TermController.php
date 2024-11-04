<?php
namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::with('client')->get();
        return view('terms.index', compact('terms'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('terms.create', compact('clients'));
    }

    public function store(Request $request)
    {
        Log::info('Dados recebidos para criação do termo:', $request->all());
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'term_date' => 'required|date',
            'description' => 'required|string',
            'purpose' => 'required|string'
        ]);

        Term::create($request->all());
        return redirect()->route('terms.index')->with('success', 'Termo de uso criado com sucesso!');
    }

    public function show($id)
    {
        $term = Term::with('client')->findOrFail($id);
        return view('terms.show', compact('term'));
    }
    public function destroy($id)
{
    $term = Term::findOrFail($id);

    // Exclui o termo
    $term->delete();

    // Redireciona para a listagem de termos com uma mensagem de sucesso
    return redirect()->route('terms.index')->with('success', 'Termo excluído com sucesso!');
}

    public function generatePDF($id)
    {
        $term = Term::with('client')->findOrFail($id);
        $pdf = PDF::loadView('terms.pdf', compact('term'));
        return $pdf->download("Termo_{$term->client->name}.pdf");
    }
}
