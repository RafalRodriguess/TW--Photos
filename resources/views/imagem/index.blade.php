@extends('layouts.public')

@section('content')
<div class="container text-center my-4">
    <h2>Seleção de Fotos para Exclusão</h2>
    <p>Clique nas imagens para selecionar ou desmarcar. Em seguida, clique em "Excluir Selecionadas" para remover as imagens.</p>

    <div class="row mt-4">
        @foreach($trabalho->imagens as $imagem)
            <div class="col-md-4 mb-4">
                <div class="card image-card" data-image-id="{{ $imagem->id }}">
                    <img src="{{ asset('storage/' . $imagem->imagem) }}" class="card-img-top img-selectable" alt="Imagem do Trabalho">
                    <div class="card-body text-center">
                        <span class="check-icon" style="display: none;">&#10003; Selecionada</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Botão para excluir as imagens selecionadas -->
    <button id="deleteSelection" class="btn btn-danger mt-4">Excluir Selecionadas</button>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectedImages = new Set();

    // Ação ao clicar nas imagens para seleção
    document.querySelectorAll('.img-selectable').forEach(img => {
        img.addEventListener('click', function () {
            const imageId = this.closest('.image-card').dataset.imageId;
            const checkIcon = this.nextElementSibling.querySelector('.check-icon');

            if (selectedImages.has(imageId)) {
                selectedImages.delete(imageId);
                checkIcon.style.display = 'none';
            } else {
                selectedImages.add(imageId);
                checkIcon.style.display = 'block';
            }
        });
    });

    // Ação do botão para excluir as imagens selecionadas
    document.getElementById('deleteSelection').addEventListener('click', function () {
        if (selectedImages.size === 0) {
            alert('Selecione pelo menos uma imagem para excluir.');
            return;
        }

        if (confirm('Tem certeza de que deseja excluir as imagens selecionadas?')) {
            fetch("{{ route('selecionar-imagens.excluir', $trabalho->token) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ imagens: Array.from(selectedImages) })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Recarrega a página para atualizar a lista de imagens
                } else {
                    alert('Erro ao excluir as imagens.');
                }
            })
            .catch(error => console.error('Erro:', error));
        }
    });
});
</script>

<style>
    .img-selectable {
        cursor: pointer;
    }
    .check-icon {
        color: red;
        font-weight: bold;
    }
</style>
@endpush
