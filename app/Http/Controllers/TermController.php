<?php
namespace App\Http\Controllers;
use App\Models\Log;
use App\Models\Term;
use App\Models\Client;
use Illuminate\Http\Request;

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
       
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'term_date' => 'required|date',
            'description' => 'required|string',
            'purpose' => 'required|string'
        ]);

      
        Term::create($request->all());
        
        Log::create([
            'user_id' => auth()->id(),
            'action' => 'create_term',
            'description' => 'Criou o Termo: ' . $id
        ]);
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
   Log::create([
            'user_id' => auth()->id(),
            'action' => 'delete_term',
            'description' => 'Deletou o Termo: ' . $term->description
        ]);
    
    $term->delete();

    

    return redirect()->route('terms.index')->with('success', 'Termo excluído com sucesso!');
}

    public function generatePDF($id)
    {
        $term = Term::with('client')->findOrFail($id);
        $pdf = PDF::loadView('terms.pdf', compact('term'));
        return $pdf->download("Termo_{$term->client->name}.pdf");
    }
}
