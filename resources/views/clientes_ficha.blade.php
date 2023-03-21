@extends('layouts.app')

@section('section')

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
                    <li class="breadcrumb-item active">Ficha Cliente</li>
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
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="account-settings">
                                    <div class="user-profile">
                                        <h5 class="user-name">{{$cliente->cli_anu}}</h5>
                                        @if ($_SESSION['status'] == 'admin')
                                            <h6 class="user-email">Asesor: {{$cliente->asesores->ase_nombre}}</h6>
                                        @else
                                            <h6 class="user-email">{{$cliente->cli_mail1}}</h6>
                                        @endif

                                    </div>
                                    <div class="setting-links" style="padding-bottom: 1rem;">
                                        @if ($links == true)
                                            <a href="{{url('crear_presupuesto')}}/{{$cliente->cli_id}}">
                                                <i class="icon-file-text"></i>
                                                Crear Presupuesto desde cero
                                            </a>
                                            <br>
                                            <a href="{{url('crear_presupuestoAcc')}}/{{$cliente->cli_id}}">
                                                <i class="icon-file-text"></i>
                                                Crear Presupuesto desde Acción Comercial
                                            </a>
                                        @endif
                                    </div>
                                    <div class="setting-links" style="border-top: 1px solid #e1e4f4; padding-top: 1rem;">
                                        <a data-toggle="modal" data-target='#addRegistro'>
                                            <i class="icon-circle-with-plus"></i>
                                            Añadir Reporte
                                        </a>
                                        <div class="modal fade" id="addRegistro" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <form action="{{url('add_registro')}}" method="POST">
                                                      @csrf
                                                      <div class="modal-header">
                                                          <h5 class="modal-title" id="basicModalLabel">Añadir Reporte</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">×</span>
                                                          </button>
                                                      </div>
                                                      <div class="modal-body">
                                                          <div class="form-group">
                                                               <input type="hidden" name="cli_id" value="{{$cliente->cli_id}}">
                                                               <label for="message-text" class="col-form-label">Introduzca el mensaje del registro:</label><br>
                                                               <textarea id="text_registro" name="text_registro" rows="3" cols="60" required></textarea>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                        <div id="datos_screen" class="card h-100">
                            <div class="card-header">
                                <div class="card-title">
                                    Datos del Cliente
                                    <button class="btn btn-info" onclick="revelarHistorial()" style="float: right;">Ir a Historial de Cambios</button>
                                </div>
                            </div>
                            <form class="" action="{{url('modificar_cliente')}}" method="POST">
                                @csrf
                                <input type="hidden" name="idCliente" value="{{$cliente->cli_id}}">
                                <div class="card-body">
                                    <div class="row gutters">
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_anu">Anunciante</label>
                                            <input type="text" class="form-control" id="cli_anu" name="cli_anu" value="{{$cliente->cli_anu}}" placeholder="Introduzca el anunciante del cliente" required>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_nom">Cliente</label>
                                            <input type="text" class="form-control" id="cli_nom" name="cli_nom" value="{{$cliente->cli_nom}}" placeholder="Introduzca el nombre del cliente">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_cif">CIF</label>
                                            <input type="text" class="form-control" id="cli_cif" name="cli_cif" value="{{$cliente->cli_cif}}" placeholder="Introduzca el CIF del cliente">
                                        </div>
                                        <div class="form-group col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                            <label for="cli_dir">Dirección</label>
                                            <input type="text" class="form-control" id="cli_dir" name="cli_dir" value="{{$cliente->cli_dir}}" placeholder="Introduzca la dirección" required>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                            <label for="cli_loc">Localidad</label>
                                            <input type="text" class="form-control" id="cli_loc" name="cli_loc" value="{{$cliente->cli_loc}}" placeholder="Introduzca la localidad" required>
                                        </div>
                                        <div class="form-group col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                            <label for="cli_pro">Provincia</label>
                                            <input type="text" class="form-control" id="cli_pro" name="cli_pro" value="{{$cliente->cli_pro}}" placeholder="Introduzca la provincia">
                                        </div>
                                        <div class="form-group col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                            <label for="cli_cp">CP</label>
                                            <input type="text" class="form-control" id="cli_cp" name="cli_cp" value="{{$cliente->cli_cp}}" placeholder="Código Postal">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_tel1">Teléfono 1</label>
                                            <input type="text" class="form-control" id="cli_tel1" name="cli_tel1" value="{{$cliente->cli_tel1}}" placeholder="Introduzca el teléfono 1" required>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_mail1">Correo Electrónico 1</label>
                                            <input type="email" class="form-control" id="cli_mail1" name="cli_mail1" value="{{$cliente->cli_mail1}}" placeholder="Introduzca el correo electrónico 1" required>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_fax">Fax</label>
                                            <input type="text" class="form-control" id="cli_fax" name="cli_fax" value="{{$cliente->cli_fax}}" placeholder="Introduzca el fax">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_tel2">Teléfono 2</label>
                                            <input type="text" class="form-control" id="cli_tel2" name="cli_tel2" value="{{$cliente->cli_tel2}}" placeholder="Introduzca el teléfono 2">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_mail2">Correo Electrónico 2</label>
                                            <input type="email" class="form-control" id="cli_mail2" name="cli_mail2" value="{{$cliente->cli_mail2}}" placeholder="Introduzca el correo electrónico 2">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_pago">Forma de Pago</label>
                                            @if (isset($cliente->metodos_pago->met_pago_desc))
                                                <input list="listPago" id="formPago" class="form-control" placeholder="Introduzca el método de pago" name="cli_pago" onchange="validar_pago()" value="{{$cliente->metodos_pago->met_pago_desc}}">
                                            @else
                                                <input list="listPago" id="formPago" class="form-control" placeholder="Introduzca el método de pago" name="cli_pago" onchange="validar_pago()">
                                            @endif
                                            <datalist id="listPago" >
                                                @foreach ($metodos_pago as $met_pago)
                                                    <input type="hidden" id="met_pago{{$met_pago->met_pago_id}}" value="{{$met_pago->met_pago_desc}}">
                                                    <option value="{{$met_pago->met_pago_desc}}"></option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_iban">IBAN</label>
                                            <input type="text" class="form-control" id="cli_iban" name="cli_iban" value="{{$cliente->cli_iban}}" placeholder="Introduzca el IBAN">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_cont_nom">Persona de Contacto</label>
                                            <input type="text" class="form-control" id="cli_cont_nom" name="cli_cont_nom" value="{{$cliente->cli_cont_nom}}" placeholder="Introduzca el nombre de la persona de contacto" required>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_cont_tel">Teléfono Persona de Contacto</label>
                                            <input type="text" class="form-control" id="cli_cont_tel" name="cli_cont_tel" value="{{$cliente->cli_cont_tel}}" placeholder="Introduzca el teléfono de la persona de contacto">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label for="cli_cont_mail">Correo Electrónico Persona de Contacto</label>
                                            <input type="email" class="form-control" id="cli_cont_mail" name="cli_cont_mail" value="{{$cliente->cli_cont_mail}}" placeholder="Introduzca el correo electrónico de la persona de contacto">
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="text-right">

                                                <input class="btn btn-success" id="btn_submit" type="submit" value="Guardar cambios" style="display:none">
                                                <button class ="btn btn-secondary" id="btn_cancel" type="button" value="cancelar" onclick="location.reload();" style="display:none">Cancelar</button>
                                                <button class="btn btn-success" id="btn_mod" type="button" value="Modificar" onclick="revelarBotones()">Modificar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (isset($val_admin))
                            <input type="hidden" id='val_admin' value="true">
                        @endif
                        <div id="historial_screen" class="card h-100" style="display: none;">
                            <div class="card-header">
                                <div class="card-title">
                                    Historial de Cambios
                                    <button class="btn btn-info" onclick="revelarDatos()" style="float: right;">Ir a Datos del Cliente</button>
                                </div>
                                <br>
                                <div class="custom-control custom-switch" style="padding-top: 1rem;">
                                    <input type="checkbox" onchange="desactivarAuto()" class="custom-control-input" id="desactivarAuto" name="desactivarAuto" checked>
                                    <label class="custom-control-label" for="desactivarAuto">Mostrar registros automáticos</label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="table-container">
                                            <div class="table-responsive">
                                                <div>
                                                    <table class="table custom-table m-0">
                                                        <tr>
                                                            <th style="width: 20%; text-align: center">Fecha</th>
                                                            <th>Descripción</th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div style="overflow: auto; height: 400px;">
                                                    <table class="table custom-table m-0">
                                                        @foreach ($historial as $fila)
                                                            {{-- IF ES UN PRESUPUESTO PONER <a> --}}
                                                            @if ($fila->hist_presupuesto != NULL)
                                                                <a href="presupuesto_ficha/{{$fila->hist_presupuesto}}">
                                                                    <tr class="auto">
                                                                        <td style="width: 20%; text-align: center">{{$fila->fecha}}</td>
                                                                        <td>{{$fila->hist_comentario}}<a class="makeshift_link" href="{{url("presupuesto_ficha/".$fila->hist_presupuesto)}}" style="float:right">Ver Presupuesto</a></td>
                                                                    </tr>
                                                                </a>
                                                            @else
                                                                @if ($fila->hist_auto)
                                                                    <tr class="auto">
                                                                        <td style="width: 20%; text-align: center">{{$fila->fecha}}</td>
                                                                        <td>{{$fila->hist_comentario}}</td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td style="width: 20%; text-align: center">{{$fila->fecha}}</td>
                                                                        <td>{{$fila->hist_comentario}}</td>
                                                                    </tr>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jgrowl.css')}}" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js"></script>

  <script>

    $(document).ready(function() {
        if($('#val_admin').val() == 'true'){
            $.jGrowl("Rellene la información de pago necesaria para la validación", { header: 'ERROR: Validación Administrativa', theme: 'failure' }, 6000);
            $('#eventForm').modal('toggle');
        }
    });

    function revelarBotones(){
        $('#btn_submit').show();
        $('#btn_cancel').show();
        $('#btn_mod').hide();
    }

  </script>

  <!-- Main Js Required -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  <!-- <script src="{{asset('assets/js/importes.js')}}"></script> -->

@endsection
