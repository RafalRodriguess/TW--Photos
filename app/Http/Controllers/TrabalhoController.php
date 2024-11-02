<?php

namespace App\Http\Controllers;
use ZipArchive;
use Illuminate\Support\Str;
use App\Models\Trabalho;
use App\Models\TrabalhoImagem;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class TrabalhoController extends Controller
{
    // Exibe a listagem de trabalhos
    public function index()
    {
        $trabalhos = Trabalho::with('cliente')->get();  // Busca todos os trabalhos com os dados dos clientes
        return view('trabalhos.index', compact('trabalhos'));
    }

    // Exibe o formulário de criação de um novo trabalho
    public function create()
    {
        $clientes = Client::all();  // Lista todos os clientes para o select
        return view('trabalhos.create', compact('clientes'));
    }

    public function deleteImages(Request $request, $id)
    {
        // Busca o trabalho pelo ID
        $trabalho = Trabalho::findOrFail($id);
    
        // Verifica se há imagens selecionadas para exclusão
        $deleteImageIds = $request->input('delete_images', []);
    
        if (!empty($deleteImageIds)) {
            // Deleta as imagens no banco de dados e no armazenamento
            foreach ($deleteImageIds as $imageId) {
                $imagem = TrabalhoImagem::find($imageId);
                if ($imagem) {
                    // Remove o arquivo de imagem do armazenamento
                    Storage::delete('public/' . $imagem->imagem);
                    
                    // Deleta o registro da imagem no banco de dados
                    $imagem->delete();
                }
            }
        }
    
        return redirect()->route('trabalhos.show', $id)->with('success', 'Imagens selecionadas excluídas com sucesso!');
    }
// Exibe os detalhes de um trabalho
public function show($id)
{
    $trabalho = Trabalho::with('imagens')->findOrFail($id); // Busca o trabalho pelo ID com suas imagens
    return view('trabalhos.show', compact('trabalho'));
}

    // Salva um novo trabalho no banco de dados
    public function store(Request $request)
    {
        // Validação do formulário
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagens' => 'required|array',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'imagens.required' => 'As imagens são obrigatórias.',
        ]);
    
        // Gera um token curto e único para o trabalho
        $shortToken = Str::random(10);
    
        // Cria o trabalho com o token curto
        $trabalho = Trabalho::create(array_merge($validated, ['token' => $shortToken]));
    
        // Verifica se as imagens foram enviadas
        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $path = $imagem->store('trabalhos', 'public'); // Salva no diretório público
    
                // Salva a imagem no banco de dados
                TrabalhoImagem::create([
                    'trabalho_id' => $trabalho->id,
                    'imagem' => $path,
                ]);
            }
        }
    
        return redirect()->route('trabalhos.index')->with('success', 'Trabalho criado com sucesso! URL para visualização: ' . url('/visualizar/' . $shortToken));
    }

    public function selecionarFotos(Request $request, $token)
    {
        Log::info('selecionarFotos acionado.', ['token' => $token]);
        
        // Busca o trabalho pelo token
        $trabalho = Trabalho::where('token', $token)->firstOrFail();
        
        // Recebe a lista de IDs das imagens selecionadas
        $imagensSelecionadas = $request->input('imagens', []);
        
        Log::info('IDs de imagens recebidos:', $imagensSelecionadas); // Log para verificar os IDs recebidos
        
        if (!empty($imagensSelecionadas)) {
            // Atualiza o status de todas as imagens selecionadas
            TrabalhoImagem::whereIn('id', $imagensSelecionadas)
                ->where('trabalho_id', $trabalho->id)
                ->update(['selecionada' => 1]);
        
            Log::info('Imagens selecionadas atualizadas com sucesso.');
            return response()->json(['success' => true, 'message' => 'Seleção registrada com sucesso.']);
        } else {
            Log::warning('Nenhuma imagem foi selecionada.');
            return response()->json(['success' => false, 'message' => 'Nenhuma imagem selecionada.'], 400);
        }
    }
// Dentro de TrabalhoController
public function selecionarImagem(Request $request, $id)
{
    // Encontra a imagem pelo ID e atualiza o status "selecionada"
    $imagem = TrabalhoImagem::findOrFail($id);
    $imagem->selecionada = $request->input('selecionada') ? 1 : 0;
    $imagem->save();

    return response()->json(['success' => true]);
}

