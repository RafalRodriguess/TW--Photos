@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Usuario</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detalhes do Usuario</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Detalhes do Usuario</h6>
        
        <!-- Informações do Cliente -->
        <p><strong>Nome:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>


        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">Voltar</a>
      </div>
    </div>
  </div>
</div>
@endsection
