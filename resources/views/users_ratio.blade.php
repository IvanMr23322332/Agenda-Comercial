@extends('layouts.app')

@section('section')

<!-- Container fluid start -->
<div class="container-fluid">
  <?php SESSION_START() ?>
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
      <li class="breadcrumb-item">Cartera</li>
      <li class="breadcrumb-item active">Ratios</li>
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
                  <div class="card-title">Cartera</div>
              </div>
              <div class="card-body">
                  <ul class="custom-list2">
                      <li>
                        <a href="/agenda">Agenda</a>
                      </li>
                      <li>
                        <a href="/clientes_tabla">Tabla de clientes</a>
                      </li>
                      <li>
                        <a href="/potenciales_tabla">Tabla de potenciales</a>
                      </li>
                      <li>
                        <a href="/users_info/{{$_SESSION['id_ase']}}">Análisis</a>
                      </li>
                      <li>
                        <a href="/users_ratio/{{$_SESSION['id_ase']}}">Ratios</a>
                      </li>
                      <li>
                        <a href="/analisis_cartera">Análisis de Cartera</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
        <div class="card"><div class="card-header">
          <div class="card-title">Ratios</div>
        </div>
            <div class="card-body">
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding:20px; text-align:center; background-color:#ebfcef;  border-radius: 15px 15px 0px 0px;"><h5>Datos de Presupuestos</h5></div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="background-color:#ebfcef; border-radius: 0 0 15px 15px;">
                        @if ($_SESSION['status'] == 'admin')
                            <div class="dropdown" style="margin-bottom: 15px;margin-left:15px;  text-align:left; " >
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    {{$usuario->user_name}}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                                    @foreach ($usuarios as $elem)
                                        <a class="dropdown-item" href="{{url('users_ratio/'.$elem->user_ase)}}">{{$elem->user_name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="row gutters">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                <div id="chartContainer1"></div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div id="donutContainer1"></div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div id="donutContainer2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="height:15px"></div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding:20px; text-align:center; background-color:#ebfcef;  border-radius: 15px 15px 0px 0px;"><h5>Datos de Presupuestos</h5></div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="background-color:#ebfcef; border-radius: 0 0 15px 15px;">
                        <div class="row gutters">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                <div id="chartContainer2"></div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div id="donutContainer3"></div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div id="donutContainer4"></div>
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

<!-- Apex Charts -->
<script src="{{asset('assets/vendor/apex/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/vendor/apex/examples/mixed/line-column-graph.js')}}"></script>
<script src="{{asset('assets/vendor/apex/examples/mixed/line-area-graph.js')}}"></script>
<script src="{{asset('assets/vendor/apex/examples/mixed/line-scatter-graph.js')}}"></script>
<script src="{{asset('assets/vendor/apex/examples/mixed/multiple-yaxis.js')}}"></script>

<!-- Morris Graphs -->
<script src="{{asset('assets/vendor/morris/raphael-min.js')}}"></script>
<script src="{{asset('assets/vendor/morris/morris.min.js')}}"></script>

<!-- Main Js Required -->
<script src="{{asset('assets/js/main.js')}}"></script>
<!-- <script src="{{asset('assets/js/importes.js')}}"></script> -->

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
window.onload = function () {

    var options = {
    	chart: {
    		height: 350,
    		type: 'line',
    		zoom: {
    			enabled: false
    		},
    	},
    	toolbar: {
    		show: false
    	},
    	series: [{
    		name: 'Visitas',
    		type: 'column',
    		data: @json($ratios1)
    	}, {
    		name: 'Llamadas, Emails y Reportes',
    		type: 'line',
    		data: @json($ratios2)
    	}],
    	stroke: {
    		width: [0, 4]
    	},
    	title: {
    		text: 'Resumen de gestiones',
    		align: 'center'
    	},
    	// labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    	labels: @json($meses),
    	xaxis: {
    		type: 'category'
    	},
    	colors: ['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
    	yaxis: [{
    		title: {
    			text: 'Nº de Eventos',
    		},
    	}]
    }
    var chart = new ApexCharts(
    	document.querySelector("#chartContainer1"),
    	options
    );
    chart.render();

    var options2 = {
    	chart: {
    		height: 350,
    		type: 'line',
    		zoom: {
    			enabled: false
    		},
    	},
    	toolbar: {
    		show: false
    	},
    	series: [{
    		name: 'Aceptados',
    		type: 'column',
    		data: @json($ratios3)
    	}, {
    		name: 'Enviados',
    		type: 'line',
    		data: @json($ratios4)
    	}],
    	stroke: {
    		width: [0, 4]
    	},
    	title: {
    		text: 'Resumen de presupuestos',
    		align: 'center'
    	},
        labels: @json($meses),
    	xaxis: {
    		type: 'category'
    	},
    	colors: ['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
    	yaxis: [{
    		title: {
    			text: 'Nº de Presupuestos',
    		},
    	}]
    }
    var chart2 = new ApexCharts(
    	document.querySelector("#chartContainer2"),
    	options2
    );
    chart2.render();

    Morris.Donut({
    	element: 'donutContainer1',
    	data: @json($esfuerzo_mes),
    	backgroundColor: '#ffffff',
    	labelColor: '#666666',
    	colors:['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
    	resize: true,
    	hideHover: "auto",
    	gridLineColor: "#e4e6f2",
    	formatter: function (x) { return x + "%"}
    });

    Morris.Donut({
    	element: 'donutContainer2',
    	data: @json($esfuerzo_semanal),
    	backgroundColor: '#ffffff',
    	labelColor: '#666666',
    	colors:['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
    	resize: true,
    	hideHover: "auto",
    	gridLineColor: "#e4e6f2",
    	formatter: function (x) { return x + "%"}
    });

    Morris.Donut({
    	element: 'donutContainer3',
    	data: @json($efectividad_mes),
    	backgroundColor: '#ffffff',
    	labelColor: '#666666',
    	colors:['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
    	resize: true,
    	hideHover: "auto",
    	gridLineColor: "#e4e6f2",
    	formatter: function (x) { return x + "%"}
    });

    Morris.Donut({
    	element: 'donutContainer4',
    	data: @json($efectividad_semanal),
    	backgroundColor: '#ffffff',
    	labelColor: '#666666',
    	colors:['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
    	resize: true,
    	hideHover: "auto",
    	gridLineColor: "#e4e6f2",
    	formatter: function (x) { return x + "%"}
    });
}

</script>

@endsection
