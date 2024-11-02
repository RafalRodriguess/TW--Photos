<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $usuarios = User::all();  
        return view('usuarios.index', compact('usuarios'));  
    }


    public function create()
    {
        return view('usuarios.create'); 
    }

    // Método para processar o formulário de criação e salvar o usuário
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Criação do usuário
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redireciona ou exibe uma mensagem de sucesso
        return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function show($id)
    {
        $user = User::findOrFail($id); // Busca o usuário pelo ID ou retorna um erro 404 se não for encontrado
        return view('usuarios.show', compact('user'));
    }

    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('usuarios.edit', compact('user'));
    }
    

    public function update(Request $request, $id)
    {
        $usuarios = User::findOrFail($id);
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuarios->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        // Atualiza os dados do usuário, incluindo a senha se for fornecida
        $usuarios->name = $validated['name'];
        $usuarios->email = $validated['email'];
    
        if (!empty($validated['password'])) {
            $usuarios->password = Hash::make($validated['password']);
        }
    
        $usuarios->save();
    
        // Redireciona de volta para a listagem de clientes com uma mensagem de sucesso
        return redirect()->route('usuarios.index')->with('success', 'Usuario atualizado com sucesso!');
    }

public function destroy($id)
    {
        
        $usuarios = User::findOrFail($id);

        
        $usuarios->delete();

        
        return redirect()->route('usuarios.index')->with('success', 'Usuario excluído com sucesso!');
    }
}

