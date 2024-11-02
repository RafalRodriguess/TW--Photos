@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Financeiro</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Conta Fixa</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Editar Conta Fixa</h6>
        <form action="{{ route('financeiro.contas.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="description" class="form-label">Nome da Conta</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $expense->description }}" required>
          </div>
          <div class="mb-3">
            <label for="amount" class="form-label">Valor (€)</label>
            <input type="text" class="form-control" id="amount" name="amount" value="{{ $expense->amount }}" required>
          </div>
          <div class="mb-3">
            <label for="proof" class="form-label">Comprovante</label>
            <input type="file" class="form-control" id="proof" name="proof">
            @if($expense->proof)
              <a href="{{ asset('storage/' . $expense->proof) }}" target="_blank" class="d-block mt-2">Visualizar Comprovante Atual</a>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Salvar Alterações</button>
          <a href="{{ route('financeiro.contas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
