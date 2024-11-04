@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Termos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Listagem de Termos</li>
  </ol>
</nav>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h6 class="card-title">Listagem de Termos</h6>
  <a href="{{ route('terms.create') }}" class="btn btn-primary">+ Criar Novo Termo</a>
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
        <h6 class="card-title">Listagem de Termos</h6>
        <p class="text-muted mb-3">Abaixo está a listagem dos termos cadastrados, com a opção de visualização e exclusão.</p>
        
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Cliente</th>
                <th>Data do Termo</th>
                <th>Descrição</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($terms as $term)
                <tr>
                  <td>{{ $term->client->name }}</td>
                  <td>{{ $term->term_date }}</td>
                  <td>{{ Str::limit($term->description, 50) }}</td>
                  <td>
                    <!-- Botão para visualizar o termo -->
                    <a href="{{ route('terms.show', $term->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</a>

                    <!-- Botão para gerar PDF -->
                    <a href="{{ route('terms.generatePDF', $term->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-file-pdf"></i> PDF</a>

                    <!-- Botão para excluir o termo -->
                    <form action="{{ route('terms.destroy', $term->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este termo?')">
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
          "emptyTable": "Nenhum termo disponível",
          "info": "Mostrando _START_ até _END_ de _TOTAL_ termos",
          "infoEmpty": "Mostrando 0 até 0 de 0 termos",
          "lengthMenu": "Mostrar _MENU_ termos por página",
          "search": "Buscar:",
          "zeroRecords": "Nenhum termo encontrado",
          "infoFiltered": "(filtrado de _MAX_ termos no total)"
        }
      });
    });
  </script>
@endpush
