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
    <input type="number" id="target" value="">
    <div class="main-container">


      <!-- Page header start -->
      <div class="page-header">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Clientes</li>
          <li class="breadcrumb-item active">Solicitud de Baja</li>
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
              <div class="card" style="position: fixed; top: 198px; width: 15%;">
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

          <div class="modal fade show" id="aceptarModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none; padding-right: 12px;" aria-modal="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="width:90%">
                                      <div class="modal-header">
                                      <h5 class="modal-title" id="basicModalLabel">Confirmación</h5>
                                  </div>
                                  <div class="modal-body">
                                      <center><h4>¿Seguro que quieres dar de baja?</h4></center>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Cancelar</button>
                                      <button type="button" class="btn btn-primary" value="Aceptar" onclick="dar_baja();" >Aceptar</button>
                                  </div>

                            </div>
                        </div>
                    </div>

          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
            <div class="card">
              <div class="card-body">
                  <div class="cliente">
                      <div class="table-responsive">
                          <h3>Solicitud de Baja</h3>
                          @if ($_SESSION['status'] != 'admin')
                              <form class="" action="{{url("filtrar_clientes_bajas")}}" method="post" id="form_clientes_bajas">
                              @csrf
                              <input list="brow" id="cliente_buscador" class="form-control" placeholder="Buscar Cliente" name="cliente_buscador" onchange="filtrar_clientes_bajas()">
                              <datalist id="brow">
                                  @foreach ($tabla as $key => $value)
                                      <option>{{$value->cli_anu}}</option>
                                  @endforeach
                              </datalist>
                              </form>
                          @endif
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Código</th>
                                <th>Anunciante</th>
                                @if($_SESSION['status'] == 'admin')
                                    <th>Gestión</th>
                                @endif
                                <th>Nombre</th>
                                <th>CIF</th>
                                <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if ($_SESSION['status'] == 'admin')
                                    @foreach ($clientes as $cli)
                                        <tr>
                                            <td>#{{$cli->cli_id}}</td>
                                            <td><a class="makeshift_link" href="{{url("clientes_ficha/".$cli->cli_id)}}">{{$cli->cli_anu}}</a></td>
                                            <td>{{$cli->asesores->ase_nombre}}</td>
                                            <td>{{$cli->cli_nom}}</td>
                                            <td>{{$cli->cli_cif}}</td>
                                            <td style="width: 350px;">
                                                <a href="/dar_baja_cliente/{{$cli->cli_id}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" value="Aceptar Baja"   style="margin-bottom: 10px; margin-right: 10px;">Aceptar Baja</button>
                                                <a href="/rec_baja_cliente/{{$cli->cli_id}}"><button class="btn btn-secondary" tabindex="0" aria-controls="copy-print-csv" type="button" value="Rechazar Baja"  style="margin-bottom: 10px; margin-right: 10px;">Rechazar Baja</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($clientes as $cli)
                                        <tr>
                                            <td>#{{$cli->cli_id}}</td>
                                            <td><a class="makeshift_link" href="{{url("clientes_ficha/".$cli->cli_id)}}">{{$cli->cli_anu}}</a></td>
                                            <td>{{$cli->cli_nom}}</td>
                                            <td>{{$cli->cli_cif}}</td>
                                            <td style="width: 350px;">

                                                <button type="button" class="btn btn-secondary" tabindex="0" name="button" onclick="revelarModal({{$cli->cli_id}})">Baja</button>

                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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

  <script type="text/javascript">

    function revelarModal(numero){
        $('#target').val(numero);
        $('#aceptarModal').modal('show')
    }

    function dar_baja(){
        var num = $('#target').val();
        window.location.href = "http://agenda-comercial/sol_baja_cliente/" + num;
    }

  </script>

@endsection
