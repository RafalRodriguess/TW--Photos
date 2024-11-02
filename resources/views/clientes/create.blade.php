@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-md-12 stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Cadastrar Novo Cliente</h6>
        <form action="{{ route('clients.store') }}" method="POST">
          @csrf

          <!-- Primeira linha do formulário: Nome e Email -->
          <div class="row">
            <div class="col-sm-6">
              <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Digite o nome" required>
              </div>
            </div><!-- Col -->
            <div class="col-sm-6">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Digite o email" required>
              </div>
            </div><!-- Col -->
          </div><!-- Row -->

          <!-- Segunda linha: País e Telefone -->
          <div class="row">
            <div class="col-sm-6">
              <div class="mb-3">
                <label class="form-label">País</label>
                <select class="form-control" name="country">
                  <option value="">Selecione o país</option>
                  <option value="Brasil">Brasil</option>
                  <option value="Portugal">Portugal</option>
                  <option value="Estados Unidos">Estados Unidos</option>
                  <!-- Adicione mais opções conforme necessário -->
                </select>
              </div>
            </div><!-- Col -->
            <div class="col-sm-6">
              <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Digite o telefone" required>
              </div>
            </div><!-- Col -->
          </div><!-- Row -->

          <!-- Terceira linha: Endereço -->
          <div class="row">
            <div class="col-sm-12">
              <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Digite o endereço">
              </div>
            </div><!-- Col -->
          </div><!-- Row -->

          <!-- Quarta linha: Contribuinte -->
          <div class="row">
            <div class="col-sm-12">
              <div class="mb-3">
                <label class="form-label">Contribuinte (Opcional)</label>
                <input type="text" class="form-control" name="contributor" value="{{ old('contributor') }}" placeholder="Digite o número de contribuinte">
              </div>
            </div><!-- Col -->
          </div><!-- Row -->

          <!-- Botão de submit -->
          <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
