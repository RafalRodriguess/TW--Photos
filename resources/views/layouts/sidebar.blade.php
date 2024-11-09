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
      <li class="nav-item nav-category" style="font-weight: bold; font-size: 16px;">Clientes</li>
      <li class="nav-item">
        <a href="{{ route('clients.index') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Listagem de Clientes</span>
        </a>
      </li>
 

      <!-- Seção Trabalhos -->
      <li class="nav-item nav-category" style="font-weight: bold; font-size: 16px;">Trabalhos</li>
      <li class="nav-item">
        <a href="{{ route('trabalhos.index') }}" class="nav-link">
          <i class="link-icon" data-feather="briefcase"></i>
          <span class="link-title">Listagem de Trabalhos</span>
        </a>
      </li>
     

      <!-- Seção Financeiro -->
      <li class="nav-item nav-category" style="font-weight: bold; font-size: 16px;">Financeiro</li>
      <li class="nav-item">
        <a href="{{ route('financeiro.entrada.index') }}" class="nav-link">
          <i class="link-icon" data-feather="arrow-up-circle"></i>
          <span class="link-title">Entradas</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('financeiro.saida.index') }}" class="nav-link">
          <i class="link-icon" data-feather="arrow-down-circle"></i>
          <span class="link-title">Saídas</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('financeiro.contas.index') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Contas Fixas</span>
        </a>
      </li>

      <!-- Seção Usuários -->
      <li class="nav-item nav-category" style="font-weight: bold; font-size: 16px;">Usuários</li>
      <li class="nav-item">
        <a href="{{ route('usuarios.index') }}" class="nav-link">
          <i class="link-icon" data-feather="users"></i>
          <span class="link-title">Listagem de Usuários</span>
        </a>
      </li>

      <!-- Seção Termos -->
      <li class="nav-item nav-category" style="font-weight: bold; font-size: 16px;">Termos</li>
      <li class="nav-item">
        <a href="{{ route('terms.index') }}" class="nav-link">
          <i class="link-icon" data-feather="file-text"></i>
          <span class="link-title">Listagem de Termos</span>
        </a>
      </li>
    <!-- Seção Termos -->
    <li class="nav-item nav-category" style="font-weight: bold; font-size: 16px;">Logs</li>
      <li class="nav-item">
        <a href="{{ route('logs.index') }}" class="nav-link">
          <i class="link-icon" data-feather="info"></i>
          <span class="link-title">Listagem Logs</span>
        </a>
      </li>

    </ul>
  </div>
</nav>
