    @extends('layouts.app')

@section('section')

  <!-- Container fluid start -->
  <div class="container-fluid">
      <?php SESSION_START() ?>
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
          <li class="breadcrumb-item active">Análisis</li>
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
                            <a href="/clientes_tabla">Tabla de clientes</a>
                          </li>
                          <li>
                            <a href="/potenciales_tabla">Tabla de potenciales</a>
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
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">





            <div class="card">

                @if ($_SESSION['status']=='admin')
                    <table style="margin-top:15px">
                        <tr>
                            <td>
                                <div class="dropdown" style="margin-bottom: 15px;margin-left:15px;  text-align:right; " >
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    {{$usuario->user_name}}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                    @foreach ($usuarios as $elem)
                                        <a class="dropdown-item" href="{{url('users_info/'.$elem->user_ase."/".$mes_numero."/".$anyo)}}">{{$elem->user_name}}</a>
                                    @endforeach
                                </div>
                                </div>
                            </td>
                            <td style="width:93%; text-align:right">
                                <div class="dropdown" style="margin-bottom: 15px;  text-align:right; " >
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    {{$mes}}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                    @foreach ($lista_meses as $elem)
                                        <a class="dropdown-item" href="{{url('users_info/'.$usuario->user_id."/".$elem->mes_id."/".$anyo)}}">{{$elem->mes_nombre}}</a>
                                    @endforeach
                                </div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown" style="margin-bottom: 15px; text-align:center; margin-right:15px">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    {{$anyo}}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                    @foreach ($lista_anyos as $elem)
                                        <a class="dropdown-item" href="{{url('users_info/'.$usuario->user_id."/".$mes_numero."/".$elem)}}">{{$elem}}</a>
                                    @endforeach
                                </div>

                              </div>
                          </td>
                        </tr>
                    </table>
                @else
                    <table style="margin-top:15px">
                        <tr>
                            <td style="width:93%; text-align:right">
                                <div class="dropdown" style="margin-bottom: 15px;  text-align:right; " >
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    {{$mes}}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                    @foreach ($lista_meses as $elem)
                                        <a class="dropdown-item" href="{{url('users_info/'.$_SESSION['id_ase']."/".$elem->mes_id."/".$anyo)}}">{{$elem->mes_nombre}}</a>
                                    @endforeach
                                </div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown" style="margin-bottom: 15px; text-align:center; margin-right:15px">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    {{$anyo}}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                    @foreach ($lista_anyos as $elem)
                                        <a class="dropdown-item" href="{{url('users_info/'.$_SESSION['id_ase']."/".$mes_numero."/".$elem)}}">{{$elem}}</a>
                                    @endforeach
                                </div>

                              </div>
                          </td>
                        </tr>
                    </table>
                @endif






              <div class="card-body">
                  <h4>RESUMEN DE GESTIONES</h4>

                  <table class="table">
                      <thead>
                          <tr>
                              <th>TIPO</th>
                              <th>POTENCIALES</th>
                              <th>CLIENTES</th>
                              <th>TOTAL</th>
                              <th>% CARTERA</th>
                          </tr>
                      </thead>
                      <tbody>

                          @foreach ($primera_tabla as $fila)
                              <tr>
                                <th>{{$fila[0]}}</th>
                                <th>{{$fila[1]}}</th>
                                <th>{{$fila[2]}}</th>
                                <th>{{$fila[3]}}</th>
                                <th>{{$fila[4]}}</th>
                              </tr>
                          @endforeach

                      </tbody>
                  </table>
                  <br><br><br>
                  <h4>RESUMEN DE PRESUPUESTOS</h4>
                  <table class="table">
                      <thead>
                          <tr>
                              <th>TIPO</th>
                              <th>POTENCIALES</th>
                              <th>CLIENTES</th>
                              <th>TOTAL</th>
                              <th>% CARTERA</th>
                          </tr>
                      </thead>
                      <tbody>

                          @foreach ($segunda_tabla as $fila)
                              <tr>
                                <th>{{$fila[0]}}</th>
                                <th>{{$fila[1]}}</th>
                                <th>{{$fila[2]}}</th>
                                <th>{{$fila[3]}}</th>
                                <th>{{$fila[4]}}</th>
                              </tr>
                          @endforeach

                      </tbody>
                  </table>
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
