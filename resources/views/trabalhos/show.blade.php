@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('trabalhos.index') }}">Trabalhos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detalhes do Trabalho</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Detalhes do Trabalho</h6>
        
        <div class="form-group mb-3">
          <label><strong>Cliente:</strong></label>
          <input type="text" class="form-control" value="{{ $trabalho->cliente->name }}" disabled>
        </div>

        <div class="form-group mb-3">
          <label><strong>Nome do Trabalho:</strong></label>
          <input type="text" class="form-control" value="{{ $trabalho->nome }}" disabled>
        </div>

        <div class="form-group mb-3">
          <label><strong>Descrição:</strong></label>
          <textarea class="form-control" disabled>{{ $trabalho->descricao }}</textarea>
        </div>

        <div class="form-group mb-3">
          <label><strong>Data de Criação:</strong></label>
          <input type="text" class="form-control" value="{{ $trabalho->created_at->format('d/m/Y') }}" disabled>
        </div>

        <h6 class="mt-4">Seleção de Imagens para Exclusão</h6>
        <form action="{{ route('trabalhos.deleteImages', $trabalho->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <div class="row">
            @foreach($trabalho->imagens as $imagem)
              <div class="col-md-4 mb-3">
                <div class="card">
                  <img src="{{ asset('storage/' . $imagem->imagem) }}" class="card-img-top" alt="Imagem do Trabalho">
                  <div class="card-body text-center">
                    <!-- Checkbox para selecionar a imagem para exclusão -->
                    <input type="checkbox" name="delete_images[]" value="{{ $imagem->id }}" id="imagem_{{ $imagem->id }}">
                    <label for="imagem_{{ $imagem->id }}">Selecionar para excluir</label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <!-- Botão para confirmar exclusão das imagens selecionadas -->
          <button type="submit" class="btn btn-danger mt-3">Excluir Imagens Selecionadas</button>
        </form>

        <h6 class="mt-4"></h6>
        <a href="{{ route('trabalhos.downloadAll', $trabalho->id) }}" class="btn btn-primary mb-3">
          <i class="fas fa-download"></i> Baixar Álbum Completo
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
