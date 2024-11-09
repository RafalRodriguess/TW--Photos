<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Support\Str;
use App\Models\Trabalho;
use App\Models\TrabalhoImagem;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Log;
use Intervention\Image\Facades\Image;

class TrabalhoController extends Controller
{
    public function index()
    {
        $trabalhos = Trabalho::with('cliente')->get();

        return view('trabalhos.index', compact('trabalhos'));
    }

    public function create()
    {
        $clientes = Client::all();

     

        return view('trabalhos.create', compact('clientes'));
    }

    public function deleteImages(Request $request, $id)
    {
        $trabalho = Trabalho::findOrFail($id);
        $deleteImageIds = $request->input('delete_images', []);

        if (!empty($deleteImageIds)) {
            foreach ($deleteImageIds as $imageId) {
                $imagem = TrabalhoImagem::find($imageId);
                if ($imagem) {
                    Storage::delete('public/' . $imagem->imagem);
                    $imagem->delete();
                }
            }
        }

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'delete_images',
            'description' => 'Imagens excluídas do trabalho ID: ' . $id
        ]);

        return redirect()->route('trabalhos.show', $id)->with('success', 'Imagens selecionadas excluídas com sucesso!');
    }

    public function show($id)
    {
        $trabalho = Trabalho::with('imagens')->findOrFail($id);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'view_trabalho',
            'description' => 'Visualizou o trabalho ID: ' . $id
        ]);

        return view('trabalhos.show', compact('trabalho'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagens' => 'required|array',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $shortToken = Str::random(10);
        $trabalho = Trabalho::create(array_merge($validated, ['token' => $shortToken]));

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $path = $imagem->store('trabalhos', 'public');
                TrabalhoImagem::create([
                    'trabalho_id' => $trabalho->id,
                    'imagem' => $path,
                ]);
            }
        }

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'create_trabalho',
            'description' => 'Trabalho criado: ' . $trabalho->nome
        ]);

        return redirect()->route('trabalhos.index')->with('success', 'Trabalho criado com sucesso! URL para visualização: ' . url('/visualizar/' . $shortToken));
    }

    public function selecionarFotos(Request $request, $token)
    {
        $trabalho = Trabalho::where('token', $token)->firstOrFail();
        $imagensSelecionadas = $request->input('imagens', []);

        if (!empty($imagensSelecionadas)) {
            TrabalhoImagem::whereIn('id', $imagensSelecionadas)
                ->where('trabalho_id', $trabalho->id)
                ->update(['selecionada' => 1]);

            Log::create([
                'user_id' => auth()->id(),
                'action' => 'select_images',
                'description' => 'Imagens selecionadas para o trabalho com token: ' . $token
            ]);

            return response()->json(['success' => true, 'message' => 'Seleção registrada com sucesso.']);
        }

        return response()->json(['success' => false, 'message' => 'Nenhuma imagem selecionada.'], 400);
    }

    public function selecionarImagem(Request $request, $id)
    {
        $imagem = TrabalhoImagem::findOrFail($id);
        $imagem->selecionada = $request->input('selecionada') ? 1 : 0;
        $imagem->save();

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'select_single_image',
            'description' => 'Imagem ID ' . $id . ' selecionada/desmarcada'
        ]);

        return response()->json(['success' => true]);
    }

    public function visualizar($id)
    {
        $trabalho = Trabalho::with('imagens')->findOrFail($id);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'view_trabalho_visualizar',
            'description' => 'Visualizou a página de visualização do trabalho ID: ' . $id
        ]);

        return view('trabalhos.visualizar', compact('trabalho'));
    }

    public function deleteSelectedImages(Request $request, $id)
    {
        $trabalho = Trabalho::findOrFail($id);
        $deleteImageIds = $request->input('delete_images', []);

        if (!empty($deleteImageIds)) {
            foreach ($deleteImageIds as $imageId) {
                $imagem = TrabalhoImagem::find($imageId);
                if ($imagem) {
                    Storage::delete('public/' . $imagem->imagem);
                    $imagem->delete();
                }
            }
        }

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'delete_selected_images',
            'description' => 'Imagens selecionadas excluídas do trabalho ID: ' . $id
        ]);

        return redirect()->route('trabalhos.visualizar', $trabalho->id)->with('success', 'Imagens selecionadas excluídas com sucesso!');
    }

    public function edit($id)
    {
        $trabalho = Trabalho::with('imagens')->findOrFail($id);
        $clientes = Client::all();

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'view_edit_trabalho_form',
            'description' => 'Visualizou o formulário de edição do trabalho ID: ' . $id
        ]);

        return view('trabalhos.edit', compact('trabalho', 'clientes'));
    }

    public function selecionarImagens(Request $request, $token)
    {
        $trabalho = Trabalho::where('token', $token)->firstOrFail();
        $imagensSelecionadas = $request->input('imagens', []);

        foreach ($imagensSelecionadas as $imagemId) {
            ImagensSelecionadas::updateOrCreate(
                [
                    'trabalho_id' => $trabalho->id,
                    'trabalho_imagem_id' => $imagemId
                ]
            );
        }

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'select_multiple_images',
            'description' => 'Múltiplas imagens selecionadas para o trabalho com token: ' . $token
        ]);

        return response()->json(['success' => true, 'message' => 'Seleção registrada com sucesso.']);
    }

    public function deleteImagesByToken(Request $request, $token)
    {
        $trabalho = Trabalho::where('token', $token)->firstOrFail();
        $deleteImageIds = $request->input('delete_images', []);

        if (!empty($deleteImageIds)) {
            foreach ($deleteImageIds as $imageId) {
                $imagem = TrabalhoImagem::find($imageId);
                if ($imagem && $imagem->trabalho_id === $trabalho->id) {
                    Storage::delete('public/' . $imagem->imagem);
                    $imagem->delete();
                }
            }
        }

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'delete_images_by_token',
            'description' => 'Imagens excluídas por token: ' . $token
        ]);

        return redirect()->route('trabalhos.visualizar', $token)->with('success', 'Imagens selecionadas excluídas com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagens' => 'nullable',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $trabalho = Trabalho::findOrFail($id);
        $trabalho->update($validated);

        if ($request->has('delete_images')) {
            TrabalhoImagem::whereIn('id', $request->delete_images)->delete();
        }

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $path = $imagem->store('trabalhos', 'public');
                TrabalhoImagem::create([
                    'trabalho_id' => $trabalho->id,
                    'imagem' => $path,
                ]);
            }
        }

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'update_trabalho',
            'description' => 'Trabalho atualizado: ' . $trabalho->nome
        ]);

        return redirect()->route('trabalhos.index')->with('success', 'Trabalho atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $trabalho = Trabalho::findOrFail($id);
        $trabalho->delete();
        TrabalhoImagem::where('trabalho_id', $id)->delete();

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'delete_trabalho',
            'description' => 'Trabalho excluído: ' . $trabalho->nome
        ]);

        return redirect()->route('trabalhos.index')->with('success', 'Trabalho excluído com sucesso!');
    }

    public function downloadAll($id)
    {
        $trabalho = Trabalho::with('imagens')->findOrFail($id);
        $zip = new ZipArchive();
        $zipName = 'trabalho_' . $trabalho->id . '.zip';
        $zipPath = storage_path('app/public/' . $zipName);

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($trabalho->imagens as $imagem) {
                $zip->addFile(storage_path('app/public/' . $imagem->imagem), basename($imagem->imagem));
            }
            $zip->close();
        }

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'download_all_images',
            'description' => 'Download de todas as imagens do trabalho ID: ' . $trabalho->id
        ]);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
