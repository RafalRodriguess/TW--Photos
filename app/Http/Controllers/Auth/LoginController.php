<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Ajuste para o caminho correto se necessário
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tentativa de login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            // Redirecionar para o dashboard
            return redirect()->route('dashboard');
        }

        // Redirecionar de volta com um erro
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ])->onlyInput('email');
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/'); 
    }
    public function store(Request $request): RedirectResponse
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Adicionando log
        Log::info('Usuário logado: ' . $request->email);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    // Adicionando log de falha
    Log::warning('Falha ao logar usuário: ' . $request->email);

    return back()->withErrors([
        'email' => 'As credenciais fornecidas estão incorretas.',
    ]);
}
}
