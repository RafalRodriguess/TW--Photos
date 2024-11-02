@extends('layouts.public')

@section('content')
<div class="container text-center my-4">
    <h2>Visualização e Exclusão de Fotos</h2>
    <p>Selecione as imagens que deseja excluir e clique em "Excluir Selecionados".</p>

    <!-- Formulário para seleção de imagens -->
    <form action="{{ route('trabalhos.deleteSelectedImages', $trabalho->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="row mt-4">
            @foreach($trabalho->imagens as $imagem)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $imagem->imagem) }}" class="card-img-top" alt="Imagem do Trabalho">
                        <div class="card-body text-center">
                            <!-- Checkbox para seleção da imagem -->
                            <input type="checkbox" name="delete_images[]" value="{{ $imagem->id }}" id="imagem_{{ $imagem->id }}">
                            <label for="imagem_{{ $imagem->id }}">Selecionar para excluir</label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Botão para confirmar exclusão das imagens selecionadas -->
        <button type="submit" class="btn btn-danger mt-4">Excluir Selecionados</button>
    </form>
</div>
@endsection
