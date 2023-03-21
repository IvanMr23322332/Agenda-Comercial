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
          <li class="breadcrumb-item">Clientes</li>
          <li class="breadcrumb-item active">Carterización</li>
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
      <input type="number" id="target" value="" style="display:none">
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
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
            <div class="card">
              <div class="card-body">
                  <div class="cliente">
                      <div class="table-responsive">
                          <form action="{{url('filtrar_cartera')}}" method="POST" id="filtrar_cartera">
                              @csrf
                              @if (isset($array['cartera_buscador']))
                                  <div class="form-group" style="width: 50%;display: block; margin:auto;">
            					  	  <div class="input-group">
            					  	  	  <input list="brow" id="cartera_buscador" class="form-control" name="cartera_buscador" onchange="filtrar_cartera()" value="{{$array['cartera_buscador']}}">
            					  	  	  <div class="input-group-append">
            					  	  	  	  <a href="" class="collapsed" data-toggle="collapse" data-target="#defaultAccordionCollapseOne" aria-expanded="false" aria-controls="defaultAccordionCollapseOne"><button class="btn btn-info">Filtros</button></a>
            					  	  	  </div>
            					  	  </div>
            					  </div>
                              @else
                                  <div class="form-group" style="width: 50%;display: block; margin:auto;">
            					  	  <div class="input-group">
            					  	  	  <input list="brow" id="cartera_buscador" class="form-control" name="cartera_buscador" onchange="filtrar_cartera()">
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
                                                          <label for="filtroAgente">Agente</label>
                                                          @if (isset($array['age']))
                                                              <select class="form-control"  tabindex="-98" id="age" name="age">
                                                                  <option value="">-- NO APLICAR --</option>
                                                                  @foreach ($agentes as $age)
                                                                      @if ($array['age'] == $age->ase_id)
                                                                          <option value="{{$age->ase_id}}" selected>{{$age->ase_nombre}}</option>
                                                                      @else
                                                                          <option value="{{$age->ase_id}}">{{$age->ase_nombre}}</option>
                                                                      @endif
                                                                  @endforeach
                                                              </select>
                                                          @else
                                                              <select class="form-control" tabindex="-98" id="age" name="age">
                                                                  <option value="">-- NO APLICAR --</option>
                                                                  @foreach ($agentes as $age)
                                                                      <option value="{{$age->ase_id}}">{{$age->ase_nombre}}</option>
                                                                  @endforeach
                                                              </select>
                                                          @endif
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                      <div class="form-group">
                                                          <label for="filtroUltContrato">Último Contrato</label>
                                                          @if (isset($array['ultContrato']))
                                                              <input type="date" id="ultContrato" name="ultContrato"  class="form-control" value="{{$array['ultContrato']}}">
                                                          @else
                                                              <input type="date" id="ultContrato" name="ultContrato"  class="form-control">
                                                          @endif
                                                      </div>
                                                  </div>
                                                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                      <div class="form-group">
                                                          <label for="filtroUltVisita">Última Visita</label>
                                                          @if (isset($array['ultVisita']))
                                                              <input type="date" id="ultVisita" name="ultVisita"  class="form-control" value="{{$array['ultVisita']}}">
                                                          @else
                                                              <input type="date" id="ultVisita" name="ultVisita"  class="form-control">
                                                          @endif
                                                      </div>
                                                  </div>
                                                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12"></div>
                                                  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12"></div>
                                                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" style="text-align: right;">
                                                      <input type="button" value="Limpiar" onclick="limpiarFiltros2()" class="btn btn-secondary">
                                                      <input type="submit" value="Aplicar" class="btn btn-primary">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </form>
                          <h3>Carterización</h3>
                          <table class="table">
                            <thead>
                              @if ($_SESSION['status'] == 'admin')
                                  <tr>
                                    <th>Código</th>
                                    <th>Anunciante</th>
                                    <th>Nombre</th>
                                    <th>CIF</th>
                                    <th>Carterizado a</th>
                                    <th>Opciones</th>
                                  </tr>
                              @else
                                  <tr>
                                    <th>Código</th>
                                    <th>Anunciante</th>
                                    <th>Nombre</th>
                                    <th>CIF</th>
                                    <th>Opciones</th>
                                  </tr>
                              @endif
                            </thead>
                            <tbody>
                                @if ($_SESSION['status'] == 'admin')
                                    <div style="display:none" class="modal fade show" id="aceptarModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: block; padding-right: 12px;" aria-modal="true">
                                                  <div class="modal-dialog" role="document">
                                                      <div class="modal-content" style="width:90%">
                                                                <div class="modal-header">
                                                                <h5 class="modal-title" id="basicModalLabel">Confirmación</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <center><h4>¿Seguro que quieres traspasar?</h4></center>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Cancelar</button>
                                                                <button type="button" class="btn btn-primary" value="Aceptar" onclick="enviar_form();" >Aceptar</button>
                                                            </div>

                                                      </div>
                                                  </div>
                                              </div>
                                    @foreach ($clientes as $cli)
                                        <tr>
                                            <form id="carterizar_cliente{{$cli->cli_id}}" action="{{url('carterizar_cliente')}}" method="POST">
                                            @csrf
                                                <td>#{{$cli->cli_id}}</td>
                                                <td>{{$cli->cli_anu}}</td>
                                                <td>{{$cli->cli_nom}}</td>
                                                <td>{{$cli->cli_cif}}</td>
                                                <td>
                                                    <input type="hidden" name="cli_id" value="{{$cli->cli_id}}">
                                                        @foreach ($agentes as $age)
                                                            @if ($age->ase_id == $cli->cli_age)
                                                                {{$age->ase_nombre}}
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="width: 350px;">
                                                    <button style="margin-bottom:9px" type="button" class="btn btn-primary" name="button" onclick="Traspasar({{$cli->cli_id}})">Traspaso</button>
                                                    <a href="/sol_baja_cliente/{{$cli->cli_id}}"><button class="btn btn-secondary" tabindex="0" aria-controls="copy-print-csv" type="button" value="Solicitar Baja"   style="margin-bottom: 10px; margin-right: 10px;">Baja</button></a>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach

                                    <div class="modal fade" id="traspasarModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <form action="{{url('traspasar_cliente')}}" method="POST">
                                                  @csrf
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="basicModalLabel">Traspasar Cliente</h5>
                                                  </div>
                                                  <input type="hidden" name="cliente_target" id="cliente_target" value="">
                                                  <div class="modal-body">
                                                      <div class="form-group">
                                                            <label for="nuevo_asesor">Elija al asesor al que traspasar</label>
                                                           <select class="form-control" name="nuevo_asesor">
                                                               @foreach ($agentes as $age)
                                                                   <option value="{{$age->ase_id}}">{{$age->ase_nombre}}</option>
                                                               @endforeach
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

                                @else
                                    @foreach ($clientes as $cli)
                                        <tr>
                                            <td>#{{$cli->cli_id}}</td>
                                            <td>{{$cli->cli_anu}}</td>
                                            <td>{{$cli->cli_nom}}</td>
                                            <td>{{$cli->cli_cif}}</td>
                                            <td style="width: 600px;">
                                                <button class="btn btn-primary" data-toggle="modal" data-target='#aceptarModal{{$cli->cli_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Agendar"   style="margin-bottom: 10px; margin-right: 10px;">Agendar</button>
                                                <button class="btn btn-secondary" data-toggle="modal" data-target='#rechazarModal{{$cli->cli_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Rechazar"  style="margin-bottom: 10px; margin-right: 10px;">Rechazar</button>
                                                <div class="modal fade" id="aceptarModal{{$cli->cli_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
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
                                                                       <input type="hidden" name="cartera" value="1">
                                                                       <input type="hidden" name="cli_id" value="{{$cli->cli_id}}">
                                                                       <label for="message-text" class="col-form-label">Fecha para la agenda del cliente:</label>
                                                                       <input type="date" id="fecha_agenda{{$cli->cli_id}}" name="fecha_agenda" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
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

                                                <div class="modal fade" id="rechazarModal{{$cli->cli_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
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
                                                                       <input type="hidden" name="cli_id" value="{{$cli->cli_id}}">
                                                                       <label for="message-text" class="col-form-label">Fecha de rechazo del cliente:</label>
                                                                       <input type="date" id="fecha_rechazo{{$cli->cli_id}}" name="fecha_rechazo{{$cli->cli_id}}" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
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
                                @endif
                            </tbody>
                          </table>
                          <br>
                          <style>
                                .w-5{
                                    width: 3%;
                                }
                          </style>
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
  <script src="{{asset('assets/js/clientes.js')}}"></script>
  <!-- <script src="{{asset('assets/js/importes.js')}}"></script> -->

  <script>

  function comprobar(numero){
      $('#aceptarModal').modal('show');
      $('#target').val(numero);
  }

  function enviar_form(){
      var num =  $('#target').val();
      document.getElementById("carterizar_cliente" + num).submit();
  }

  function Traspasar(numero){

      $('#traspasarModal').modal('show');
      $('#cliente_target').val(numero);

  }

  </script>
@endsection
