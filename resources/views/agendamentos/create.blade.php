@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Criar Agendamento</h6>

                <form action="{{ route('agendamentos.store') }}" method="POST">
                    @csrf

                    <!-- Seleção de Cliente -->
                    <div class="mb-3">
    <label for="cliente" class="form-label">Cliente</label>
    <select class="form-control" name="cliente_id" id="cliente" required>
        <option value="">Selecione o cliente</option>
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
        @endforeach
    </select>
</div>

                    <!-- Data do Agendamento -->
                    <div class="mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control" name="data" id="data" required>
                    </div>

                    <!-- Observação -->
                    <div class="mb-3">
                        <label for="observacao" class="form-label">Observação</label>
                        <textarea class="form-control" name="observacao" id="observacao"></textarea>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Botão de Salvar -->
                    <button type="submit" class="btn btn-primary">Salvar Agendamento</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
