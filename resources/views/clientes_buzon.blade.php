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
          <li class="breadcrumb-item">Clientes</li>
          <li class="breadcrumb-item active">Validaciones</li>
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
            <div class="card">
              <div class="card-body">
                  @if ($_SESSION['status'] == 'user')
                      <div class="buzon">
                          <div class="table-responsive">
                              <h3>Buzon de Clientes Pendientes por Agendar</h3>
                              <table class="table">
                                <thead>
                                  <tr>
                                      <th>Código</th>
                                      <th>Anunciante</th>
                                      <th>Gestión</th>
                                      <th>Teléfono</th>
                                      <th>Correo Electrónico</th>
                                      <th style="width: 450px;">Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agendar as $age)
                                          <tr>
                                              <td>#{{$age->cli_id}}</td>
                                              <td><a class="makeshift_link" href="{{url("clientes_ficha/".$age->cli_id)}}">{{$age->cli_anu}}</a></td>
                                              <td>{{$age->asesores->ase_nombre}}</td>
                                              <td>{{$age->cli_tel1}}</td>
                                              <td>{{$age->cli_mail1}}</td>
                                              <td style="width: 450px;">
                                                  <button class="btn btn-primary" data-toggle="modal" data-target='#aceptarModal{{$age->cli_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Agendar"   style="margin-bottom: 10px; margin-right: 10px;">Agendar</button>
                                                  <button class="btn btn-secondary" data-toggle="modal" data-target='#rechazarModal{{$age->cli_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Rechazar"  style="margin-bottom: 10px; margin-right: 10px;">Rechazar</button>
                                                  <div class="modal fade" id="aceptarModal{{$age->cli_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                            <form action="{{url('agendar_cliente')}}" method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="basicModalLabel">Agendar Cliente</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                         <input type="hidden" name="cli_id" value="{{$age->cli_id}}">
                                                                         <label for="message-text" class="col-form-label">Fecha para la agenda del cliente:</label>
                                                                         <input type="date" id="fecha_agenda{{$age->cli_id}}" name="fecha_agenda" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
                                                                         <label for="message-text" class="col-form-label">Tipo de la nueva visita:</label>
                                                                         <select class="form-control" id="tipo_visita" name="tipo_visita" required>
                                                                             <option value="">Seleccione un tipo de visita</option>
                                                                             <option value="Llamada">Llamada</option>
                                                                             <option value="Reunion">Reunión</option>
                                                                             <option value="Email">Email</option>
                                                                         </select>
                                                                     </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="reset"  class="btn btn-secondary" data-dismiss="modal" value="Cancelar">
                                                                    <input type="submit" class="btn btn-primary" value="Aceptar">
                                                                </div>
                                                            </form>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="modal fade" id="rechazarModal{{$age->cli_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                            <form action="{{url('rechazar_cliente')}}" method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="basicModalLabel">Rechazar Cliente</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                         <input type="hidden" name="cli_id" value="{{$age->cli_id}}">
                                                                         <label for="message-text" class="col-form-label">Fecha de rechazo del cliente:</label>
                                                                         <input type="date" id="fecha_rechazo{{$age->cli_id}}" name="fecha_rechazo{{$age->cli_id}}" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
                                                                     </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="reset"  class="btn btn-secondary" data-dismiss="modal" value="Cancelar">
                                                                    <input type="submit" class="btn btn-primary" value="Aceptar">
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
                  @endif
                  <div class="buzon">
                      <div class="table-responsive">
                          <h3>Buzon de Clientes Pendientes por Validar</h3>
                          <table class="table">
                            <thead>
                              <tr>
                                  <th>Código</th>
                                  <th>Anunciante</th>
                                  <th>Gestión</th>
                                  <th>Teléfono</th>
                                  <th>Correo Electrónico</th>
                                  @if ($_SESSION['status'] == 'admin')
                                      <th style="width: 450px;">Opciones</th>
                                  @else
                                      <th style="width: 450px;"></th>
                                  @endif

                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($validacion as $val)
                                      <tr>
                                          <td>#{{$val->cli_id}}</td>
                                          <td><a class="makeshift_link" href="{{url("clientes_ficha/".$val->cli_id)}}">{{$val->cli_anu}}</a></td>
                                          <td>{{$val->asesores->ase_nombre}}</td>
                                          <td>{{$val->cli_tel1}}</td>
                                          <td>{{$val->cli_mail1}}</td>
                                          <td style="width: 450px;">
                                              @if ($_SESSION['status'] == 'admin')
                                                  @if ($val->cli_est_cli == 'PENDIENTE')
                                                      <form action="{{url('val_comercial')}}" method="POST">
                                                          @csrf
                                                          <input type="hidden" name="cli_id" value="{{$val->cli_id}}">
                                                          <input class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="submit" value="Validación Comercial" style="margin-bottom: 10px; margin-right: 10px;">
                                                      </form>
                                                  @else
                                                      <form action="{{url('val_admin')}}" method="POST">
                                                          @csrf
                                                          <input type="hidden" name="cli_id" value="{{$val->cli_id}}">
                                                          <input class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="submit" value="Validación Administrativa" style="margin-bottom: 10px; margin-right: 10px;">
                                                      </form>
                                                  @endif
                                                  <form action="{{url('rechazar_cliente')}}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="cli_id" value="{{$val->cli_id}}">
                                                      <input class="btn btn-secondary" tabindex="0" aria-controls="copy-print-csv" type="submit" value="Rechazar" style="margin-bottom: 10px; margin-right: 10px;">
                                                  </form>
                                              @endif
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

  <script src="{{asset('assets/js/detalles_campanya.js')}}"></script>

@endsection
