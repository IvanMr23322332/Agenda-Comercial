  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <nav class="navbar navbar-expand-lg custom-navbar">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#WafiAdminNavbar" aria-controls="WafiAdminNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
          <i></i>
          <i></i>
          <i></i>
        </span>
      </button>
      <div class="collapse navbar-collapse" id="WafiAdminNavbar">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="carteraDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-briefcase nav-icon"></i>
                Cartera
              </a>
              <ul class="dropdown-menu" aria-labelledby="carteraDropdown">
                <li>
                  <a class="dropdown-item" href="/agenda">Agenda</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/clientes_tabla">Tabla de Clientes</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/potenciales_tabla">Tabla de Potenciales</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/users_info/{{$_SESSION['id_ase']}}">Análisis</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/users_ratio/{{$_SESSION['id_ase']}}">Ratios</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/analisis_cartera">Análisis de Cartera</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="presupuestoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-edit1 nav-icon"></i>
                Presupuestos
              </a>
              <ul class="dropdown-menu" aria-labelledby="presupuestoDropdown">
                <li>
                  <a class="dropdown-item" href="/form_presupuesto">Crear Presupuesto</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/buzon_presupuesto">Buzón de Presupuestos</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/historico_presupuesto">Historico de Presupuestos</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="clientesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-user1 nav-icon"></i>
                Clientes
              </a>
              <ul class="dropdown-menu" aria-labelledby="clientesDropdown">
                <li>
                  <a class="dropdown-item" href="/clientes_crear">Incorporar a Cartera</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/clientes_buzon">Validaciones</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/clientes_bajas">Solicitud de Baja</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/clientes_cartera">Carterización</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="ventasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-layers2 nav-icon"></i>
                Ventas
              </a>
              <ul class="dropdown-menu" aria-labelledby="ventasDropdown">
                <li>
                  <a class="dropdown-item" href="/table">Reporte sobre Ventas</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/ventas_presupuesto">Historico de Ventas</a>
                </li>

              </ul>
            </li>
            @if ($_SESSION['status'] == 'admin')
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="acccomDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-monitor nav-icon"></i>
                    Administrador
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="acccomDropdown">
                    <li>
                      <a class="dropdown-item" href="/admin_accion_comercial">Administrar Acc. Com.</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="/admin_tarifas">Administrar Tarifas</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="/admin_users">Administrar Usuarios</a>
                    </li>
                  </ul>
                </li>
            @endif
        </ul>
      </div>
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <div class="custom-search" style="float: right;">
          <input list="brow_cli" id="a_buscar" type="text" class="search-query" placeholder="Buscar cliente ...">
          <datalist id="brow_cli" style="display:none">

          </datalist>
          <i class="icon-search1" onclick="busqueda_cliente()"></i>
      </div>
    </nav>
