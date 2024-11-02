@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Financeiro</a></li>
    <li class="breadcrumb-item active" aria-current="page">Adicionar Nova Conta Fixa</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Nova Conta Fixa</h6>
        <form action="{{ route('financeiro.contas.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="description" class="form-label">Nome da Conta</label>
            <input type="text" class="form-control" id="description" name="description" required>
          </div>
          <div class="mb-3">
            <label for="amount" class="form-label">Valor (€)</label>
            <input type="text" class="form-control" id="amount" name="amount" required>
          </div>
          <div class="mb-3">
  <label for="due_day" class="form-label">Dia de Vencimento</label>
  <input type="number" class="form-control" id="due_day" name="due_day" min="1" max="31" required>
</div>

          <button type="submit" class="btn btn-primary">Salvar</button>
          <a href="{{ route('financeiro.contas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
