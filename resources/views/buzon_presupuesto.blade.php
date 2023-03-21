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
          <li class="breadcrumb-item">Presupuestos</li>
          <li class="breadcrumb-item active">Buzón de Presupuestos</li>
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
                <div class="card-title">Presupuestos</div>
              </div>
              <div class="card-body">
                <ul class="custom-list2">
                  <li>
                    <a href="/form_presupuesto">Crear Presupuesto</a>
                  </li>
                  <li>
                    <a href="/buzon_presupuesto">Buzón de Presupuestos</a>
                  </li>
                  <li>
                    <a href="/historico_presupuesto">Historico de Presupuestos</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
            <div class="card">
              <div class="card-body">
                  <div class="buzon">
                      <div class="table-responsive">
                          <h3>PRESUPUESTOS PENDIENTES POR PRESENTAR</h3>
                          <table class="table">
                            <thead>
                              <tr style="text-align: center">
                                <th>Número</th>
                                <th>Anunciante</th>
                                <th>Teléfono</th>
                                <th>Gestión</th>
                                <th>Importe</th>
                                <th>Fecha Inicio</th>
                                <th style="width: 14%;"></th>
                                <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($pendientes as $pend)
                                  <tr style="text-align: center">
                                      <td>#{{$pend->pre_id}}</td>
                                      <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pend->pre_cliente)}}">{{$pend->clientes->cli_anu}}</a></td>
                                      <td>{{$pend->clientes->cli_tel1}}</td>
                                      <td>{{$pend->asesores->ase_nombre}}</td>
                                      <td>{{number_format($pend->pre_tot_neto, 2, ',', '.')}} €</td>
                                      <td>{{$pend->pre_dateini}}</td>
                                      <td></td>
                                      <td style="width: 450px;">
                                          <a href="{{url('/mail/'.$pend->pre_id)}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="Enviar Correo" style="margin-bottom: 10px; margin-right: 10px;">Enviar Correo</button></a>
                                          <button class="btn btn-info" data-toggle="modal" data-target='#genPDF{{$pend->pre_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Generar PDF"   style="margin-bottom: 10px">Generar PDF</button>
                                          <div class="modal fade" id="genPDF{{$pend->pre_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                  <div class="modal-content" style="width:535px">
                                                    <form action="{{url('intermedioPDF')}}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="basicModalLabel">Generar PDF</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                 <input type="hidden" name="pre_id" value="{{$pend->pre_id}}">
                                                                 @if ($pend->existe_evento)
                                                                     <br>
                                                                     <label for="message-text" class="col-form-label">Ya existe una fecha de contacto para ese cliente, Elija una opción:</label>
                                                                     <br><br>
                                                                     <input type="radio" id="vincular" name="vincular" value="Y" required onclick="requerirfecha()">
                                                                     <label for="html">Vincular la fecha de contacto existente a este presupuesto</label><br>
                                                                     <br>
                                                                     <input type="radio" id="novincular" name="vincular" value="N" required onclick="requerirfecha()">
                                                                     <label for="css">Establecer una nueva fecha de contacto donde se presente este presupuesto</label><br>
                                                                     <br>
                                                                     <div id="fecha_div" style="display: none;">
                                                                         <label for="message-text" class="col-form-label" >Indique la fecha de presentación del PDF:</label>
                                                                         <input type="date" id="fecha_pdf" name="fecha_pdf" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
                                                                         <label for="message-text" class="col-form-label">Tipo de la nueva visita:</label>
                                                                         <select class="form-control" id="tipo_visita" name="tipo_visita" required>
                                                                             <option value="">Seleccione un tipo de visita</option>
                                                                             <option value="Llamada">Llamada</option>
                                                                             <option value="Reunion">Reunión</option>
                                                                             <option value="Email">Email</option>
                                                                         </select>
                                                                     </div>
                                                                 @else
                                                                     <div id="fecha_div">
                                                                         <label for="message-text" class="col-form-label" >Indique la fecha de presentación del PDF:</label>
                                                                         <input type="date" id="fecha_pdf" name="fecha_pdf" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
                                                                         <label for="message-text" class="col-form-label">Tipo de la nueva visita:</label>
							                                             <select class="form-control" id="tipo_visita" name="tipo_visita" required>
                                                                             <option value="">Seleccione un tipo de visita</option>
                                                                             <option value="Llamada">Llamada</option>
                                                                             <option value="Reunion">Reunión</option>
                                                                             <option value="Email">Email</option>
                                                                         </select>
                                                                     </div>
                                                                 @endif

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
                  <div class="buzon">
                      <div class="table-responsive">
                          <h3>CAMPAÑA GENERAL</h3>
                          <table class="table">
                            <thead>
                              <tr style="text-align: center">
                                <th>Número</th>
                                <th>Anunciante</th>
                                <th>Teléfono</th>
                                <th>Gestión</th>
                                <th>Importe</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Presentación</th>
                                <th style="width: 450px;">Opciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($presupuestos as $pre)
                                  @if ($pre->pre_acc_com === NULL)
                                      <tr style="text-align: center">
                                          <td>#{{$pre->pre_id}}</td>
                                          <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pre->pre_cliente)}}">{{$pre->clientes->cli_anu}}</a></td>
                                          <td>{{$pre->clientes->cli_tel1}}</td>
                                          <td>{{$pre->asesores->ase_nombre}}</td>
                                          <td>{{number_format($pre->pre_tot_neto, 2, ',', '.')}} €</td>
                                          <td>{{$pre->pre_dateini}}</td>
                                          <td>{{$pre->pre_dateprox}}</td>
                                          <td style="width: 400px;">
                                              <?php $flag = false ?>
                                              @if($pre->pre_valido == 0)
                                                  <center><b style="color:red">¡ÓPTICO INVÁLIDO!</b></center>
                                                  <br>
                                                  <?php $flag = true ?>
                                              @endif


                                              @if($pre->pre_pago_valido == 0)
                                                  <center><b style="color:red">Forma de pago incompleta</b></center>
                                                  <br>
                                                  <?php $flag = true ?>
                                              @endif

                                              @if($pre->clientes->cli_est_cli != "POTENCIAL VALIDO" AND $pre->clientes->cli_est_cli != "ACEPTADO")
                                                  <center><b style="color:red">¡FALTA VALIDACIÓN ADMINISTRATIVA!</b></center>
                                                  <br>
                                                  <?php $flag = true ?>
                                              @endif

                                              @if($flag)
                                                  <button class="btn btn-primary"   data-toggle="modal" data-target='#aceptarModal{{$pre->pre_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Aceptar"   style="margin-bottom: 10px; margin-right: 10px;" disabled>Aceptar</button>
                                              @else
                                                  <button class="btn btn-primary"   data-toggle="modal" data-target='#aceptarModal{{$pre->pre_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Aceptar"   style="margin-bottom: 10px; margin-right: 10px;" >Aceptar</button>
                                              @endif

                                              <button class="btn btn-secondary" data-toggle="modal" data-target='#rechazarModal{{$pre->pre_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Rechazar"  style="margin-bottom: 10px; margin-right: 10px;">Rechazar</button>

                                              <a href="{{url('/modificarPresupuesto/'.$pre->pre_id)}}"><button class="btn btn-warning" tabindex="0" aria-controls="copy-print-csv" type="button" value="Modificar" style="margin-bottom: 10px; margin-right: 10px;">Modificar</button></a>
                                              {{-- TODO HACER UNA NUEVA RUTA QUE PUEDA ENVIAR LA MISMA INFO QUE CUANDO LE DAMOS A GENERAR EL PDF DE UN PRESUPUESTO PENDIENTE POR PRESENTAR --}}
                                              <a href="{{url('/intermedioPDF/'.$pre->pre_id)}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="Generar PDF"  style="margin-bottom: 10px">Generar PDF</button></a>
                                              <div class="modal fade" id="aceptarModal{{$pre->pre_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                      <div class="modal-content" style="width:90%">
                                                        <form action="{{url('aceptar_presupuesto')}}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="basicModalLabel">Aceptar Presupuesto</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                     <input type="hidden" name="pre_id" value="{{$pre->pre_id}}">
                                                                     <label for="message-text" class="col-form-label">Indique la matrícula de las siguientes tarifas:</label>
                                                                     <br>
                                                                     @foreach ($linea_presupuesto as $lin)
                                                                         @if ($lin->lin_pre_pre == $pre->pre_id)
                                                                             <label for="message-text" class="col-form-label">{{$lin->soportes_presupuestos->sop_pre_nombre}} - {{$lin->tarifas_presupuestos->tar_pre_nombre}} - {{$lin->duracion_presupuestos->dur_pre_nombre}} - {{$lin->lin_pre_ncu}} cuñas</label>
                                                                             <br>
                                                                             <input type="text" name="matricula{{$lin->lin_pre_id}}" required>
                                                                         @endif
                                                                     @endforeach
                                                                     <br>
                                                                     <label for="message-text" class="col-form-label">Fecha de la nueva visita:</label>
                                                                     <input type="date" id="fecha_rechazo" name="fecha_rechazo" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
                                                                     <label for="message-text" class="col-form-label">Tipo de la nueva visita:</label>
                                                                     <select class="form-control" id="visita_rechazo" name="visita_rechazo" required>
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
                                              <div class="modal fade" id="rechazarModal{{$pre->pre_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                      <div class="modal-content">
                                                        <form action="{{url('rechazar_presupuesto')}}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="basicModalLabel">Rechazar Presupuesto</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                     <input type="hidden" name="pre_id" value="{{$pre->pre_id}}">
                                                                     <label for="message-text" class="col-form-label">Motivo del rechazo:</label>
                                                                     <textarea class="form-control" id="motivo_rechazo" name="motivo_rechazo" required></textarea>
                                                                     <label for="message-text" class="col-form-label">Fecha de la nueva visita:</label>
                                                                     <input type="date" id="fecha_rechazo" name="fecha_rechazo" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
                                                                     <label for="message-text" class="col-form-label">Tipo de la nueva visita:</label>
                                                                     <select class="form-control" id="visita_rechazo" name="visita_rechazo" required>
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
                                          </td>
                                      </tr>
                                  @endif
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                  </div>
                  @foreach ($acc_com as $acc_comercial)
                      <div class="buzon">
                          <div class="table-responsive">
                              <h3>{{$acc_comercial->acc_com_name}} - {{$acc_comercial->acc_com_tipo}}</h3>
                              <table class="table">
                                <thead>
                                  <tr style="text-align: center">
                                    <th>Número</th>
                                    <th>Anunciante</th>
                                    <th>Teléfono</th>
                                    <th>Gestión</th>
                                    <th>Importe</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Presentación</th>
                                    <th style="width: 350px;">Opciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($presupuestos as $pre)
                                      @if ($pre->pre_acc_com == $acc_comercial->pre_id)
                                          <tr style="text-align: center">
                                              <td>#{{$pre->pre_id}}</td>
                                              <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pre->pre_cliente)}}">{{$pre->clientes->cli_anu}}</a></td>
                                              <td>{{$pre->clientes->cli_tel1}}</td>
                                              <td>*GESTION*</td>
                                              <td>{{number_format($pre->pre_tot_neto, 2, ',', '.')}} €</td>
                                              <td>{{$pre->pre_dateini}}</td>
                                              <td>{{$pre->pre_dateprox}}</td>

                                              <td style="width: 450px;">
                                                  <?php $flag = false ?>
                                                  @if($pre->pre_valido == 0)
                                                      <center><b style="color:red">¡ÓPTICO INVÁLIDO!</b></center>
                                                      <br>
                                                      <?php $flag = true ?>
                                                  @endif


                                                  @if($pre->pre_pago_valido == 0)
                                                      <center><b style="color:red">Forma de pago incompleta</b></center>
                                                      <br>
                                                      <?php $flag = true ?>
                                                  @endif

                                                  @if($pre->clientes->cli_est_cli != "POTENCIAL VALIDO" AND $pre->clientes->cli_est_cli != "ACEPTADO")
                                                      <center><b style="color:red">¡FALTA VALIDACIÓN ADMINISTRATIVA!</b></center>
                                                      <br>
                                                      <?php $flag = true ?>
                                                  @endif

                                                  @if($flag)
                                                      <button class="btn btn-primary"   data-toggle="modal" data-target='#aceptarModal{{$pre->pre_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Aceptar"   style="margin-bottom: 10px; margin-right: 10px;" disabled>Aceptar</button>
                                                  @else
                                                      <button class="btn btn-primary"   data-toggle="modal" data-target='#aceptarModal{{$pre->pre_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Aceptar"   style="margin-bottom: 10px; margin-right: 10px;" >Aceptar</button>
                                                  @endif

                                                  <button class="btn btn-secondary" data-toggle="modal" data-target='#rechazarModal{{$pre->pre_id}}' tabindex="0" aria-controls="copy-print-csv" type="button" value="Rechazar"  style="margin-bottom: 10px; margin-right: 10px;">Rechazar</button>
                                                  <a href="{{url('/modificarPresupuesto/'.$pre->pre_id)}}"><button class="btn btn-warning" tabindex="0" aria-controls="copy-print-csv" type="button" value="Modificar" style="margin-bottom: 10px">Modificar</button></a>
                                                  <a href="{{url('/intermedioPDF/'.$pre->pre_id)}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="Generar PDF"  style="margin-bottom: 10px">Generar PDF</button></a>
                                                  <div class="modal fade" id="aceptarModal{{$pre->pre_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                            <form action="{{url('aceptar_presupuesto')}}" method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="basicModalLabel">Aceptar Presupuesto</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                         <input type="hidden" name="pre_id" value="{{$pre->pre_id}}">
							                                             <label for="message-text" class="col-form-label">Indique la matrícula de las siguientes tarifas:</label>
                                                                         <br>
                                                                         @foreach ($linea_presupuesto as $lin)
                                                                             @if ($lin->lin_pre_pre == $pre->pre_id)
                                                                                 <label for="message-text" class="col-form-label">{{$lin->soportes_presupuestos->sop_pre_nombre}} - {{$lin->tarifas_presupuestos->tar_pre_nombre}} - {{$lin->duracion_presupuestos->dur_pre_nombre}} - {{$lin->lin_pre_ncu}} cuñas</label>
                                                                                 <br>
                                                                                 <input type="text" name="matricula{{$lin->lin_pre_id}}" required>
                                                                                 <br>
                                                                             @endif
                                                                         @endforeach
                                                                         <br>
                                                                         <label for="message-text" class="col-form-label">Fecha de la nueva visita:</label>
                                                                         <input type="date" id="fecha_rechazo" name="fecha_rechazo" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
                                                                         <label for="message-text" class="col-form-label">Tipo de la nueva visita:</label>
                                                                         <select class="form-control" id="visita_rechazo" name="visita_rechazo" required>
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
                                                  <div class="modal fade" id="rechazarModal{{$pre->pre_id}}" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                            <form action="{{url('rechazar_presupuesto')}}" method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="basicModalLabel">Rechazar Presupuesto</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                         <input type="hidden" name="pre_id" value="{{$pre->pre_id}}">
							                                             <label for="message-text" class="col-form-label">Motivo del rechazo:</label>
                                                                         <textarea class="form-control" id="motivo_rechazo" name="motivo_rechazo" required></textarea>
                                                                         <label for="message-text" class="col-form-label">Fecha de la nueva visita:</label>
                                                                         <input type="date" id="fecha_rechazo" name="fecha_rechazo" min="<?php echo date('Y-m-d') ?>" class="form-control" required>
                                                                         <label for="message-text" class="col-form-label">Tipo de la nueva visita:</label>
							                                             <select class="form-control" id="visita_rechazo" name="visita_rechazo" required>
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
                                              </td>
                                          </tr>
                                      @endif
                                  @endforeach
                                </tbody>
                              </table>
                          </div>
                      </div>
                  @endforeach
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
  function requerirfecha(){

      var fecha = document.getElementById('fecha_pdf');
      var tipo  = document.getElementById('tipo_visita');

      if(document.getElementById('vincular').checked){
          fecha.removeAttribute('required');
          tipo.removeAttribute('required');
          document.getElementById('fecha_div').style.display = 'none';
      }
      else{
          fecha.setAttribute('required', true);
          tipo.setAttribute('required', true);
          document.getElementById('fecha_div').style.display = 'block';
      }
    }
  </script>

@endsection
