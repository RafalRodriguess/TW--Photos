@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Criar Novo Trabalho</h6>

        <!-- Mensagem de erro -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('trabalhos.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Cliente relacionado -->
          <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select class="form-control" name="client_id" required>
              <option value="">Selecione o cliente</option>
              @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Nome do Trabalho -->
          <div class="mb-3">
            <label class="form-label">Nome do Trabalho</label>
            <input type="text" class="form-control" name="nome" placeholder="Digite o nome do trabalho" required>
          </div>

          <!-- Descrição -->
          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao" placeholder="Digite a descrição do trabalho" required></textarea>
          </div>

          <!-- Imagens -->
          <div class="mb-3">
            <label class="form-label">Imagens</label>
            <input type="file" class="form-control" name="imagens[]" multiple>
          </div>

          <!-- Botão de enviar -->
          <button type="submit" class="btn btn-primary">Salvar Trabalho</button>
          @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        </form>
      </div>
    </div>
  </div>
</div>
@endsection
