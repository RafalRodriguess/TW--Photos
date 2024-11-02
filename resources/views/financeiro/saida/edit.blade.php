@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('financeiro.saida.index') }}">Saídas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar Saída</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Editar Saída</h6>
        <form action="{{ route('financeiro.saida.update', $saida->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ $saida->description }}" required>
          </div>

          <div class="form-group">
            <label for="amount">Valor (€)</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" value="{{ $saida->amount }}" required>
          </div>

          <div class="form-group">
            <label for="proof">Comprovante (opcional)</label>
            <input type="file" name="proof" id="proof" class="form-control" accept="image/*">
          </div>

          <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
