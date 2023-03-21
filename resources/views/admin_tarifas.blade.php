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
						<li class="breadcrumb-item">Administrador</li>
						<li class="breadcrumb-item active">Administrar Tarifas</li>
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
                            <div class="nav-tabs-container">
								<h3 style="padding-top: 20px; padding-left: 16px;">Tarifas</h3>
								<ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach ($sop_pre as $sop_presupuesto)
                                        @if ($sop_presupuesto->sop_pre_id == 1)
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab{{$sop_presupuesto->sop_pre_id}}" data-toggle="tab" href="#home{{$sop_presupuesto->sop_pre_id}}" role="tab" aria-controls="home{{$sop_presupuesto->sop_pre_id}}" aria-selected="true">{{$sop_presupuesto->sop_pre_nombre}}</a>
                                            </li>
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link" id="home-tab{{$sop_presupuesto->sop_pre_id}}" data-toggle="tab" href="#home{{$sop_presupuesto->sop_pre_id}}" role="tab" aria-controls="home{{$sop_presupuesto->sop_pre_id}}" aria-selected="false">{{$sop_presupuesto->sop_pre_nombre}}</a>
                                            </li>
                                        @endif
                                    @endforeach
								</ul>
								<div class="tab-content" id="myTabContent">
                                    @foreach ($sop_pre as $sop_presupuesto)
                                        @if ($sop_presupuesto->sop_pre_id == 1)
                                            <div class="tab-pane fade active show" id="home{{$sop_presupuesto->sop_pre_id}}" role="tabpanel" aria-labelledby="home-tab{{$sop_presupuesto->sop_pre_id}}">
												<form action="editar_tarifas" method="post">
													@csrf
													<div class="table-responsive">
														<table class="table table-bordered">
															<thead id="header{{$sop_presupuesto->sop_pre_id}}" onload="cargarDuracion({{$sop_presupuesto->sop_pre_id}})">
																<th style="width: 40%"></th>
																@foreach ($sop_dur as $sop_duraciones)
																	@if ($sop_duraciones->sop_pre_id == $sop_presupuesto->sop_pre_id)
																		@foreach ($des_pre as $des_presupuesto)
						                                                    @if ($sop_presupuesto->sop_pre_id == $des_presupuesto->des_pre_soporte && $sop_duraciones->dur_pre_id == $des_presupuesto->des_pre_duracion)
																				<th>{{$sop_duraciones->dur_pre_nombre}}<input class="editarTarifa{{$sop_presupuesto->sop_pre_id}}" id="desc{{$sop_duraciones->sop_pre_id}}_{{$sop_duraciones->dur_pre_id}}" name="desc{{$sop_duraciones->sop_pre_id}}_{{$sop_duraciones->dur_pre_id}}" onchange="calcularTotalDTO({{$sop_duraciones->sop_pre_id}},{{$sop_duraciones->dur_pre_id}})" type="number" min="0" max="100" style="text-align: right; width: 40px; margin-left: 30%;" value="{{$des_presupuesto->des_pre_value}}" readonly><span>%</span></th>
																			@endif
																		@endforeach
																	@endif
																@endforeach
															</thead>
															<tbody>
																<tr>
																@foreach ($tar_pre as $tar_presupuesto)
				                                                    @if ($sop_presupuesto->sop_pre_id == $tar_presupuesto->tar_pre_soporte)
																		<tr>
																			<td>{{$tar_presupuesto->tar_pre_nombre}}</td>
																			@foreach ($sop_dur as $sop_duraciones)
																				@if ($sop_duraciones->sop_pre_id == $sop_presupuesto->sop_pre_id)
																					@foreach ($pre_pre as $pre_presupuesto)
																						@if ($pre_presupuesto->pre_pre_tarifa == $tar_presupuesto->tar_pre_id && $pre_presupuesto->pre_pre_duracion == $sop_duraciones->dur_pre_id)
																							@if($pre_presupuesto->pre_pre_value == -1)
																								<td></td>
																							@else
																								<td>
																									<input class="editarTarifa{{$sop_presupuesto->sop_pre_id}}" id="prec{{$pre_presupuesto->pre_pre_tarifa}}_{{$pre_presupuesto->pre_pre_duracion}}_{{$sop_presupuesto->sop_pre_id}}" name="prec{{$pre_presupuesto->pre_pre_tarifa}}_{{$pre_presupuesto->pre_pre_duracion}}_{{$sop_presupuesto->sop_pre_id}}" onchange="calcularTotalTAR({{$pre_presupuesto->pre_pre_tarifa}},{{$pre_presupuesto->pre_pre_duracion}},{{$sop_presupuesto->sop_pre_id}})" type="number" step="0.01" style="width: 60px;" value="{{$pre_presupuesto->pre_pre_value}}" readonly>
																									<input class="totalClass{{$sop_duraciones->sop_pre_id}}{{$sop_duraciones->dur_pre_id}}" data-tar="{{$pre_presupuesto->pre_pre_tarifa}}" id="total{{$pre_presupuesto->pre_pre_tarifa}}{{$pre_presupuesto->pre_pre_duracion}}" name="total{{$pre_presupuesto->pre_pre_tarifa}}{{$pre_presupuesto->pre_pre_duracion}}" style="width: 60px; margin-left: 60px; border: none; text-align: right;" readonly>
																								</td>
																							@endif
																						@endif
																					@endforeach
																				@endif
																			@endforeach
																		</tr>
				                                                    @endif
				                                                @endforeach
																</tr>
															</tbody>
														</table>
													</div>
													<input type="hidden" name="sop_id" value="{{$sop_presupuesto->sop_pre_id}}">
													<button type="button" id="editar{{$sop_presupuesto->sop_pre_id}}" class="btn btn-info" style="left: 95%; position: relative;" onclick="editarAdmin({{$sop_presupuesto->sop_pre_id}})">Editar</button>
													<div class="editarTarifa{{$sop_presupuesto->sop_pre_id}}" style="float: right; display: none;">
														<button type="button" id="cancelar{{$sop_presupuesto->sop_pre_id}}" class="btn btn-secondary" style="margin-bottom: 10px;" onclick="cancelarAdmin({{$sop_presupuesto->sop_pre_id}})">Cancelar</button>
														<button type="submit" id="guardar{{$sop_presupuesto->sop_pre_id}}" class="btn btn-primary" style="margin-bottom: 10px;">Guardar</button>
													</div>
												</form>
        									</div>
                                        @else
                                            <div class="tab-pane fade" id="home{{$sop_presupuesto->sop_pre_id}}" role="tabpanel" aria-labelledby="home-tab{{$sop_presupuesto->sop_pre_id}}">
												<form action="editar_tarifas" method="post">
													@csrf
													<input type="hidden" name="sop_id" value="{{$sop_presupuesto->sop_pre_id}}">
												<div class="table-responsive">
													<table class="table table-bordered">
														<thead id="header{{$sop_presupuesto->sop_pre_id}}" onload="cargarDuracion({{$sop_presupuesto->sop_pre_id}})">
															<th style="width: 40%"></th>
															@foreach ($sop_dur as $sop_duraciones)
																@if ($sop_duraciones->sop_pre_id == $sop_presupuesto->sop_pre_id)
																	@foreach ($des_pre as $des_presupuesto)
					                                                    @if ($sop_presupuesto->sop_pre_id == $des_presupuesto->des_pre_soporte && $sop_duraciones->dur_pre_id == $des_presupuesto->des_pre_duracion)
																			<th>{{$sop_duraciones->dur_pre_nombre}}<input class="editarTarifa{{$sop_presupuesto->sop_pre_id}}" id="desc{{$sop_duraciones->sop_pre_id}}_{{$sop_duraciones->dur_pre_id}}" onchange="calcularTotalDTO({{$sop_duraciones->sop_pre_id}},{{$sop_duraciones->dur_pre_id}})" type="number" min="0" max="100" style="text-align: right; width: 40px; margin-left: 30%;" value="{{$des_presupuesto->des_pre_value}}" readonly><span>%</span></th>
																		@endif
																	@endforeach
																@endif
															@endforeach
														</thead>
														<tbody>
															<tr>
															@foreach ($tar_pre as $tar_presupuesto)

			                                                    @if ($sop_presupuesto->sop_pre_id == $tar_presupuesto->tar_pre_soporte)
																	<tr>
																		<td>{{$tar_presupuesto->tar_pre_nombre}}</td>
																		@foreach ($sop_dur as $sop_duraciones)
																			@if ($sop_duraciones->sop_pre_id == $sop_presupuesto->sop_pre_id)
																				@foreach ($pre_pre as $pre_presupuesto)
																					@if ($pre_presupuesto->pre_pre_tarifa == $tar_presupuesto->tar_pre_id && $pre_presupuesto->pre_pre_duracion == $sop_duraciones->dur_pre_id)
																						@if($pre_presupuesto->pre_pre_value == -1)
																							<td></td>
																						@else
																							<td>
																								<input class="editarTarifa{{$sop_presupuesto->sop_pre_id}}" id="prec{{$pre_presupuesto->pre_pre_tarifa}}_{{$pre_presupuesto->pre_pre_duracion}}_{{$sop_presupuesto->sop_pre_id}}" name="prec{{$pre_presupuesto->pre_pre_tarifa}}_{{$pre_presupuesto->pre_pre_duracion}}_{{$sop_presupuesto->sop_pre_id}}" onchange="calcularTotalTAR({{$pre_presupuesto->pre_pre_tarifa}},{{$pre_presupuesto->pre_pre_duracion}},{{$sop_presupuesto->sop_pre_id}})" type="number" style="width: 60px;" value="{{$pre_presupuesto->pre_pre_value}}" readonly>
																								<input class="totalClass{{$sop_duraciones->sop_pre_id}}{{$sop_duraciones->dur_pre_id}}" data-tar="{{$pre_presupuesto->pre_pre_tarifa}}" id="total{{$pre_presupuesto->pre_pre_tarifa}}{{$pre_presupuesto->pre_pre_duracion}}" name="total{{$pre_presupuesto->pre_pre_tarifa}}{{$pre_presupuesto->pre_pre_duracion}}" style="width: 60px; margin-left: 60px; border: none; text-align: right;" readonly>
																							</td>
																						@endif
																					@endif
																				@endforeach
																			@endif
																		@endforeach
																	</tr>
			                                                    @endif

			                                                @endforeach
															</tr>
														</tbody>
													</table>
												</div>
												<button type="button" id="editar{{$sop_presupuesto->sop_pre_id}}" class="btn btn-info" style="left: 95%; position: relative;" onclick="editarAdmin({{$sop_presupuesto->sop_pre_id}})">Editar</button>
												<div class="editarTarifa{{$sop_presupuesto->sop_pre_id}}" style="float: right; display: none;">
													<button type="button" id="cancelar{{$sop_presupuesto->sop_pre_id}}" class="btn btn-secondary" style="margin-bottom: 10px;" onclick="cancelarAdmin({{$sop_presupuesto->sop_pre_id}})">Cancelar</button>
													<input type="submit" id="guardar{{$sop_presupuesto->sop_pre_id}}" class="btn btn-primary" style="margin-bottom: 10px;" value="Guardar">
												</div>
												</form>
        									</div>

                                        @endif
                                    @endforeach
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

		<script src="{{asset('assets/js/admin_tarifas.js')}}"></script>

@endsection
