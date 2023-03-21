@extends('layouts.app')

@section('section')

  <!-- Container fluid start -->
  <div class="container-fluid">

    @if (!isset($_SESSION))
        <?php SESSION_START() ?>
    @endif
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
          <li class="breadcrumb-item">Ventas</li>
          <li class="breadcrumb-item active">Historico de Ventas</li>
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
                <div class="card-title">Ventas</div>
              </div>
              <div class="card-body">
                <ul class="custom-list2">
                  <li>
                    <a href="/table">Reporte sobre Ventas</a>
                  </li>
                  <li>
                    <a href="/ventas_presupuesto">Histórico de Ventas</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
            <div class="card">
              <div class="card-body">
                  <form action="{{url('filtrar_ventas')}}" method="POST">
                      @csrf
                      <input type="hidden" name="primer_anyo" value="{{$anyo}}">
                      <div class="dropdown" style="margin-bottom: 15px; text-align: center;">
                          <div class="dropdown bootstrap-select form-control" style="width: 180px;">
                              <label for="mes">Mes</label>
                              <select class="form-control selectpicker" tabindex="-98" name="mes_filtro" id="mes">
                                  @if (isset($mes_elegido))
                                      <option value="0" >TODOS LOS MESES </option>
                                      @for ($i=1; $i <= count($meses); $i++)
                                          @if ($i == $mes_elegido)
                                              <option value="{{$i}}" selected>{{$meses[$i-1]}}</option>
                                          @else
                                              <option value="{{$i}}" >{{$meses[$i-1]}}</option>
                                          @endif
                                      @endfor
                                  @else
                                      <option value="0" >TODOS LOS MESES </option>
                                      @for ($i=1; $i <= count($meses); $i++)
                                          @if ($i == now()->month)
                                              <option value="{{$i}}" selected>{{$meses[$i-1]}}</option>
                                          @else
                                              <option value="{{$i}}" >{{$meses[$i-1]}}</option>
                                          @endif
                                      @endfor
                                  @endif
                              </select>
                          </div>
                          <div class="dropdown bootstrap-select form-control" style="width: 180px;">
                              <label for="anyo">Año</label>
                              <select class="form-control selectpicker" tabindex="-98" name="anyo_filtro" id="anyo">
                                  @if (isset($anyo_elegido))
                                      <option value="0">TODOS LOS AÑOS </option>
                                      @for ($i=$anyo; $i <= now()->year; $i++)
                                          @if ($i == $anyo_elegido)
                                              <option value="{{$i}}" selected>{{$i}}</option>
                                          @else
                                              <option value="{{$i}}">{{$i}}</option>
                                          @endif
                                      @endfor
                                  @else
                                      <option value="0">TODOS LOS AÑOS </option>
                                      @for ($i=$anyo; $i <= now()->year; $i++)
                                          @if ($i == now()->year)
                                              <option value="{{$i}}" selected>{{$i}}</option>
                                          @else
                                              <option value="{{$i}}">{{$i}}</option>
                                          @endif
                                      @endfor
                                  @endif
                              </select>
                          </div>
                          <br>
                          <br>
                          <input type="submit" class="btn btn-info" style="margin-top: 15px;" value="Aplicar Filtros">
                      </div>
                  </form>
                  <div class="ventas">
                      <div class="table-responsive">
                          <h3>HISTORICO DE VENTAS</h3>
                          <table class="table">
                            <thead>
                              <tr>
                                  <th>Número</th>
                                  <th>Anunciante</th>
                                  <th>Teléfono</th>
                                  <th>Gestión</th>
                                  <th>Importe</th>
                                  <th>Fecha Inicio</th>
                                  <th>Fecha Admisión</th>
                                  <th style="width: 350px;">Opciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($aceptados as $pre)
                                  <tr>
                                      <td>#{{$pre->pre_id}}</td>
                                      <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pre->pre_cliente)}}">{{$pre->clientes->cli_anu}}</a></td>
                                      <td>{{$pre->clientes->cli_tel1}}</td>
                                      <td>{{$pre->asesores->ase_nombre}}</td>
                                      <td>{{$pre->pre_tot_neto}} €</td>
                                      <td>{{$pre->pre_dateini}}</td>
                                      <td>{{$pre->updated_at}}</td>
                                      <td><a href="/presupuesto_ficha/{{$pre->pre_id}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" value="ver_presupuesto">Ver Presupuesto</button></a> <a href="/copiarPresupuesto/{{$pre->pre_id}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="copia_presupuesto">Nuevo Presupuesto</button></a></td>
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
