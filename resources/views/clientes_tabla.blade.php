@extends('layouts.app')

@section('section')

  <!-- Container fluid start -->
  <div class="container-fluid">

    <!-- Navigation start -->
    @include('layouts.nav')
    <!-- Navigation end -->


    <!-- *************
      ************ Main container start *************
    ************* -->
    <div class="main-container">


      <!-- Page header start -->
      <div class="page-header">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Cartera</li>
          <li class="breadcrumb-item active">Tabla de Clientes</li>
        </ol>

        <ul class="app-actions">
          <li>
            <a href="#" id="reportrange">
              <span class="range-text"></span>
              <i class="icon-chevron-down"></i>
            </a>
          </li>
          <li>
            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print">
              <i class="icon-print"></i>
            </a>
          </li>
          <li>
            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download CSV">
              <i class="icon-cloud_download"></i>
            </a>
          </li>
        </ul>
      </div>
      <!-- Page header end -->



      <!-- Content wrapper start -->
      <div class="content-wrapper">
        <!-- Row start -->
        <div class="row gutters">
          <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">Cartera</div>
              </div>
              <div class="card-body">
                <ul class="custom-list2">
                  <li>
                    <a href="/agenda">Agenda</a>
                  </li>
                  <li>
                    <a href="/clientes_tabla">Tabla de Clientes</a>
                  </li>
                  <li>
                    <a href="/potenciales_tabla">Tabla de Potenciales</a>
                  </li>
                  <li>
                    <a href="/users_info/{{$_SESSION['id_ase']}}">Análisis</a>
                  </li>
                  <li>
                    <a href="/users_ratio/{{$_SESSION['id_ase']}}">Ratios</a>
                  </li>
                  <li>
                    <a href="/analisis_cartera">Análisis de Cartera</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
            <div class="card">
              <div class="card-header">
                  <form action="{{url('filtrar_clientes')}}" method="POST" name="filtrar_clientes">
                      @csrf
                      @if (isset($array['cliente_buscador']))
                          <div class="form-group" style="width: 50%;display: block; margin:auto;">
    					  	  <div class="input-group">
    					  	  	  <input list="brow" id="cliente_buscador" class="form-control" name="cliente_buscador" onchange="filtrar_cliente()" value="{{$array['cliente_buscador']}}">
    					  	  	  <div class="input-group-append">
    					  	  	  	  <a href="" class="collapsed" data-toggle="collapse" data-target="#defaultAccordionCollapseOne" aria-expanded="false" aria-controls="defaultAccordionCollapseOne"><button class="btn btn-info">Filtros</button></a>
    					  	  	  </div>
    					  	  </div>
    					  </div>
                      @else
                          <div class="form-group" style="width: 50%;display: block; margin:auto;">
    					  	  <div class="input-group">
    					  	  	  <input list="brow" id="cliente_buscador" class="form-control" name="cliente_buscador" onchange="filtrar_cliente()">
    					  	  	  <div class="input-group-append">
    					  	  	  	  <a href="" class="collapsed" data-toggle="collapse" data-target="#defaultAccordionCollapseOne" aria-expanded="false" aria-controls="defaultAccordionCollapseOne"><button class="btn btn-info">Filtros</button></a>
    					  	  	  </div>
    					  	  </div>
    					  </div>
                      @endif

                      <datalist id="brow" >
                          @foreach ($clientes as $cliente)
                              <option value="{{$cliente->cli_anu}}"></option>
                          @endforeach
                      </datalist>
                      <div class="accordion" id="defaultAccordion" style="width: 50%; display: block; margin:auto;">
                          <div class="accordion-container">
                              {{-- <a href="" class="collapsed" data-toggle="collapse" data-target="#defaultAccordionCollapseOne" aria-expanded="false" aria-controls="defaultAccordionCollapseOne">
                                  <div class="accordion-header" id="defaultAccordionOne">
                                       <b>FILTROS</b>
                                  </div>
                              </a> --}}
                              <div id="defaultAccordionCollapseOne" class="collapse" aria-labelledby="defaultAccordionOne" data-parent="#defaultAccordion">
                                  <div class="accordion-body">
                                      <div class="row gutters">
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                              <div class="form-group">
                                                  <label for="filtroFechaIni">Fecha Inicial</label>
                                                  @if (isset($array['iniFecha']))
                                                      <input type="date" id="iniFecha" name="iniFecha"  class="form-control" value="{{$array['iniFecha']}}">
                                                  @else
                                                      <input type="date" id="iniFecha" name="iniFecha"  class="form-control">
                                                  @endif
                                              </div>
                                          </div>
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                              <div class="form-group">
                                                  <label for="filtroFechaFin">Fecha Final</label>
                                                  @if (isset($array['finFecha']))
                                                      <input type="date" id="finFecha" name="finFecha"  class="form-control" value="{{$array['finFecha']}}">
                                                  @else
                                                      <input type="date" id="finFecha" name="finFecha"  class="form-control">
                                                  @endif
                                              </div>
                                          </div>
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                              {{-- <div class="form-group" style="display: none;">
                                                  <label for="filtroPeriodo">Periodo</label>
                                                  @if (isset($array['iniFecha']))
                                                  @else
                                                  @endif
                                                  <select class="form-control"  tabindex="-98" id="periodo" name="periodo">
                                                      <option value="">-- NO APLICAR --</option>
                                                      <option value="1">Este año</option>
                                                  </select>
                                              </div> --}}
                                          </div>
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12"></div>
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                              <div class="form-group">
                                                  <label for="filtroHaContratado">¿Ha contratado?</label>
                                                  @if (isset($array['ha_contratado']))
                                                      <select class="form-control"  tabindex="-98" id="ha_contratado" name="ha_contratado">
                                                          <option value="">-- NO APLICAR --</option>
                                                          @if($array['ha_contratado'] == 'ACEPTADO')
                                                              <option value="ACEPTADO" selected>Sí</option>
                                                          @else
                                                              <option value="ACEPTADO">Sí</option>
                                                          @endif
                                                          @if($array['ha_contratado'] == 'RECHAZADO')
                                                              <option value="RECHAZADO" selected>No</option>
                                                          @else
                                                              <option value="RECHAZADO">No</option>
                                                          @endif
                                                      </select>
                                                  @else
                                                      <select class="form-control"  tabindex="-98" id="ha_contratado" name="ha_contratado">
                                                          <option value="">-- NO APLICAR --</option>
                                                          <option value="ACEPTADO">Sí</option>
                                                          <option value="RECHAZADO">No</option>
                                                      </select>
                                                  @endif
                                              </div>
                                          </div>
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                              <div class="form-group">
                                                  <label for="filtroAccCom">Acción Comercial</label>
                                                  @if (isset($array['acc_com']))
                                                      <select class="form-control"  tabindex="-98" id="acc_com" name="acc_com">
                                                          <option value="">-- NO APLICAR --</option>
                                                          @if ($array['acc_com'] == 'c_general')
                                                              <option value="c_general" selected>Campaña General</option>
                                                          @else
                                                              <option value="c_general">Campaña General</option>
                                                          @endif
                                                          @foreach ($acciones as $acc)
                                                              @if ($array['acc_com'] == $acc->pre_id)
                                                                  <option value="{{$acc->pre_id}}" selected>{{$acc->acc_com_name}}</option>
                                                              @else
                                                                  <option value="{{$acc->pre_id}}">{{$acc->acc_com_name}}</option>
                                                              @endif
                                                          @endforeach
                                                      </select>
                                                  @else
                                                      <select class="form-control"  tabindex="-98" id="acc_com" name="acc_com">
                                                          <option value="">-- NO APLICAR --</option>
                                                          <option value="c_general">Campaña General</option>
                                                          @foreach ($acciones as $acc)
                                                              <option value="{{$acc->pre_id}}">{{$acc->acc_com_name}}</option>
                                                          @endforeach
                                                      </select>
                                                  @endif
                                              </div>
                                          </div>
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                              {{-- <div class="form-group">
                                                  <label for="filtroCampanya">Campaña</label>
                                                  @if (isset($array['iniFecha']))
                                                  @else
                                                  @endif
                                                  <select class="form-control"  tabindex="-98" id="campanya" name="campanya">
                                                      <option value="">-- NO APLICAR --</option>
                                                  </select>
                                              </div> --}}
                                          </div>
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12"></div>
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                              <div class="form-group">
                                                  <label for="filtroLocalidad">Localidad</label>
                                                  @if (isset($array['localidad']))
                                                      <select class="form-control"  tabindex="-98" id="localidad" name="localidad">
                                                          <option value="">-- NO APLICAR --</option>
                                                          @foreach ($localidades as $loc)
                                                              @if ($array['localidad'] == $loc->cli_loc)
                                                                  <option value="{{$loc->cli_loc}}" selected>{{$loc->cli_loc}}</option>
                                                              @else
                                                                  <option value="{{$loc->cli_loc}}">{{$loc->cli_loc}}</option>
                                                              @endif
                                                          @endforeach
                                                      </select>
                                                  @else
                                                      <select class="form-control"  tabindex="-98" id="localidad" name="localidad">
                                                          <option value="">-- NO APLICAR --</option>
                                                          @foreach ($localidades as $loc)
                                                              <option value="{{$loc->cli_loc}}">{{$loc->cli_loc}}</option>
                                                          @endforeach
                                                      </select>
                                                  @endif

                                              </div>
                                          </div>
                                          {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                              <div class="form-group">
                                                  <label for="filtroSector">Sector</label>
                                                  @if (isset($array['iniFecha']))
                                                  @else
                                                  @endif
                                                  <select class="form-control"  tabindex="-98" id="sector" name="sector">
                                                      <option value="">-- NO APLICAR --</option>
                                                  </select>
                                              </div>
                                          </div> --}}
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                              <div class="form-group">
                                                  <label for="filtroNoContrato">No contrata por...</label>
                                                  @if (isset($array['no_contrato']))
                                                      <input type="text" class="form-control" id="no_contrato" name="no_contrato" placeholder="-- NO APLICAR --" value="{{$array['no_contrato']}}"></textarea>
                                                  @else
                                                      <input type="text" class="form-control" id="no_contrato" name="no_contrato" placeholder="-- NO APLICAR --"></textarea>
                                                  @endif

                                              </div>
                                          </div>
                                          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12"></div>
                                          <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12"></div>
                                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" style="text-align: right;">
                                              <input type="button" value="Limpiar" onclick="limpiarFiltros()" class="btn btn-secondary">
                                              <input type="submit" value="Aplicar" class="btn btn-primary">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="card-body">
                  <div class="cliente">
                      <div class="table-responsive">
                          <h3>Cartera de Clientes - ({{$numclientes}}) </h3>
                          <table class="table">
                            <thead>
                              <tr style="text-align: center">
                                <th>Código</th>
                                <th>Anunciante</th>
                                <th>Nombre</th>
                                <th>CIF</th>
                                <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($clientes as $cli)
                                  <tr style="text-align: center">
                                      <td>#{{$cli->cli_id}}</td>
                                      <td>{{$cli->cli_anu}}</td>
                                      <td>{{$cli->cli_nom}}</td>
                                      <td>{{$cli->cli_cif}}</td>
                                      <td style="width: 350px;">
                                          <a href="/clientes_ficha/{{$cli->cli_id}}"><img src='/assets/img/lupa.png' width='30px' height='30px' alt='Consultar cliente' title='Consultar cliente'></a>
                                      </td>
                                  </tr>
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                  </div>
            </div>
          </div>
        </div>
        <!-- Row end -->

      </div>
      <!-- Content wrapper end -->


    </div>
    <!-- *************
      ************ Main container end *************
    ************* -->

    <!-- Footer start -->
    <footer class="main-footer">© Wafi 2020</footer>
    <!-- Footer end -->

  </div>
  <!-- Container fluid end -->

@endsection

@section('script')

  <!-- *************
    ************ Required JavaScript Files *************
  ************* -->
  <!-- Required jQuery first, then Bootstrap Bundle JS -->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/js/moment.js')}}"></script>


  <!-- *************
    ************ Vendor Js Files *************
  ************* -->
  <!-- Slimscroll JS -->
  <script src="{{asset('assets/vendor/slimscroll/slimscroll.min.js')}}"></script>
  <script src="{{asset('assets/vendor/slimscroll/custom-scrollbar.js')}}"></script>

  <!-- Daterange -->
  <script src="{{asset('assets/vendor/daterange/daterange.js')}}"></script>
  <script src="{{asset('assets/vendor/daterange/custom-daterange.js')}}"></script>

  <!-- Steps wizard JS -->
  <script src="{{asset('assets/vendor/wizard/jquery.steps.min.js')}}"></script>
  <script src="{{asset('assets/vendor/wizard/jquery.steps.custom.js')}}"></script>

  <!-- Bootstrap Select JS -->
  <script src="{{asset('assets/vendor/bs-select/bs-select.min.js')}}"></script>

  <!-- Main Js Required -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  <!-- <script src="{{asset('assets/js/importes.js')}}"></script> -->

@endsection
