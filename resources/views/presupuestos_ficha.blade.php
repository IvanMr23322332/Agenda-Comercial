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
                       <li class="breadcrumb-item">Presupuestos</li>
                       <li class="breadcrumb-item active">Ficha Presupuesto</li>
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
                       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                           <h3>Resumen de campaña - {{$mod_pre[0]->clientes->cli_anu}}</h3>
                           <div class="row gutters">
                               <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                   <div class="form-group">
                                       <label for="phone">Acción Comercial</label>
                                       @if ($acc_com != NULL)
                                           <h4>{{$acc_com->acc_com_name}} - {{$acc_com->acc_com_tipo}}</h4>
                                       @else
                                           <h4>Sin acción comercial</h4>
                                       @endif

                                   </div>
                               </div>
                               <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                   <div class="form-group">
                                       <label for="phone">Facturación Anual</label>
                                       <input type="number" onchange="calcularDescuento()" class="form-control" id="factAnual" name="factAnual" value="{{$mod_pre[0]->pre_fact_anu}}" placeholder="Introduzca su facturación anual" min="0" readonly>
                                   </div>
                               </div>
                               <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                   <div class="form-group">
                                       <label for="phone">Antigüedad</label>

                                       <input type="number" onchange="calcularDescuento()" class="form-control" id="antig" name="antig" value="{{$mod_pre[0]->pre_antig}}" placeholder="Introduzca la antigüedad" min="0" readonly>

                                       <label id="err_antig" style="font-size: 0.75rem; color: red; display: none;">Introduzca una antigüedad válida</label>
                                   </div>
                               </div>
                               <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                   <div class="form-group">
                                       <label for="phone">Pronto Pago</label>
                                       <div class="custom-control custom-switch">
                                           <input type="checkbox" onchange="calcularDescuento()" class="custom-control-input" id="prontoPago" name="prontoPago">
                                           <label class="custom-control-label" for="prontoPago">Habilitar descuento pronto pago</label>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                   <div class="form-group">
                                       <div class="form-group">
                                           <label for="phone">Observaciones</label>
                                           <input type="text" class="form-control" id="observ" name="observ" max="50" readonly>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"></div>
                               <input type="number" class="form-control" style="display: none;" id="numSop" value="0">
                               @if (isset($cont))
                                   <input type="number" class="form-control" style="display: none;" id="contador" name="contador" value="{{$cont}}">
                                   <input type="number" class="form-control" style="display: none;" id="true_cont" name="true_cont" value="{{$cont}}">
                               @else
                                   <input type="number" class="form-control" style="display: none;" id="contador" name="contador" value="0">
                                   <input type="number" class="form-control" style="display: none;" id="true_cont" name="true_cont" value="0">
                               @endif
                               <input type="number" class="form-control" style="display: none;" id="target" value="0">
                               <input type="number" class="form-control" style="display: none;" id="targetSop" value="0">
                               <input type="number" class="form-control" style="display: none;" id="contSop" value="0">
                               <input type="number" class="form-control" style="display: none;" id="isEdit" value="1">
                               <input type="number" class="form-control" style="display: none;" id="lin_pre" value="{{$lin_pre}}">
                               <input type="number" class="form-control" style="display: none;" id="page" value="1">
                               <div id="opt_empty_list"></div>
                               @if (isset($mod_pre))
                                   <input type="number" class="form-control" style="display: none;" name="mod_id" id="mod_id" value="{{$mod_pre[0]->pre_id}}">
                               @endif
                               @foreach ($sop_pre as $sop_presupuesto)
                                   @if (isset($mod_pre))
                                       <input type="number" class="form-control" style="display: none;" id="opt_cont{{$sop_presupuesto->sop_pre_id}}" name="opt_cont{{$sop_presupuesto->sop_pre_id}}" value="{{$sop_presupuesto->cantidad}}">
                                   @else
                                       <input type="number" class="form-control" style="display: none;" id="opt_cont{{$sop_presupuesto->sop_pre_id}}" name="opt_cont{{$sop_presupuesto->sop_pre_id}}" value="0">
                                   @endif

                               @endforeach
                               <div style="display: none;">
                                   <table>
                                       <tbody>
                                           @foreach ($pre_pre as $pre_presupuesto)
                                               <td id="precio{{$pre_presupuesto->pre_pre_tarifa}}{{$pre_presupuesto->pre_pre_duracion}}">{{$pre_presupuesto->pre_pre_value}}</td>
                                           @endforeach
                                           @foreach ($des_pre as $des_presupuesto)
                                               <td id="desc{{$des_presupuesto->des_pre_soporte}}{{$des_presupuesto->des_pre_duracion}}">{{$des_presupuesto->des_pre_value}}</td>
                                           @endforeach
                                       </tbody>
                                   </table>
                               </div>

                               <div style="display:none">
                                   @foreach ($sociedades as $sociedad)
                                       <input type="text" id="sociedad_nombre{{$sociedad->id}}" 		value="{{$sociedad->soc_nom}}">
                                       <input type="text" id="sociedad_cif{{$sociedad->id}}" 		value="{{$sociedad->soc_cif}}">
                                       <input type="text" id="sociedad_direccion{{ $sociedad->id}}" 	value="{{$sociedad->soc_dir}}">
                                       <input type="text" id="sociedad_cp{{$sociedad->id}}" 			value="{{$sociedad->soc_cp}}">
                                       <input type="text" id="sociedad_localidad{{$sociedad->id}}" 	value="{{$sociedad->soc_loc}}">
                                       <input type="text" id="sociedad_provincia{{$sociedad->id}}" 	value="{{$sociedad->soc_pro}}">
                                       <input type="text" id="sociedad_telefono{{$sociedad->id}}" 		value="{{$sociedad->soc_tlf}}">
                                   @endforeach
                               </div>

                               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>
                               <div class="col-xl-12 col-lg col-md-12 col-sm-12 col-12">
                                   @foreach ($sop_pre as $consulta)
                                       <div class="modal fade sop{{$consulta->sop_pre_id}} show" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" style="display: none;" aria-modal="true">
                                           <div class="modal-dialog modal-xl" style="max-width: 1800px !important; margin-top: 3rem !important;">
                                               <div class="modal-content">
                                                   <div class="modal-header">
                                                       <h5 class="modal-title" id="myExtraLargeModalLabel">Óptico {{$consulta->sop_pre_nombre}}</h5>
                                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                           <span aria-hidden="true">×</span>
                                                       </button>
                                                   </div>
                                                   <div class="modal-body">
                                                       <div id="contadores{{$consulta->sop_pre_id}}">
                                                           @if (isset($mod_lin))
                                                               @foreach ($mod_lin as $mod_linea)
                                                                   @if ($mod_linea->lin_pre_sop == $consulta->sop_pre_id)
                                                                       <input style="display:none" id="opt_empty{{$mod_linea->lin_pre_lin}}" name="opt_empty{{$mod_linea->lin_pre_lin}}" type="number" value="{{$mod_linea->lin_pre_valido}}">
                                                                       <div id='contador_cunyas_restantes{{$mod_linea->lin_pre_lin}}' class='table-responsive' style='float: right; width: 172px; text-align: center;'>
                                                                           <table class='table table-bordered'>
                                                                               <thead style='background-color: #27e397;'>
                                                                                   <th><b>Nº Cuñas {{$mod_linea->tarifas_presupuestos->tar_pre_nombre}}</b></th>
                                                                               </thead>
                                                                               <tbody>
                                                                                   <tr>
                                                                                       <td align='center'><input id='contador_cunyas{{$mod_linea->lin_pre_tar}}' type='number' style='text-align: center; width: 30px; border: 0;' value='{{$mod_linea->lin_pre_ncu}}' readonly></td>
                                                                                   </tr>
                                                                               </tbody>
                                                                           </table>
                                                                       </div>
                                                                   @endif
                                                               @endforeach
                                                           @endif
                                                       </div>
                                                       <div class="table-responsive">
                                                           <table class="table table-bordered">
                                                               <thead style="background-color: #27e397;">
                                                                   <th class="optico" class="optico"><b>Mes / Matrícula</b></th>
                                                                   <th class="optico"><b>Duración</b></th>
                                                                   <th class="optico"><b>Tarifa</b></th>
                                                                   <th class="optico"><b>Hora</b></th>
                                                                   @for ($i=1; $i <= 31; $i++)
                                                                       <th class="optico"><b>{{$i}}</b></th>
                                                                   @endfor
                                                                   <th class="optico"><b>Uds.</b></th>
                                                               </thead>
                                                               <tbody id="opt_tabla{{$consulta->sop_pre_id}}">
                                                                   @if (isset($mod_opt))
                                                                       @foreach ($mod_opt as $mod_optico)
                                                                           @if ($mod_optico->opt_fil_isdata == 0)
                                                                               @if ($mod_optico->opt_fil_sop == $consulta->sop_pre_id)
                                                                                   <tr id="mes{{$mod_optico->opt_fil_anyo}}{{$mod_optico->opt_fil_mes-1}}{{$mod_optico->opt_fil_sop}}" data-anyo='{{$mod_optico->opt_fil_anyo}}' data-mes='{{$mod_optico->opt_fil_mes-1}}' style='background-color: #a0dec5'>
                                                                                       <td colspan='4' style='padding-left: 10px;' ><input type='text' id='mes_name{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}' name='mes_name{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}' value='{{$mod_optico->mes->mes_nombre}}' readonly style='border: none; background-color: #a0dec5; padding: none;'></td>
                                                                                       @for ($i=1; $i <= 31; $i++)
                                                                                           @php
                                                                                               $index = 'opt_fil_data' . $i;
                                                                                           @endphp
                                                                                           @if ($mod_optico->$index == "S" || $mod_optico->$index == "D")
                                                                                               <td style='background-color: #decda0; padding: 2px;' align='center'>
                                                                                                   <input type='text' id='dia{{$i}}_{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}' name='dia{{$i}}_{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}' value='{{$mod_optico->$index}}' readonly style='border: none; background-color: #decda0; text-align: center; width: 30px; padding: none;'>
                                                                                               </td>
                                                                                           @elseif ($mod_optico->$index == "0")
                                                                                               <td style='padding: 2px;' align='center'></td>
                                                                                           @else
                                                                                               <td style='padding: 2px;' align='center'>
                                                                                                   <input type='text' id='dia{{$i}}_{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}' name='dia{{$i}}_{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}' value='{{$mod_optico->$index}}' readonly style='border: none; background-color: #a0dec5; text-align: center; width: 30px; padding: none;'>
                                                                                               </td>
                                                                                           @endif
                                                                                       @endfor
                                                                                       <td></td>
                                                                                   </tr>
                                                                               @endif
                                                                           @else
                                                                               @if ($mod_optico->opt_fil_sop == $consulta->sop_pre_id)
                                                                               <tr id='val{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' data-linea='{{$mod_optico->linea_presupuestos->lin_pre_lin}}' data-anyo='{{$mod_optico->opt_fil_anyo}}"' data-mes='{{$mod_optico->opt_fil_mes-1}}'>
                                                                                   <td><input type='text' id='matricula{{$mod_optico->opt_fil_mes-1}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}' name='matricula{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' value="{{$mod_optico->opt_fil_mat}}" style='width: 100px; border: 0;' readonly></td>
                                                                                   <td>
                                                                                       <input type='text' id='dur{{$mod_optico->opt_fil_mes-1}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}' style='width: 60px; border: 0; text-align: center;' value='{{$mod_optico->duracion_presupuestos->dur_pre_nombre}}' readonly>
                                                                                       <input type='number' name='dur_opt_id{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' value='{{$mod_optico->opt_fil_dur}}' style='display: none;'>
                                                                                       <input type='number' class='form-control' style='display: none;' name='id_lin{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' value='{{$mod_optico->linea_presupuestos->lin_pre_lin}}'>
                                                                                   </td>
                                                                                   <td>
                                                                                       <input type='text' id='tar{{$mod_optico->opt_fil_mes-1}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}' style='width: 100px; border: 0; text-align: center;' value='{{$mod_optico->tarifas_presupuestos->tar_pre_nombre}}' readonly>
                                                                                       <input type='number' name='tar_opt_id{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' value='{{$mod_optico->opt_fil_tar}}' style='display: none;'>
                                                                                   </td>
                                                                                   <td><input type='text' id='hora{{$mod_optico->opt_fil_mes-1}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}' name='hora{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' style='width: 40px; border: 0;'></td>

                                                                                   @for ($i=1; $i <= 31; $i++)
                                                                                       @php
                                                                                           $index = 'opt_fil_data' . $i;
                                                                                       @endphp

                                                                                       @if ($mod_optico->$index == "-1")
                                                                                           <td style='padding: 0; background-color: #c7c7c7;' align='center'></td>
                                                                                       @elseif ($mod_optico->$index == "0")
                                                                                           <td style='padding: 0;' align='center'>
                                                                                               <input readonly type='number' id='{{$mod_optico->opt_fil_mes-1}}val{{$i}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}' name='val{{$i}}_{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' onchange='calcularLinea({{$mod_optico->opt_fil_mes-1}} ,{{$mod_optico->d_month}} ,{{$mod_optico->mes_ini-1}} ,{{$mod_optico->opt_fil_tar}} ,{{$mod_optico->linea_presupuestos->lin_pre_lin}} ,{{$mod_optico->any_ini}} ,{{$mod_optico->opt_fil_anyo}} ,{{$i}})' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'>
                                                                                           </td>
                                                                                       @else
                                                                                           <td style='padding: 0;' align='center'>
                                                                                               <input readonly type='number' value="{{$mod_optico->$index}}" id='{{$mod_optico->opt_fil_mes-1}}val{{$i}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}' name='val{{$i}}_{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' onchange='calcularLinea({{$mod_optico->opt_fil_mes-1}} ,{{$mod_optico->d_month}} ,{{$mod_optico->mes_ini-1}} ,{{$mod_optico->opt_fil_tar}} ,{{$mod_optico->linea_presupuestos->lin_pre_lin}} ,{{$mod_optico->any_ini}} ,{{$mod_optico->opt_fil_anyo}} ,{{$i}})' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'>
                                                                                           </td>
                                                                                       @endif
                                                                                   @endfor
                                                                                   <td><input id='total{{$mod_optico->opt_fil_mes-1}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}{{$mod_optico->opt_fil_anyo}}' name='total{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' type='number' style='width: 30px; border: 0; text-align: center;' value='{{$mod_optico->opt_fil_datauds}}' readonly></td>
                                                                               </tr>
                                                                               @endif
                                                                           @endif
                                                                       @endforeach
                                                                   @endif
                                                               </tbody>
                                                           </table>
                                                       </div>
                                                       <input type="number" id="actual_mes" style="display: none;">
                                                       <input type="number" id="actual_anyo" style="display: none;">
                                                   </div>
                                                   <div class="modal-footer">
                                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   @endforeach
                               </div>
                               <div class="col-xl-12 col-lg col-md-12 col-sm-12 col-12">
                                   <div style="background-color: #c7c7c7;height:300px;overflow:scroll;">
                                       <div class="table-responsive">
                                           <table class="table table-bordered">
                                               <thead style="background-color: #27e397;">
                                                   <th><b>Soporte</b></th>
                                                   <th><b>Tarifa</b></th>
                                                   <th><b>Nº cuñas</b></th>
                                                   <th><b>Duración</b></th>
                                                   <th><b>Fecha Inicio</b></th>
                                                   <th><b>Fecha Fin</b></th>
                                                   <th><b>Descuento</b></th>
                                                   <th><b>Neto</b></th>
                                                   <th width="200px"><b>Opciones</b></th>
                                               </thead>
                                               <tbody id="inter_tabla">
                                                   @if (isset($mod_lin))
                                                       @foreach ($mod_lin as $mod_linea)
                                                           <tr class='filasTabla' id="fila{{$mod_linea->lin_pre_lin}}">
                                                               <td><input id="soporte{{$mod_linea->lin_pre_lin}}" name="soporte{{$mod_linea->lin_pre_lin}}" data-id="{{$mod_linea->lin_pre_sop}}" type='text' readonly style='border: none; width: 100%' value="{{$mod_linea->soportes_presupuestos->sop_pre_nombre}}"><input type='number' name="sop_id{{$mod_linea->lin_pre_lin}}" value="{{$mod_linea->lin_pre_sop}}" style='display: none;'></td>
                                                               <td><input id="tarifa{{$mod_linea->lin_pre_lin}}" name="tarifa{{$mod_linea->lin_pre_lin}}" data-id="{{$mod_linea->lin_pre_tar}}" type='text' readonly style='border: none; width: 100%' value="{{$mod_linea->tarifas_presupuestos->tar_pre_nombre}}"><input type='number' name="tar_id{{$mod_linea->lin_pre_lin}}" value="{{$mod_linea->lin_pre_tar}}" style='display: none;'></td>
                                                               <td><input id="ncunya{{$mod_linea->lin_pre_lin}}" name="ncunya{{$mod_linea->lin_pre_lin}}" type='text' readonly style='border: none; width: 100%' value='{{$mod_linea->lin_pre_ncu}}'></td>
                                                               <td><input id="duracion{{$mod_linea->lin_pre_lin}}" name="duracion{{$mod_linea->lin_pre_lin}}" data-id="{{$mod_linea->lin_pre_dur}}" type='text' readonly style='border: none; width: 100%' value="{{$mod_linea->duracion_presupuestos->dur_pre_nombre}}"><input type='number' name="dur_id{{$mod_linea->lin_pre_lin}}" value="{{$mod_linea->lin_pre_dur}}" style='display: none;'></td>
                                                               <td><input id="fechaini{{$mod_linea->lin_pre_lin}}" name="fechaini{{$mod_linea->lin_pre_lin}}" type='text' readonly style='border: none; width: 100%' value='{{$mod_linea->lin_pre_dateini}}'></td>
                                                               <td><input id="fechafin{{$mod_linea->lin_pre_lin}}" name="fechafin{{$mod_linea->lin_pre_lin}}" type='text' readonly style='border: none; width: 100%' value='{{$mod_linea->lin_pre_datefin}}'></td>
                                                               <td><input id="desc{{$mod_linea->lin_pre_lin}}" name="desc{{$mod_linea->lin_pre_lin}}" type='text' readonly style='border: none; width: 100%' value='{{$mod_linea->lin_pre_desc}}'></td>
                                                               <td><input id="neto{{$mod_linea->lin_pre_lin}}" name="neto{{$mod_linea->lin_pre_lin}}" type='text' readonly style='border: none; width: 100%' value='{{$mod_linea->lin_pre_prec}}'></td>
                                                               <td>
                                                                   <img class='icono_opciones edit_line' style='margin-right:30px' data-toggle='modal' data-target='.sop{{$mod_linea->lin_pre_sop}}' src='/assets/img/optico.png' width='30px' height='30px' alt='Ver Óptico' title='Ver Óptico'>
                                                               </td>
                                                           </tr><input type='number' id="total_cunyas{{$mod_linea->lin_pre_lin}}" value='{{$mod_linea->lin_pre_ncu}}' style='display: none;'>
                                                       @endforeach
                                                   @endif
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xl-9 col-lg col-md-9 col-sm-9 col-9">
                                   <label id="err_tabla" style="display: none; font-size: 0.75rem; color: red;">La tabla de presupuestos no puede estar vacía</label>
                               </div>
                               <div class="col-xl-3 col-lg col-md-3 col-sm-3 col-3" style="padding-top: 10px; text-align: right;">
                                   <div class="table-responsive" id="tablaTotal">
                                       <table class="table table-bordered">
                                           <tr>
                                               <td style="width: 200px;">TOTAL BRUTO</td>
                                               <td style="text-align: left;width: 120px;"><input id="totalbrut" name="totalbrut" type="text" readonly style="border: none; width: 80px;" value="{{$mod_pre[0]->pre_tot_brut}} €"></td>
                                           </tr>
                                           <tr>
                                               <td style="width: 200px;">TOTAL DESCUENTO</td>
                                               <td style="text-align: left;width: 120px;"><input id="totaldesc" name="totaldesc" type="text" readonly style="border: none; width: 80px;" value="{{$mod_pre[0]->pre_tot_desc}} %"></td>
                                           </tr>
                                           <tr>
                                               <td style="width: 200px;">TOTAL NETO</td>
                                               <td style="text-align: left;width: 120px;"><input id="totalneto" name="totalneto" type="text" readonly style="border: none; width: 80px;" value="{{$mod_pre[0]->pre_tot_neto}} €"></td>
                                           </tr>
                                       </table>
                                   </div>
                               </div>
                               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                 <a href="javascript:history.back()"><button class="btn btn-secondary" tabindex="0" aria-controls="copy-print-csv" type="button" value="volver_historico">Volver</button></a>
                                 <a href="/copiarPresupuesto/{{$mod_pre[0]->pre_id}}" style="float: right;"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="copia_presupuesto">Nuevo Presupuesto</button></a>
                                 <a href="{{url('/intermedioPDF/'.$mod_pre[0]->pre_id)}}" style="float: right; margin-right: 5px;"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="Generar PDF"  style="margin-bottom: 10px">Generar PDF</button></a>
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

       <!-- Main Js Required -->
       <script src="{{asset('assets/js/main.js')}}"></script>

       <script src="{{asset('assets/js/detalles_campanya.js')}}"></script>

@endsection
