@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('financeiro.saida.index') }}">Saídas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Criar Nova Saída para o Banco</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Criar Nova Saída</h6>
        <form action="{{ route('financeiro.saida.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <!-- Campo de Descrição -->
          <div class="form-group">
            <label for="description">Descrição da Saída</label>
            <input type="text" name="description" id="description" class="form-control" placeholder="Ex.: Transferência para conta bancária" required>
          </div>

          <!-- Campo de Valor -->
          <div class="form-group">
            <label for="amount">Valor (€)</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" placeholder="Ex.: 1500.00" required>
          </div>

          <!-- Campo de Comprovante (Opcional) -->
          <div class="form-group">
            <label for="proof">Comprovante (opcional)</label>
            <input type="file" name="proof" id="proof" class="form-control" accept="image/*">
          </div>

          <button type="submit" class="btn btn-primary">Salvar Saída</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
