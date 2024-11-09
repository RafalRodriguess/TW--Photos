<?php

namespace App\Http\Controllers;
use App\Models\Log;
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

 
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'create_user',
            'description' => 'Usuario criado: ' . $request->input('name')
        ]);

        
        return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function show($id)
    {
        $user = User::findOrFail($id); 
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
    
        Log::create([
            'user_id' => auth()->id(),
            'action' => 'edit_user',
            'description' => 'Usuário editado: ' . $usuarios->name
        ]);


       
        return redirect()->route('usuarios.index')->with('success', 'Usuario atualizado com sucesso!');
    }

public function destroy($id)
    {
        
        $usuarios = User::findOrFail($id);

        
        $usuarios->delete();

        Log::create([
            'user_id' => auth()->id(),
            'action' => 'delete_user',
            'description' => 'Usuário deletado: ' . $usuarios->name
        ]);
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario excluído com sucesso!');
    }
}

