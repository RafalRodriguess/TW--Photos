@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Usuários</a></li>
    <li class="breadcrumb-item active" aria-current="page">Listagem de Usuários</li>
  </ol>
</nav>
@section('content')
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
        <h6 class="card-title">Listagem de Usuários</h6>
        <p class="text-muted mb-3">Abaixo está a listagem dos usuários cadastrados. Você pode visualizar, editar ou excluir cada usuário.</p>
        
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Nível</th>
                <th>Ativo</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($usuarios as $user)
                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td></td>
                  <td></td>
                  <td>
                    <!-- Botão para visualizar o usuário -->
                    <a href="{{ route('usuarios.show', $user->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</a>
                    
                    <!-- Botão para editar o usuário -->
                    <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>

                    <!-- Botão para excluir o usuário -->
                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display:inline-block;">
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
          "emptyTable": "Nenhum usuário disponível",
          "info": "Mostrando _START_ até _END_ de _TOTAL_ usuários",
          "infoEmpty": "Mostrando 0 até 0 de 0 usuários",
          "lengthMenu": "Mostrar _MENU_ usuários por página",
          "search": "Buscar:",
          "zeroRecords": "Nenhum usuário encontrado",
          "infoFiltered": "(filtrado de _MAX_ usuários no total)"
        }
      });
    });
  </script>
@endpush
