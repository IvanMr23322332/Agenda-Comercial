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
          <li class="breadcrumb-item">Administrador</li>
          <li class="breadcrumb-item active">Administrar Acciones Comerciales</li>
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
                      <div class="card-title">Administrador</div>
                  </div>
                  <div class="card-body">
                      <ul class="custom-list2">
                          <li>
                            <a href="/admin_accion_comercial">Administrar Acc. Com.</a>
                          </li>
                          <li>
                            <a href="/admin_tarifas">Administrar Tarifas</a>
                          </li>
                          <li>
                            <a href="/admin_users">Administrar Usuarios</a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
            <div class="card">
              <div class="card-body">
                  <div class="admin_accion_comercial">
                      <div class="table-responsive">
                          <h3>Acciones Comerciales</h3>
                          <a href="/crear_accion_comercial"><button type="button" class="btn btn-primary" style="margin-bottom: 10px; float: right;">Añadir</button></a>
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Número</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($acc_com as $acc)
                                  <tr>
                                      <td>{{$acc->pre_id}}</td>
                                      <td>{{$acc->acc_com_name}}</td>
                                      <td>{{$acc->acc_com_tipo}}</td>
                                      <td>{{$acc->pre_dateini}}</td>
                                      <td>{{$acc->pre_datefin}}</td>
                                      <td>
                                          <a href="{{url('/modificarAccCom/'.$acc->pre_id)}}"><button class="btn btn-warning" tabindex="0" aria-controls="copy-print-csv" type="button" value="Modificar" style="margin-bottom: 10px;  margin-right: 10px;">Modificar</button></a>
                                          <button class="btn btn-secondary" data-toggle="modal" data-target='#eliminarAcc{{$acc->pre_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Eliminar"  style="margin-bottom: 10px;">Eliminar</button>
                                          <div class="modal fade" id="eliminarAcc{{$acc->pre_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                  <div class="modal-content">
                                                    <form action="{{url('eliminarAcc')}}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="basicModalLabel">Eliminar acción comercial</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Desea eliminar ésta acción comercial ?
                                                            <input type="hidden" name="acc_com_id" value="{{$acc->pre_id}}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Aceptar</button>
                                                        </div>
                                                    </form>
                                                  </div>
                                              </div>
                                          </div>
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
