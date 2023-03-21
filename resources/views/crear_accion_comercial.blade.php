@extends('layouts.app')

@section('section')

	@if (!isset($_SESSION))
        <?php SESSION_START() ?>
    @endif

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
						<li class="breadcrumb-item">Administrador</li>
						<li class="breadcrumb-item active">Crear Acción Comercial</li>
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
							<form action="{{url('guardar_accion_comercial')}}" method="POST" name="guardar_accion_comercial">
								@csrf
									<h3>Creación de Acción Comercial</h3>
									<div class="row gutters">
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
											<div class="form-group">
                                                <label for="acc_name">Nombre Acción Comercial</label>
												@if (isset($acc_com_id))
													<input type="text" class="form-control" id="acc_name" name="acc_name" placeholder="Introduzca el nombre de la accion comercial" value="{{$acc_com[0]->acc_com_name}}">
												@else
													<input type="text" class="form-control" id="acc_name" name="acc_name" placeholder="Introduzca el nombre de la accion comercial">
												@endif
												<label id="err_name" style="font-size: 0.75rem; color: red; display: none;">Introduzca un nombre válido</label>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
											<div class="form-group">
												<label for="acc_tipo">Tipo Acción Comercial</label>
												@if (isset($acc_com_id))
													<input type="text" class="form-control" id="acc_tipo" name="acc_tipo" placeholder="Introduzca el tipo de accion comercial" value="{{$acc_com[0]->acc_com_tipo}}">
												@else
													<input type="text" class="form-control" id="acc_tipo" name="acc_tipo" placeholder="Introduzca el tipo de accion comercial">
												@endif
												<label id="err_tipo" style="font-size: 0.75rem; color: red; display: none;">Introduzca un tipo válido</label>
											</div>
										</div>
										<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12"></div>
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
										@if (isset($acc_com_id))
											<input type="number" class="form-control" style="display: none;" name="acc_com_id" id="acc_com_id" value="{{$acc_com_id}}">
										@endif
										@foreach ($sop_pre as $sop_presupuesto)
											@if (isset($sop_presupuesto->cantidad))
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
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><hr></div>
										<div class="col-xl-2 col-lg col-md-2 col-sm-2 col-12">
											<div class="form-group">
												<label for="phone">Fecha Inicio</label>
												<input type="date" class="form-control" id="fechaini" min="<?php echo date('Y-m-d') ?>" placeholder="Introduzca la fecha de inicio">
												<label id="err_ini" style="font-size: 0.75rem; color: red; display: none;">Introduzca una fecha de inicio válida</label>
											</div>
										</div>
										<div class="col-xl-2 col-lg col-md-2 col-sm-2 col-12">
											<div class="form-group">
												<label for="phone">Fecha Fin</label>
												<input type="date" class="form-control" id="fechafin" min="<?php echo date('Y-m-d') ?>" placeholder="Introduzca la fecha de fin">
												<label id="err_fin" style="font-size: 0.75rem; color: red; display: none;">Introduzca una fecha de fin válida</label>
											</div>
										</div>
										<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12"></div>
										<div class="col-xl-2 col-lg col-md-2 col-sm-2 col-12">
											<div class="form-group">
												<label for="phone">Soporte</label>
												<select class="form-control" onchange="onChangeSoporteAccCom()" title="Seleccione un soporte" tabindex="-98" id="sop">
													<option value="">Seleccione un soporte</option>
													@foreach ($sop_pre as $sop_presupuesto)
														<option value="{{$sop_presupuesto->sop_pre_nombre}}" name="{{$sop_presupuesto->sop_pre_id}}">{{$sop_presupuesto->sop_pre_nombre}}</option>
													@endforeach
												</select>
												<label id="err_sop" style="font-size: 0.75rem; color: red; display: none;">Introduzca un soporte válido</label>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
											<div class="form-group">
												<label for="phone">Tarifa</label>
												<select class="form-control" onchange="onChangeTarifaAccCom()" tabindex="-98" id="tar">
													<option value="">Seleccione una tarifa</option>
													@foreach ($tar_pre as $tar_presupuesto)
														<option class="tar_presupuestos" id="" value="{{$tar_presupuesto->tar_pre_nombre}}" name="{{$tar_presupuesto->tar_pre_id}}" data-sop="{{$tar_presupuesto->tar_pre_soporte}}" style="display: none;">{{$tar_presupuesto->tar_pre_nombre}}</option>
													@endforeach
												</select>
												<label id="err_tar" style="font-size: 0.75rem; color: red; display: none;">Introduzca una tarifa válida</label>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
											<div class="form-group">
												<label for="phone">Numero cuñas</label>
												<input type="number" onchange="calcularDescuentoAccCom();" class="form-control" id="ncu" placeholder="Introduzca el número de cuñas">
												<label id="err_ncu" style="font-size: 0.75rem; color: red; display: none;">Introduzca un número de cuñas válido</label>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
											<div class="form-group">
												<label for="phone">Duración</label>
												<select class="form-control" onchange="calcularDescuentoAccCom();" title="Seleccione una duración" tabindex="-98" id="dur">
													<option value="">Seleccione una duración</option>
													@foreach ($dur_pre as $dur_presupuesto)
														<option class="dur_presupuestos" value="{{$dur_presupuesto->dur_pre_nombre}}" name="{{$dur_presupuesto->dur_pre_id}}" style="display: none;">{{$dur_presupuesto->dur_pre_nombre}}</option>
													@endforeach
												</select>
												<label id="err_dur" style="font-size: 0.75rem; color: red; display: none;">Introduzca una duración válida</label>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
											<div class="form-group">
												<label for="phone">Descuento</label>
												<input type="text" class="form-control" id="des" placeholder="Sin descuento" readonly>
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
											<div class="form-group">
												<label for="phone">Neto</label>
												<input type="text" class="form-control" id="net" placeholder="Sin precio" readonly>
											</div>
										</div>
										<div class="col-xl-12 col-lg col-md-12 col-sm-12 col-12">
											<button type="button" id="add_button" class="btn btn-primary" style="left: 48%; position: relative; margin-bottom: 10px" onclick="add_linea_acccom()">Añadir</button>
											<div id="botonEdit" style="float: right;" hidden="true">
												<button type='button' class='btn btn-secondary' style='margin-bottom: 10px' onclick='cancel_editAccCom()'>Cancelar</button>
												<button type='button' class='btn btn-info' style='margin-bottom: 10px' onclick='save_editAccCom()'>Guardar</button>
											</div>
											<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="basicModalLabel">Eliminar fila</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">×</span>
															</button>
														</div>
														<div class="modal-body">
															¿Desea eliminar ésta fila ?
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
															<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="eliminarAccCom()">Aceptar</button>
														</div>
													</div>
												</div>
											</div>
										</div>

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
																				<div id='contador_cunyas_restantes{{$mod_linea->lin_pre_lin}}' class='table-responsive' style='float: right; width: 172px; text-align: center;'>
																					<table class='table table-bordered'>
																						<thead style='background-color: #27e397;'>
																							<th><b>Nº Cuñas Restantes {{$mod_linea->tarifas_presupuestos->tar_pre_nombre}}</b></th>
																						</thead>
																						<tbody>
																							<tr>
																								<td align='center'><input id='contador_cunyas{{$mod_linea->lin_pre_tar}}' type='number' style='text-align: center; width: 30px; border: 0;' value='0' readonly></td>
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
																						<tr id='val{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}_{{$mod_optico->opt_fil_sop}}' data-linea='{{$mod_optico->linea_presupuestos->lin_pre_lin}}' data-anyo='{{$mod_optico->opt_fil_anyo}}"' data-mes='{{$mod_optico->opt_fil_mes-1}}'>
																							<td><input type='text' id='matricula{{$mod_optico->opt_fil_mes-1}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}' name='matricula{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' style='width: 100px; border: 0;' readonly></td>
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
																										<input type='number' id='{{$mod_optico->opt_fil_mes-1}}val{{$i}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}' name='val{{$i}}_{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' onchange='calcularLinea({{$mod_optico->opt_fil_mes-1}} ,{{$mod_optico->d_month}} ,{{$mod_optico->mes_ini-1}} ,{{$mod_optico->opt_fil_tar}} ,{{$mod_optico->linea_presupuestos->lin_pre_lin}} ,{{$mod_optico->any_ini}} ,{{$mod_optico->opt_fil_anyo}} ,{{$i}})' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'>
																									</td>
																								@else
																									<td style='padding: 0;' align='center'>
																										<input type='number' value="{{$mod_optico->$index}}" id='{{$mod_optico->opt_fil_mes-1}}val{{$i}}{{$mod_optico->linea_presupuestos->lin_pre_lin}}' name='val{{$i}}_{{$mod_optico->opt_fil_mes-1}}_{{$mod_optico->opt_fil_anyo}}_{{$mod_optico->opt_fil_sop}}_{{$mod_optico->linea_presupuestos->lin_pre_lin}}' onchange='calcularLinea({{$mod_optico->opt_fil_mes-1}} ,{{$mod_optico->d_month}} ,{{$mod_optico->mes_ini-1}} ,{{$mod_optico->opt_fil_tar}} ,{{$mod_optico->linea_presupuestos->lin_pre_lin}} ,{{$mod_optico->any_ini}} ,{{$mod_optico->opt_fil_anyo}} ,{{$i}})' min='0' max='99' style='border:0; margin-right: 0; text-align: center; height: 35px;'>
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
															@if (isset($acc_com_id))
																@foreach ($lineas_acc_com as $lin)
																	<tr class='filasTabla' id='fila{{$lin->lin_pre_lin}}'>
																		<td><input id='soporte{{$lin->lin_pre_lin}}' name='soporte{{$lin->lin_pre_lin}}' data-id='{{$lin->lin_pre_sop}}' type='text' readonly style='border: none; width: 100%' value='{{$lin->soportes_presupuestos->sop_pre_nombre}}'><input type='number' name='sop_id{{$lin->lin_pre_lin}}' value='{{$lin->lin_pre_sop}}' style='display: none;'></td>
																		<td><input id='tarifa{{$lin->lin_pre_lin}}' name='tarifa{{$lin->lin_pre_lin}}' data-id='{{$lin->lin_pre_tar}}' type='text' readonly style='border: none; width: 100%' value='{{$lin->tarifas_presupuestos->tar_pre_nombre}}'><input type='number' name='tar_id{{$lin->lin_pre_lin}}' value='{{$lin->lin_pre_tar}}' style='display: none;'></td>
																		<td><input id='ncunya{{$lin->lin_pre_lin}}' name='ncunya{{$lin->lin_pre_lin}}' type='text' readonly style='border: none; width: 100%' value='{{$lin->lin_pre_ncu}}'></td>
																		<td><input id='duracion{{$lin->lin_pre_lin}}' name='duracion{{$lin->lin_pre_lin}}' data-id='{{$lin->lin_pre_dur}}' type='text' readonly style='border: none; width: 100%' value='{{$lin->duracion_presupuestos->dur_pre_nombre}}'><input type='number' name='dur_id{{$lin->lin_pre_lin}}' value='{{$lin->lin_pre_dur}}' style='display: none;'></td>
																		<td><input id='fechaini{{$lin->lin_pre_lin}}' name='fechaini{{$lin->lin_pre_lin}}' type='text' readonly style='border: none; width: 100%' value='{{$lin->lin_pre_dateini}}'></td>
																		<td><input id='fechafin{{$lin->lin_pre_lin}}' name='fechafin{{$lin->lin_pre_lin}}' type='text' readonly style='border: none; width: 100%' value='{{$lin->lin_pre_datefin}}'></td>
																		<td><input id='desc{{$lin->lin_pre_lin}}' name='desc{{$lin->lin_pre_lin}}' type='text' readonly style='border: none; width: 100%' value='{{$lin->lin_pre_desc}}'></td>
																		<td><input id='neto{{$lin->lin_pre_lin}}' name='neto{{$lin->lin_pre_lin}}' type='text' readonly style='border: none; width: 100%' value='{{$lin->lin_pre_prec}}'></td>
																		<td>
																			<img onclick='editarAccCom({{$lin->lin_pre_lin}},{{$lin->lin_pre_sop}})' class='icono_opciones edit_line' style='margin-right:30px' src='/assets/img/lapiz.png' width='30px' height='30px' alt='Modificar Linea' title='Modificar Linea'>
																			<img class='icono_opciones edit_line' style='margin-right:30px' data-toggle='modal' data-target='.sop{{$lin->lin_pre_sop}}' src='/assets/img/optico.png' width='30px' height='30px' alt='Ver Óptico' title='Ver Óptico'>
																			<img onclick='cambiarTarget({{$lin->lin_pre_lin}},{{$lin->lin_pre_sop}})' class='icono_opciones edit_line' data-toggle='modal' data-target='#basicModal' src='/assets/img/cubo.png' width='30px' height='30px' alt='Eliminar Linea' title='Eliminar Linea'>
																		</td>
																	</tr><input type='number' id='total_cunyas{{$lin->lin_pre_lin}}' value='{{$lin->lin_pre_ncu}}' style='display: none;'>
																@endforeach
															@endif
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="col-xl-10 col-lg col-md-10 col-sm-10 col-10">
											<label id="err_tabla" style="display: none; font-size: 0.75rem; color: red;">La tabla de tarifas no puede estar vacía</label>
										</div>
										<div class="col-xl-2 col-lg col-md-2 col-sm-2 col-2" style="padding-top: 10px; text-align: right;">
											<div class="table-responsive" id="tablaTotal" style="display: none;">
												<table class="table table-bordered">
													@if (isset($acc_com))
														<tr>
															<td style="width: 150px;">TOTAL BRUTO</td>
															<td style="text-align: left;"><input id="totalbrut" name="totalbrut" type="text" value="{{$acc_com[0]->pre_tot_brut}}" readonly style="border: none; width: 80px;"></td>
														</tr>
														<tr>
															<td style="width: 150px;">TOTAL DESCUENTO</td>
															<td style="text-align: left;"><input id="totaldesc" name="totaldesc" type="text" value="{{$acc_com[0]->pre_tot_desc}}" readonly style="border: none; width: 80px;"></td>
														</tr>
														<tr>
															<td style="width: 150px;">TOTAL NETO</td>
															<td style="text-align: left;"><input id="totalneto" name="totalneto" type="text" value="{{$acc_com[0]->pre_tot_neto}}" readonly style="border: none; width: 80px;"></td>
														</tr>
													@else
														<tr>
															<td style="width: 150px;">TOTAL BRUTO</td>
															<td style="text-align: left;"><input id="totalbrut" name="totalbrut" type="text" readonly style="border: none; width: 80px;"></td>
														</tr>
														<tr>
															<td style="width: 150px;">TOTAL DESCUENTO</td>
															<td style="text-align: left;"><input id="totaldesc" name="totaldesc" type="text" readonly style="border: none; width: 80px;"></td>
														</tr>
														<tr>
															<td style="width: 150px;">TOTAL NETO</td>
															<td style="text-align: left;"><input id="totalneto" name="totalneto" type="text" readonly style="border: none; width: 80px;"></td>
														</tr>
													@endif
												</table>
											</div>
										</div>
                                        <div class="col-xl-10 col-lg col-md-10 col-sm-10 col-10"></div>
                                        <div class="col-xl-2 col-lg col-md-2 col-sm-2 col-2" style="padding-top: 10px; text-align: right;">
                                            <button type="button" class="btn btn-primary" name="finishAccCom" onclick="submitFormAccCom()">Guardar</button>
                                        </div>
									</div>
								</div>
							</form>
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
