<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabalho;
use App\Models\TrabalhoImagem;
use Illuminate\Support\Facades\Log;

class ImageSelectionController extends Controller
{
    // Função para exibir as imagens do trabalho para seleção
    public function index($token)
    {
        $trabalho = Trabalho::where('token', $token)->with('imagens')->firstOrFail();
        return view('imagem.index', compact('trabalho'));
    }


    public function excluir(Request $request, $token)
{
    $trabalho = Trabalho::where('token', $token)->firstOrFail();
    $imagensParaExcluir = $request->input('imagens', []);

    if (!empty($imagensParaExcluir)) {
        TrabalhoImagem::whereIn('id', $imagensParaExcluir)->delete();
        return response()->json(['success' => true, 'message' => 'Imagens excluídas com sucesso.']);
    }

    return response()->json(['success' => false, 'message' => 'Nenhuma imagem foi selecionada para exclusão.'], 400);
}

    // Função para salvar as imagens selecionadas
    public function storeSelection(Request $request, $token)
    {
        $trabalho = Trabalho::where('token', $token)->firstOrFail();
        $imagensSelecionadas = $request->input('imagens', []);

        // Atualiza o status das imagens selecionadas
        TrabalhoImagem::whereIn('id', $imagensSelecionadas)
            ->where('trabalho_id', $trabalho->id)
            ->update(['selecionada' => 1]);

        return response()->json(['success' => true, 'message' => 'Seleção salva com sucesso.']);
    }
}
