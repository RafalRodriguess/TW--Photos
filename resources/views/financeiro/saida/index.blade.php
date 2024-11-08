@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Financeiro</a></li>
    <li class="breadcrumb-item active" aria-current="page">Listagem de Saídas</li>
  </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h6 class="card-title">Listagem de Saídas</h6>
  <a href="{{ route('financeiro.saida.create') }}" class="btn btn-primary">+ Criar Nova Saída</a>
</div>

<div class="row">
  <div class="col-md-12">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
  </div>
</div>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <p class="text-muted mb-3">Abaixo está a listagem das saídas financeiras registradas. Você pode visualizar ou baixar o comprovante de cada saída.</p>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Descrição</th>
                <th>Valor (€)</th>
                <th>Data</th>
                <th>Comprovante</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($saidas as $saida)
                <tr>
                  <td>{{ $saida->description }}</td>
                  <td>{{ number_format($saida->amount, 2, ',', '.') }}</td>
                  <td>{{ $saida->created_at->format('d/m/Y') }}</td>
                  <td>
                    @if($saida->proof)
                      <a href="{{ asset('storage/' . $saida->proof) }}" class="btn btn-info btn-sm" target="_blank">
                        <i class="fas fa-download"></i> Baixar Comprovante
                      </a>
                    @else
                      <span class="text-muted">Nenhum comprovante</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('financeiro.saida.edit', $saida->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>
                    <form action="{{ route('financeiro.saida.destroy', $saida->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta saída?')">
                        <i class="fas fa-trash-alt"></i> Excluir
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
@endpush

@push('custom-scripts')
  <script>
    $(document).ready(function() {
      $('#dataTableExample').DataTable({
        "language": {
          "paginate": {
            "previous": "Anterior",
            "next": "Próximo"
          },
          "emptyTable": "Nenhuma saída disponível",
          "info": "Mostrando _START_ até _END_ de _TOTAL_ saídas",
          "infoEmpty": "Mostrando 0 até 0 de 0 saídas",
          "lengthMenu": "Mostrar _MENU_ saídas por página",
          "search": "Buscar:",
          "zeroRecords": "Nenhuma saída encontrada",
          "infoFiltered": "(filtrado de _MAX_ saídas no total)"
        }
      });
    });
  </script>
@endpush