public function visualizar($id)
{
    $trabalho = Trabalho::with('imagens')->findOrFail($id);
    return view('trabalhos.visualizar', compact('trabalho'));
}

public function deleteSelectedImages(Request $request, $id)
{
    // Encontra o trabalho pelo ID
    $trabalho = Trabalho::findOrFail($id);

    // Obtém os IDs das imagens selecionadas para exclusão
    $deleteImageIds = $request->input('delete_images', []);

    if (!empty($deleteImageIds)) {
        // Loop para excluir imagens selecionadas
        foreach ($deleteImageIds as $imageId) {
            $imagem = TrabalhoImagem::find($imageId);
            if ($imagem) {
                // Remove o arquivo de imagem do armazenamento
                Storage::delete('public/' . $imagem->imagem);
                
                // Deleta o registro da imagem no banco de dados
                $imagem->delete();
            }
        }
    }

    return redirect()->route('trabalhos.visualizar', $trabalho->id)->with('success', 'Imagens selecionadas excluídas com sucesso!');
}
    public function edit($id)
{
    $trabalho = Trabalho::with('imagens')->findOrFail($id);
    $clientes = Client::all();  // Lista todos os clientes para o select
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

    return redirect()->route('trabalhos.visualizar', $token)->with('success', 'Imagens selecionadas excluídas com sucesso!');
}


    // Atualiza um trabalho no banco de dados
    public function update(Request $request, $id)
    {
        // Validação do formulário
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagens' => 'nullable',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',  // Validação das imagens
        ]);
    
        try {
            // Encontra o trabalho pelo ID
            $trabalho = Trabalho::findOrFail($id);
            $trabalho->update($validated);  // Atualiza os dados do trabalho
    
            // Excluir imagens marcadas para exclusão
            if ($request->has('delete_images')) {
                TrabalhoImagem::whereIn('id', $request->delete_images)->delete();
            }
    
            // Verifica se novas imagens foram enviadas
            if ($request->hasFile('imagens')) {
                foreach ($request->file('imagens') as $imagem) {
                    $path = $imagem->store('trabalhos', 'public');  // Salva no diretório público
    
                    // Salva a nova imagem no banco de dados
                    TrabalhoImagem::create([
                        'trabalho_id' => $trabalho->id,
                        'imagem' => $path,
                    ]);
                }
            }
    
            return redirect()->route('trabalhos.index')->with('success', 'Trabalho atualizado com sucesso!');
        } catch (\Exception $e) {
            // Loga o erro com detalhes
            Log::error('Erro ao atualizar trabalho', [
                'message' => $e->getMessage(),
                'request' => $request->all(),
            ]);
    
            return redirect()->route('trabalhos.edit', $id)->with('error', 'Não foi possível atualizar o trabalho. Tente novamente.');
        }
    }
    

    // Remove um trabalho do banco de dados
    public function destroy($id)
    {
        try {
            $trabalho = Trabalho::findOrFail($id);
            $trabalho->delete();  // Remove o trabalho

            // Remove as imagens associadas
            TrabalhoImagem::where('trabalho_id', $id)->delete();

            return redirect()->route('trabalhos.index')->with('success', 'Trabalho excluído com sucesso!');
        } catch (\Exception $e) {
            // Loga o erro com detalhes
            Log::error('Erro ao excluir trabalho', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('trabalhos.index')->with('error', 'Não foi possível excluir o trabalho. Tente novamente.');
        }
    }

    // Método para baixar todas as imagens de um trabalho
public function downloadAll($id)
{
    $trabalho = Trabalho::with('imagens')->findOrFail($id);
    
    // Cria um novo arquivo ZIP
    $zip = new ZipArchive();
    $zipName = 'trabalho_' . $trabalho->id . '.zip';
    $zipPath = storage_path('app/public/' . $zipName);

    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
        foreach ($trabalho->imagens as $imagem) {
            $zip->addFile(storage_path('app/public/' . $imagem->imagem), basename($imagem->imagem));
        }
        $zip->close();
    }

    // Retorna o arquivo ZIP para download
    return response()->download($zipPath)->deleteFileAfterSend(true);
}

}
