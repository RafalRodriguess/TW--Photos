@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Financeiro</a></li>
    <li class="breadcrumb-item active" aria-current="page">Criar Nova Entrada</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Nova Entrada</h6>
        <form action="{{ route('financeiro.entrada.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="form-group">
            <label for="cliente">Cliente (Opcional)</label>
            <select name="cliente_id" id="cliente" class="form-control">
              <option value="">-- Selecione um Cliente --</option>
              @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="form-group">
            <label for="description">Nome</label>
            <input type="text" name="description" id="description" class="form-control" placeholder="Descrição ou nome da entrada" required>
          </div>

          <div class="form-group">
            <label for="amount">Valor (€)</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" placeholder="Valor em Euros" required>
          </div>

          <div class="form-group">
            <label for="proof">Comprovante (opcional)</label>
            <input type="file" name="proof" id="proof" class="form-control" accept="image/*">
          </div>

          <button type="submit" class="btn btn-primary">Salvar Entrada</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
