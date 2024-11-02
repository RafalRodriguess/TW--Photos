<nav class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
      TW<span> Photos</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <!-- Seção Clientes -->
      <li class="nav-item nav-category">Clientes</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#clients" role="button" aria-expanded="false" aria-controls="clients">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Clientes</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="clients">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('clients.index') }}" class="nav-link">Ver Clientes</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('clients.create') }}" class="nav-link">Criar Cliente</a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Seção Trabalhos -->
      <li class="nav-item nav-category">Trabalhos</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#trabalhos" role="button" aria-expanded="false" aria-controls="trabalhos">
          <i class="link-icon" data-feather="briefcase"></i>
          <span class="link-title">Trabalhos</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="trabalhos">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('trabalhos.index') }}" class="nav-link">Ver Trabalhos</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('trabalhos.create') }}" class="nav-link">Criar Novo Trabalho</a>
            </li>
          </ul>
        </div>
      </li>

<!-- Seção Financeiro -->
<li class="nav-item nav-category">Financeiro</li>
<li class="nav-item">
  <a class="nav-link" data-bs-toggle="collapse" href="#financeiro" role="button" aria-expanded="false" aria-controls="financeiro">
    <i class="link-icon" data-feather="dollar-sign"></i>
    <span class="link-title">Transações</span>
    <i class="link-arrow" data-feather="chevron-down"></i>
  </a>
  <div class="collapse" id="financeiro">
    <ul class="nav sub-menu">
      <!-- Entradas com seta para cima -->
      <li class="nav-item">
        <a href="{{ route('financeiro.entrada.index') }}" class="nav-link">
          <i class="link-icon" data-feather="arrow-up-circle"></i>
          <span class="link-title">Entradas</span>
        </a>
      </li>
      <!-- Saídas com seta para baixo -->
      <li class="nav-item">
        <a href="{{ route('financeiro.saida.index') }}" class="nav-link">
          <i class="link-icon" data-feather="arrow-down-circle"></i>
          <span class="link-title">Saídas</span>
        </a>
      </li>
      <!-- Contas Fixas com ícone de "calendário" para representar despesas recorrentes -->
      <li class="nav-item">
        <a href="{{ route('financeiro.contas.index') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Contas Fixas</span>
        </a>
      </li>
    </ul>
  </div>
</li>



      <!-- Seção Agendamentos -->
      <li class="nav-item nav-category">Agendamentos</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#agendamentos" role="button" aria-expanded="false" aria-controls="agendamentos">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Agendamentos</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="agendamentos">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('agendamentos.index') }}" class="nav-link">Ver Agendamentos</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('agendamentos.create') }}" class="nav-link">Criar Novo Agendamento</a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</nav>
