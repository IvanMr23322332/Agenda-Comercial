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
          <li class="breadcrumb-item active">Tabla de Potenciales</li>
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
              <div class="card-body">
                  <div class="cliente">
                      <div class="table-responsive">
                          <h3>Cartera de Potenciales - ({{$numclientes}})</h3>
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
