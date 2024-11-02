@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clientes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detalhes do Cliente</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Detalhes do Cliente</h6>
        
        <!-- Informações do Cliente -->
        <p><strong>Nome:</strong> {{ $client->name }}</p>
        <p><strong>Email:</strong> {{ $client->email }}</p>
        <p><strong>Telefone:</strong> {{ $client->phone }}</p>
        <p><strong>Endereço:</strong> {{ $client->address ?? 'Não informado' }}</p>
        <p><strong>Contribuinte:</strong> {{ $client->contributor ?? 'Não informado' }}</p>

        <!-- Entradas do Cliente -->
        <h6 class="mt-4">Pagamentos (Entradas)</h6>
        @if($client->entries->isEmpty())
          <p>Nenhum pagamento registrado para este cliente.</p>
        @else
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Valor (€)</th>
                  <th>Descrição</th>
                </tr>
              </thead>
              <tbody>
                @foreach($client->entries as $entry)
                  <tr>
                    <td>{{ $entry->created_at->format('d/m/Y') }}</td>
                    <td>€ {{ number_format($entry->amount, 2, ',', '.') }}</td>
                    <td>{{ $entry->description }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif

        <a href="{{ route('clients.index') }}" class="btn btn-secondary mt-3">Voltar</a>
      </div>
    </div>
  </div>
</div>
@endsection
