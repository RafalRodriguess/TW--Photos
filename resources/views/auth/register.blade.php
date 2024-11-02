@extends('layouts.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pe-md-0">
            <div class="auth-side-wrapper" style="background-image: url({{ url('https://via.placeholder.com/219x452') }})">
            </div>
          </div>
          <div class="col-md-8 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo d-block mb-2">Noble<span>UI</span></a>
              <h5 class="text-muted fw-normal mb-4">Crie uma conta gratuita.</h5>
              <form class="forms-sample" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nome</label>
                  <input type="text" class="form-control" name="name" id="name" autocomplete="name" placeholder="Nome" required>
                </div>
                <div class="mb-3">
                  <label for="userEmail" class="form-label">Endereço de e-mail</label>
                  <input type="email" class="form-control" name="email" id="userEmail" placeholder="E-mail" required>
                </div>
                <div class="mb-3">
                  <label for="userPassword" class="form-label">Senha</label>
                  <input type="password" class="form-control" name="password" id="userPassword" autocomplete="current-password" placeholder="Senha" required>
                </div>
                <div>
                  <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0">Cadastrar</button>
                </div>
                <a href="{{ url('/auth/login') }}" class="d-block mt-3 text-muted">Já é um usuário? Entre</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
