@extends('layouts.app')

@section('section')

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
                    <li class="breadcrumb-item">Clientes</li>
                    <li class="breadcrumb-item active">Incorporar a Cartera</li>
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
          					<div class="card-title">Clientes</div>
          				</div>
          				<div class="card-body">
          					<ul class="custom-list2">
          						<li>
          							<a href="/clientes_crear">Incorporar a Cartera</a>
          						</li>
          						<li>
          							<a href="/clientes_buzon">Validaciones</a>
          						</li>
          						<li>
          							<a href="/clientes_bajas">Solicitud de Baja</a>
          						</li>
                                <li>
        							<a href="/clientes_cartera">Carterización</a>
        						</li>
          					</ul>
          				</div>
          			</div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
                        <div class="card h-100">
                            <div class="card-header">
                                <div class="card-title">Crear Cliente</div>
                            </div>
                            <form class="" action="{{url('crear_cliente')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row gutters">
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_anu">Anunciante</label>
                                            <input type="text" class="form-control" id="cli_anu" name="cli_anu" placeholder="Introduzca el nombre del anunciante" required>
                                        </div>
                                        <div class="form-group col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12"></div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_dir">Dirección</label>
                                            <input type="text" class="form-control" id="cli_dir" name="cli_dir" placeholder="Introduzca la dirección" required>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_loc">Localidad</label>
                                            <input type="text" class="form-control" id="cli_loc" name="cli_loc" placeholder="Introduzca la localidad" required>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_tel1">Teléfono</label>
                                            <input type="text" class="form-control" id="cli_tel1" name="cli_tel1" placeholder="Introduzca el teléfono" required>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_mail1">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="cli_mail1" name="cli_mail1" placeholder="Introduzca el correo electrónico" required>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_cont_nom">Persona de Contacto</label>
                                            <input type="text" class="form-control" id="cli_cont_nom" name="cli_cont_nom" placeholder="Introduzca el nombre de la persona de contacto" required>
                                        </div>
                                        <div class="form-group col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12"></div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="text-right">
                                                <input type="submit" class="btn btn-success" value="Guardar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
