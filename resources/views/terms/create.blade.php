@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-md-12 stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Cadastrar Novo Termo</h6>
        <form action="{{ route('terms.store') }}" method="POST">
          @csrf

          <!-- Campo Cliente -->
          <div class="form-group">
            <label for="client_id">Cliente</label>
            <select name="client_id" id="client_id" class="form-control" required>
              <option value="">Selecione o Cliente</option>
              @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Campo Data do Termo -->
          <div class="form-group mt-3">
            <label for="term_date">Data do Termo</label>
            <input type="date" name="term_date" id="term_date" class="form-control" required>
          </div>

          <!-- Campo Finalidade do Termo (Fixado como Direito de Imagem) -->
          <div class="form-group mt-3">
            <label for="purpose">Finalidade do Termo</label>
            <input type="text" name="purpose" id="purpose" class="form-control" value="Direito de Imagem" readonly>
          </div>

          <!-- Campo Descrição -->
          <div class="form-group mt-3">
            <label for="description">Descrição</label>
            <textarea name="description" id="description" class="form-control" placeholder="Descreva os detalhes do termo" required></textarea>
          </div>

          <!-- Botão de Submit -->
          <button type="submit" class="btn btn-primary mt-3">Cadastrar Termo</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
