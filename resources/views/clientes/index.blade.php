@extends('layouts.master') <!-- Usa o layout principal -->

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Clientes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Listagem de Clientes</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Listagem de Clientes</h6>
        <p class="text-muted mb-3">Abaixo está a listagem dos clientes cadastrados. Você pode visualizar, editar ou excluir cada cliente.</p>
        
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Data de Criação</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clients as $client)
                <tr>
                  <td>{{ $client->name }}</td>
                  <td>{{ $client->email }}</td>
                  <td>{{ $client->phone }}</td>
                  <td>{{ $client->created_at->format('d/m/Y') }}</td>
                  <td>
                    <!-- Botão para visualizar o cliente -->
                    <a href="{{ route('clients.show', $client->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</a>
                    
                    <!-- Botão para editar o cliente -->
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>

                    <!-- Botão para excluir o cliente -->
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta entrada?')">
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
          "emptyTable": "Nenhum cliente disponível",
          "info": "Mostrando _START_ até _END_ de _TOTAL_ clientes",
          "infoEmpty": "Mostrando 0 até 0 de 0 clientes",
          "lengthMenu": "Mostrar _MENU_ clientes por página",
          "search": "Buscar:",
          "zeroRecords": "Nenhum cliente encontrado",
          "infoFiltered": "(filtrado de _MAX_ clientes no total)"
        }
      });
    });
  </script>
@endpush
