<?php
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController; 
use App\Http\Controllers\TrabalhoController; 
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FixedExpenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageSelectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
Use App\Http\Controllers\UserController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\LogController;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Rotas para clientes
Route::get('/clients', [ClientController::class, 'index'])->middleware(['auth'])->name('clients.index');
Route::get('/clients/create', [ClientController::class, 'create'])->middleware(['auth'])->name('clients.create');
Route::post('/clients', [ClientController::class, 'store'])->middleware(['auth'])->name('clients.store');
Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->middleware(['auth'])->name('clients.edit');
Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->middleware(['auth'])->name('clients.destroy');
Route::get('clients/{id}', [ClientController::class, 'show'])->name('clients.show');


// Rotas para trabalhos
Route::get('/trabalhos', [TrabalhoController::class, 'index'])->middleware(['auth'])->name('trabalhos.index');
Route::get('/trabalhos/create', [TrabalhoController::class, 'create'])->middleware(['auth'])->name('trabalhos.create');
Route::post('/trabalhos', [TrabalhoController::class, 'store'])->middleware(['auth'])->name('trabalhos.store');
Route::get('/trabalhos/{id}/edit', [TrabalhoController::class, 'edit'])->middleware(['auth'])->name('trabalhos.edit');
Route::get('/trabalhos/{id}', [TrabalhoController::class, 'show'])->middleware(['auth'])->name('trabalhos.show');
Route::put('/trabalhos/{id}', [TrabalhoController::class, 'update'])->middleware(['auth'])->name('trabalhos.update');
Route::get('/trabalhos/{id}/download', [TrabalhoController::class, 'downloadAll'])->middleware(['auth'])->name('trabalhos.downloadAll');
Route::delete('/trabalhos/{id}', [TrabalhoController::class, 'destroy'])->middleware(['auth'])->name('trabalhos.destroy');
Route::get('/visualizar/{token}', [TrabalhoController::class, 'visualizar'])->name('trabalhos.visualizar');
Route::delete('trabalhos/{id}/delete-images', [TrabalhoController::class, 'deleteImages'])->name('trabalhos.deleteImages');

Route::delete('trabalhos/{id}/delete-selected-images', [TrabalhoController::class, 'deleteSelectedImages'])->name('trabalhos.deleteSelectedImages');

//Rotas para agendamentos
Route::get('/agendamentos', [AgendamentoController::class, 'index'])->name('agendamentos.index');
Route::get('/agendamentos/create', [AgendamentoController::class, 'create'])->name('agendamentos.create');
Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamentos.store');
Route::get('/agendamentos/{agendamento}', [AgendamentoController::class, 'show'])->name('agendamentos.show');
Route::get('/agendamentos/{agendamento}/edit', [AgendamentoController::class, 'edit'])->name('agendamentos.edit');
Route::put('/agendamentos/{agendamento}', [AgendamentoController::class, 'update'])->name('agendamentos.update');
Route::delete('/agendamentos/{agendamento}', [AgendamentoController::class, 'destroy'])->name('agendamentos.destroy');


//Rotas para Transacoes

//Entradas
Route::get('/financeiro/entrada', [TransactionController::class, 'index'])->name('financeiro.entrada.index');
Route::get('/financeiro/entrada/create', [TransactionController::class, 'create'])->name('financeiro.entrada.create');
Route::post('/financeiro/entrada', [TransactionController::class, 'store'])->name('financeiro.entrada.store');
Route::get('/financeiro/entrada/{id}/edit', [TransactionController::class, 'edit'])->name('financeiro.entrada.edit');
Route::put('/financeiro/entrada/{id}', [TransactionController::class, 'update'])->name('financeiro.entrada.update');
Route::delete('/financeiro/entrada/{id}', [TransactionController::class, 'destroy'])->name('financeiro.entrada.destroy');

//Saidas
Route::get('/financeiro/saida', [TransactionController::class, 'saidaIndex'])->name('financeiro.saida.index');
Route::get('/financeiro/saida/create', [TransactionController::class, 'saidaCreate'])->name('financeiro.saida.create');
Route::post('/financeiro/saida', [TransactionController::class, 'saidaStore'])->name('financeiro.saida.store');
Route::get('/financeiro/saida/{id}/edit', [TransactionController::class, 'saidaEdit'])->name('financeiro.saida.edit');
Route::put('/financeiro/saida/{id}', [TransactionController::class, 'saidaUpdate'])->name('financeiro.saida.update');
Route::delete('/financeiro/saida/{id}', [TransactionController::class, 'saidaDestroy'])->name('financeiro.saida.destroy');

Route::get('/logs', [LogController::class, 'index'])->name('logs.index');



//Contas Fixas
Route::prefix('financeiro/contas')->group(function () {
    Route::get('/', [FixedExpenseController::class, 'index'])->name('financeiro.contas.index');
    Route::get('/create', [FixedExpenseController::class, 'create'])->name('financeiro.contas.create');
    Route::post('/', [FixedExpenseController::class, 'store'])->name('financeiro.contas.store');
    Route::get('/{id}/edit', [FixedExpenseController::class, 'edit'])->name('financeiro.contas.edit');
    Route::put('/{id}', [FixedExpenseController::class, 'update'])->name('financeiro.contas.update');
    Route::delete('/{id}', [FixedExpenseController::class, 'destroy'])->name('financeiro.contas.destroy');
    Route::put('/{id}/mark-as-paid', [FixedExpenseController::class, 'markAsPaid'])->name('financeiro.contas.markAsPaid');
});


Route::get('/calendar', [CalendarController::class, 'showCalendar']);
Route::get('/calendar/events', [CalendarController::class, 'getGoogleCalendarEvents']);
Route::get('/auth/google', [CalendarController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [CalendarController::class, 'handleGoogleCallback']);
// Rota para redirecionar para o Google OAuth
Route::get('/auth/google', [CalendarController::class, 'redirectToGoogle'])->name('google.login');

// Rota para o callback do Google
Route::get('/auth/google/callback', [CalendarController::class, 'handleGoogleCallback']);

// Rota para exibir o calendário, acessível após a autenticação
Route::get('/calendar/index', [CalendarController::class, 'showCalendar'])->name('calendar.index');
Route::get('/calendar/events', [CalendarController::class, 'getGoogleCalendarEvents'])->name('calendar.events');
Route::post('/calendar/events', [CalendarController::class, 'createGoogleCalendarEvent'])->name('calendar.createEvent');
Route::delete('/calendar/events/{id}', [CalendarController::class, 'destroy'])->name('calendar.destroy');


// Rotas para Usuários
Route::get('/usuarios/criar', [UserController::class, 'create'])->name('usuarios.create'); 
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index'); 
Route::get('/usuarios/show/{id}', [UserController::class, 'show'])->name('usuarios.show');
Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit'); 
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');  
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');



//Rotas para Termos
Route::get('/terms/create', [TermController::class, 'create'])->name('terms.create'); 
Route::resource('terms', TermController::class);
Route::get('terms/{id}/generatePDF', [TermController::class, 'generatePDF'])->name('terms.generatePDF');
Route::delete('/terms/{id}', [TermController::class, 'destroy'])->name('terms.destroy');

// Rotas para o perfil, acessíveis apenas para usuários autenticados
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Inclui as rotas de autenticação geradas pelo Breeze
require __DIR__.'/auth.php';
