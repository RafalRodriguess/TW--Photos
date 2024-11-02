@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Bem-vindo ao Dashboard</h4>
  </div>
  <div class="d-flex align-items-center flex-wrap text-nowrap">
    <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
      <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle>
        <i data-feather="calendar" class="text-primary"></i>
      </span>
      
    </div>
  </div>
</div>

<!-- Primeira linha de cards -->
<div class="row">
  <!-- Total de Clientes -->
  <div class="col-md-4 grid-margin stretch-card">
  <div class="card" style="background-color: #6f42c1; color: #fff;">
      <div class="card-body">
        <h6 class="card-title">Lucro do Mês</h6>
        <h3 class="mb-2">
          @if($lucroMes >= 0)
            € {{ number_format($lucroMes, 2, ',', '.') }}
          @else
            <span class="text-danger">-€ {{ number_format(abs($lucroMes), 2, ',', '.') }}</span>
          @endif
        </h3>
        <p class="text-muted" style=>Lucro líquido do mês.</p>
      </div>
    </div>
  </div>
  

  <!-- Faturamento do Dia -->
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card" style="background-color: #6f42c1; color: #fff;">
      <div class="card-body">
        <h6 class="card-title">Entradas do Dia</h6>
        <h3 class="mb-2">€ {{ number_format($faturamentoDia, 2, ',', '.') }}</h3>
        <p class="text-muted">Entradas de hoje.</p>
      </div>
    </div>
  </div>

  <!-- Faturamento do Mês -->
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card" style="background-color: #6f42c1; color: #fff;">
      <div class="card-body">
        <h6 class="card-title">Entradas do Mês</h6>
        <h3 class="mb-2">€ {{ number_format($faturamentoMes, 2, ',', '.') }}</h3>
        <p class="text-muted">Entradas do mês.</p>
      </div>
    </div>
  </div>
</div>

<!-- Segunda linha de cards -->
<div class="row">
  <!-- Saídas do Dia -->
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Saídas do Dia</h6>
        <h3 class="mb-2">€ {{ number_format($saidasDia, 2, ',', '.') }}</h3>
        <p class="text-muted">Saídas de hoje.</p>
      </div>
    </div>
  </div>

  <!-- Saídas do Mês -->
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Saídas do Mês</h6>
        <h3 class="mb-2">€ {{ number_format($saidasMes, 2, ',', '.') }}</h3>
        <p class="text-muted">Saídas do mês.</p>
      </div>
    </div>
  </div>

  <!-- Lucro do Mês -->
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Total de Clientes</h6>
        <h3 class="mb-2">{{ $totalClientes }}</h3>
        <p class="text-muted">Total de clientes cadastrados.</p>
      </div>
    </div>
  </div>
</div> <!-- Fim dos cards -->


<!-- Tabela de Contas Fixas do Mês -->
<!-- Linha de Tabelas: Entradas e Saídas do Dia + Contas Fixas do Mês -->
<div class="row">
  <!-- Tabela de Entradas e Saídas do Dia -->
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Entradas e Saídas do Dia - {{ now()->format('d/m/Y') }}</h6>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Descrição</th>
                <th>Valor (€)</th>
              </tr>
            </thead>
            <tbody>
              <!-- Entradas do Dia -->
              @foreach($dailyEntries as $entry)
                <tr style="background-color: #e0e0e0;">
                  <td>Entrada</td>
                  <td>{{ $entry->description }}</td>
                  <td>€ {{ number_format($entry->amount, 2, ',', '.') }}</td>
                </tr>
              @endforeach

              <!-- Saídas do Dia -->
              @foreach($dailyExpenses as $expense)
                <tr>
                  <td>Saída</td>
                  <td>{{ $expense->description }}</td>
                  <td>€ {{ number_format($expense->amount, 2, ',', '.') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabela de Contas Fixas do Mês -->
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Contas Fixas a Pagar - {{ now()->format('F Y') }}</h6>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Nome da Conta</th>
                <th>Valor (€)</th>
                <th>Data de Vencimento</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($currentMonthExpenses as $expense)
                <tr>
                  <td>{{ $expense->description }}</td>
                  <td>€ {{ number_format($expense->amount, 2, ',', '.') }}</td>
                  <td>{{ \Carbon\Carbon::parse($expense->due_date)->format('d/m/Y') }}</td>
                  <td>
                    @if($expense->status == 'pago')
                      <span class="badge bg-success">Paga</span>
                    @elseif(\Carbon\Carbon::parse($expense->due_date)->isPast())
                      <span class="badge bg-danger">Vencida</span>
                    @else
                      <span class="badge bg-warning">Pendente</span>
                    @endif
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
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script>
    flatpickr("#dashboardDate", {
      dateFormat: "Y-m-d",
      onChange: function(selectedDates, dateStr, instance) {
        window.location.href = `?date=${dateStr}`;
      }
    });
  </script>
@endpush
