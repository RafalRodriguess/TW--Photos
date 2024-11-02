<!-- resources/views/trabalhos/index.blade.php -->

@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Trabalhos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Listagem de Trabalhos</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Listagem de Trabalhos</h6>
        <p class="text-muted mb-3">Abaixo está a listagem dos trabalhos cadastrados. Você pode visualizar, editar ou excluir cada trabalho.</p>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Cliente</th>
                <th>Nome do Trabalho</th>
                <th>Descrição</th>
                <th>Data de Criação</th>
                <th>URL de Visualização</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($trabalhos as $trabalho)
                <tr>
                  <td>{{ $trabalho->cliente->name }}</td>
                  <td>{{ $trabalho->nome }}</td>
                  <td>{{ $trabalho->descricao }}</td>
                  <td>{{ $trabalho->created_at->format('d/m/Y') }}</td>
                  <td>
                    <a href="{{ url('visualizar/' . $trabalho->id) }}" target="_blank">
                      {{ url('visualizar/' . $trabalho->id) }}
                    </a>
                  </td>
                  <td>
                    <a href="{{ route('trabalhos.show', $trabalho->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                    <a href="{{ route('trabalhos.edit', $trabalho->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('trabalhos.destroy', $trabalho->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este trabalho?')">
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
          "emptyTable": "Nenhum trabalho disponível",
          "info": "Mostrando _START_ até _END_ de _TOTAL_ trabalhos",
          "infoEmpty": "Mostrando 0 até 0 de 0 trabalhos",
          "lengthMenu": "Mostrar _MENU_ trabalhos por página",
          "search": "Buscar:",
          "zeroRecords": "Nenhum trabalho encontrado",
          "infoFiltered": "(filtrado de _MAX_ trabalhos no total)"
        }
      });
    });
  </script>
@endpush
