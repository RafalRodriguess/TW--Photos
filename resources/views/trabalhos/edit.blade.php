@extends('layouts.master')

@push('plugin-styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/css/dropify.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Editar Trabalho</h6>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('trabalhos.update', $trabalho->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Cliente relacionado -->
          <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select class="form-control" name="client_id" required>
              <option value="">Selecione o cliente</option>
              @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ $trabalho->client_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Nome do Trabalho -->
          <div class="mb-3">
            <label class="form-label">Nome do Trabalho</label>
            <input type="text" class="form-control" name="nome" value="{{ $trabalho->nome }}" required>
          </div>

          <!-- Descrição -->
          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao" required>{{ $trabalho->descricao }}</textarea>
          </div>

          <!-- Imagens atuais -->
          <div class="mb-3">
            <label class="form-label">Imagens Atuais</label>
            <div class="row">
              @foreach($trabalho->imagens as $imagem)
                <div class="col-md-3">
                  <div class="image-preview">
                    <img src="{{ asset('storage/' . $imagem->imagem) }}" class="img-fluid mb-2" alt="Imagem do Trabalho">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" name="delete_images[]" value="{{ $imagem->id }}">
                      <label class="form-check-label">Excluir</label>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <!-- Nova Imagem com Dropify -->
          <div class="mb-3">
            <label class="form-label">Adicionar Novas Imagens</label>
            <input type="file" id="myDropify" class="dropify" name="imagens[]" multiple>
          </div>

          <!-- Botão de enviar -->
          <button type="submit" class="btn btn-primary">Salvar Trabalho</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/js/dropify.min.js"></script>
  <script>
    $(document).ready(function() {
      // Inicializa o Dropify
      $('.dropify').dropify();
    });
  </script>
@endpush
