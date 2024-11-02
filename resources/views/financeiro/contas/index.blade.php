@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Financeiro</a></li>
    <li class="breadcrumb-item active" aria-current="page">Listagem de Contas Fixas</li>
  </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h6 class="card-title">Listagem de Contas Fixas</h6>
  <a href="{{ route('financeiro.contas.create') }}" class="btn btn-primary">+ Adicionar Nova Conta Fixa</a>
</div>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <p class="text-muted mb-3">Abaixo está a listagem das contas fixas registradas. Você pode visualizar o status de pagamento e marcar como paga.</p>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Nome da Conta</th>
                <th>Valor (€)</th>
                <th>Data de Vencimento</th>
                <th>Status</th>
                <th>Comprovante</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($fixedExpenses as $expense)
                <tr>
                  <td>{{ $expense->description }}</td>
                  <td>{{ number_format($expense->amount, 2, ',', '.') }}</td>
                  <td>{{ $expense->due_day }}/{{ now()->format('m/Y') }}</td>
                  <td>
                    @if($expense->status == 'pago')
                        <span class="badge bg-success">Paga</span>
                    @elseif($expense->due_day < now()->day)
                        <span class="badge bg-danger">Vencida</span>
                    @else
                        <span class="badge bg-warning">Pendente</span>
                    @endif
                  </td>
                  <td>
    @if($expense->proof)
        <a href="{{ asset('storage/' . $expense->proof) }}" target="_blank" class="btn btn-info btn-sm">Ver Comprovante</a>
    @else
        <span class="text-muted">Nenhum comprovante</span>
    @endif
</td>

                  <td>
                    @if($expense->status == 'pendente')
                      <form action="{{ route('financeiro.contas.markAsPaid', $expense->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Marcar como paga?')">
                          <i class="fas fa-check"></i> Marcar como Paga
                        </button>
                      </form>
                    @else
                      <button class="btn btn-secondary btn-sm" disabled><i class="fas fa-check"></i> Pago</button>
                    @endif
                    <a href="{{ route('financeiro.contas.edit', $expense->id) }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('financeiro.contas.destroy', $expense->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta conta?')">
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
          "emptyTable": "Nenhuma conta fixa disponível",
          "info": "Mostrando _START_ até _END_ de _TOTAL_ contas fixas",
          "infoEmpty": "Mostrando 0 até 0 de 0 contas fixas",
          "lengthMenu": "Mostrar _MENU_ contas por página",
          "search": "Buscar:",
          "zeroRecords": "Nenhuma conta encontrada",
          "infoFiltered": "(filtrado de _MAX_ contas no total)"
        }
      });
    });
  </script>
@endpush
