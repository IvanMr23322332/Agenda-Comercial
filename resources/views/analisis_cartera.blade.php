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
          <li class="breadcrumb-item">Cartera</li>
          <li class="breadcrumb-item active">Agenda</li>
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

            @if ($_SESSION['status'] == 'admin')
                <input type="number" style="display: none;" id="isadmin" value="1">
            @else
                <input type="number" style="display: none;" id="isadmin" value="0">
            @endif

            @if (isset($pasados))
                @if ($pasados > 0)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center; color:red">
                        @if ($pasados == 1)
                            <h5>Tienes {{$pasados}} evento pasado sin actualizar</h4>
                        @else
                            <h5>Tienes {{$pasados}} eventos pasados sin actualizar</h4>
                        @endif
                        <br>
                    </div>
                @endif
            @endif

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
                      <a href="/clientes_tabla">Tabla de Clientes</a>
                    </li>
                    <li>
                      <a href="/potenciales_tabla">Tabla de Potenciales</a>
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
        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Análisis de cartera</div>
            </div>
            <div class="card-body">
                <div class="row gutters">
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12"></div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div id="donutContainer1" style="height: 200px;"></div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12"></div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <form  action="index.html" method="post">
                            <table>
                                <tr style="height: 50px;"></tr>
                                <tr >
                                    <td>Fecha Inicial:</td>
                                    <td ><input type="date" id="inicio" required onchange="Creardonut()"></input></td>
                                </tr>
                                <tr style="height: 20px;"></tr>
                                <tr >
                                    <td>Fecha Final:</td>
                                    <td ><input type="date" id="fin" required onchange="Creardonut()"></input></td>
                                </tr>
                            </table>
                        </form>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12" >
                        <div id="donutContainer2" style="height: 200px;">
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="card">
              <div class="card-header">
                <div class="card-title">Reiteración, dilación y no contratación</div>
              </div>
              <div class="card-body">
                  <div class="row gutters">
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding:20px; text-align:center;"><h5>Reiteración</h5></div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div id="barContainer1"></div>
                      </div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding:20px; text-align:center;"><h5>Dilación</h5></div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div id="barContainer2"></div>
                      </div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding:20px; text-align:center;"><h5>No Contratación</h5></div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div id="barContainer3"></div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="card">
              <div class="card-header">
                <div class="card-title">Estadísticas de los clientes</div>
              </div>
              <div class="card-body">
                  <div class="row gutters">
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding:20px; text-align:center;"><h5>Agenda</h5></div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div id="GraficaHorizontal1"></div>
                      </div>
                      <br><br><br>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding:20px; text-align:center;"><h5>Potenciales con fecha de contacto</h5></div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div id="GraficaHorizontal2"></div>
                      </div>
                      <br><br><br>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding:20px; text-align:center;"><h5>Clientes con fecha de contacto</h5></div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div id="GraficaHorizontal3"></div>
                      </div>
                  </div>
              </div>
          </div>


        </div>
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

  <!-- Chartist JS -->
  {{-- <script src="{{asset('assets/vendor/chartist/js/chartist.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chartist/js/chartist-tooltip.js')}}"></script> --}}
  {{-- <script src="{{asset('assets/vendor/chartist/js/custom/threshold/threshold.js')}}"></script>
  <script src="{{asset('assets/vendor/chartist/js/custom/bar/bar-chart-orders.js')}}"></script> --}}

  <!-- jVector Maps -->
  <script src="{{asset('assets/vendor/jvectormap/jquery-jvectormap-2.0.3.min.js')}}"></script>
  <script src="{{asset('assets/vendor/jvectormap/world-mill-en.js')}}"></script>
  <script src="{{asset('assets/vendor/jvectormap/gdp-data.js')}}"></script>
  <script src="{{asset('assets/vendor/jvectormap/custom/world-map-markers2.js')}}"></script>

  <!-- Rating JS -->
  <script src="{{asset('assets/vendor/rating/raty.js')}}"></script>
  <script src="{{asset('assets/vendor/rating/raty-custom.js')}}"></script>

{{-- 13/05/2022 https://www.npmjs.com/package/jgrowl --}}
    <link rel="stylesheet" href="{{asset('assets/css/fullcalendar.css')}}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jgrowl.css')}}" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js"></script>

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

  <script type="text/javascript">

      window.onload = function () {

          Morris.Donut({
          	element: 'donutContainer1',
            data: @json($donut1),
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
            data: [
                {label: "Sin Datos", value: 100},
            ],
          	backgroundColor: '#ffffff',
          	labelColor: '#666666',
          	colors:['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
          	resize: true,
          	hideHover: "auto",
          	gridLineColor: "#e4e6f2",
          	formatter: function (x) { return x + "%"}
          });

        var barOptions1 = {
          series: [{
          name: 'Presupuestos rechazados consecutivamente',
          data: @json($tabla1)
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: ['Resto', '2 veces', '3 veces', '4 veces', '5 veces', '6 veces', '7 veces', '8 veces', '9 veces', '10 veces', '11 veces', '12 veces'],
        }
        };

        var chart1 = new ApexCharts(document.querySelector("#barContainer1"), barOptions1);
        chart1.render();

        var barOptions2 = {
          series: [{
          name: 'Tiempo sin registro',
          data: @json($tabla2)
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: ['Resto', '2 meses', '3 meses', '4 meses', '5 meses', '6 meses', '7 meses', '8 meses', '9 meses', '10 meses', '11 meses', '12 meses'],
        }
        };

        var chart2 = new ApexCharts(document.querySelector("#barContainer2"), barOptions2);
        chart2.render();

        var barOptions3 = {
          series: [{
          name: 'Tiempo sin contrato',
          data: @json($tabla3)
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: ['Resto', '12 meses', '11 meses', '10 meses', '9 meses', '8 meses', '7 meses', '6 meses', '5 meses', '4 meses', '3 meses', '2 meses'],
        }
        };

        var chart3 = new ApexCharts(document.querySelector("#barContainer3"), barOptions3);
        chart3.render();

        var options1 = {
          chart: {
            height: 380,
            type: "bar",
            toolbar: {
              show: true,
            },
          },
          plotOptions: {
            bar: {
              columnWidth: '55%',
              endingShape: 'rounded'
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: 1
          },
          series: [{
            name: 'Clientes',
            data: @json($array_agenda)
          }],
          grid: {
            row: {
              colors: ['#f5f9fe', '#ffffff']
            }
          },
          xaxis: {
            labels: {
              rotate: -45
            },
            tickAmount: 'dataPoints',
            range: 25,
            categories: ['-12 Meses', '-11 Meses', '-10 Meses', '-9 Meses', '-8 Meses', '-7 Meses','-6 Meses', '-5 Meses', '-4 Meses', '-3 Meses', '-2 Meses', '-1 Meses', '30-0', '1 Meses','2 Meses', '3 Meses', '4 Meses', '5 Meses', '6 Meses', '7 Meses','8 Meses', '9 Meses', '10 Meses', '11 Meses', '12 Meses'],
          },
          yaxis: {
            labels: {
              show: false,
            },
            axisBorder: {
              show: false,
            },
          },
          theme: {
            monochrome: {
              enabled: true,
              color: '#1a8e5f',
              shadeIntensity: 0.1
            },
          },
          fill: {
            type: 'gradient',
            gradient: {
              shade: 'light',
              type: "horizontal",
              gradientToColors: ['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
              shadeIntensity: 0.25,
              inverseColors: true,
              opacityFrom: 0.75,
              opacityTo: 0.85,
              stops: [50, 100]
            },
          },
        }

        var Hchart1 = new ApexCharts(
          document.querySelector("#GraficaHorizontal1"),
          options1
        );

        Hchart1.render();


        var options2 = {
          chart: {
            height: 380,
            type: "bar",
            toolbar: {
              show: true,
            },
          },
          plotOptions: {
            bar: {
              columnWidth: '55%',
              endingShape: 'rounded'
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: 1
          },
          series: [{
            name: 'Clientes',
            data: @json($array_potenciales)
          }],
          grid: {
            row: {
              colors: ['#f5f9fe', '#ffffff']
            }
          },
          xaxis: {
            labels: {
              rotate: -45
            },
            tickAmount: 'dataPoints',
            range: 25,
            categories: ['-12 Meses', '-11 Meses', '-10 Meses', '-9 Meses', '-8 Meses', '-7 Meses','-6 Meses', '-5 Meses', '-4 Meses', '-3 Meses', '-2 Meses', '-1 Meses', '30-0', '1 Meses','2 Meses', '3 Meses', '4 Meses', '5 Meses', '6 Meses', '7 Meses','8 Meses', '9 Meses', '10 Meses', '11 Meses', '12 Meses'],
          },
          yaxis: {
            labels: {
              show: false,
            },
            axisBorder: {
              show: false,
            },
          },
          theme: {
            monochrome: {
              enabled: true,
              color: '#1a8e5f',
              shadeIntensity: 0.1
            },
          },
          fill: {
            type: 'gradient',
            gradient: {
              shade: 'light',
              type: "horizontal",
              gradientToColors: ['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
              shadeIntensity: 0.25,
              inverseColors: true,
              opacityFrom: 0.75,
              opacityTo: 0.85,
              stops: [50, 100]
            },
          },
        }

        var Hchart2 = new ApexCharts(
          document.querySelector("#GraficaHorizontal2"),
          options2
        );

        Hchart2.render();


        var options3 = {
          chart: {
            height: 380,
            type: "bar",
            toolbar: {
              show: true,
            },
          },
          plotOptions: {
            bar: {
              columnWidth: '55%',
              endingShape: 'rounded'
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: 1
          },
          series: [{
            name: 'Clientes',
            data: @json($array_clientes)
          }],
          grid: {
            row: {
              colors: ['#f5f9fe', '#ffffff']
            }
          },
          xaxis: {
            labels: {
              rotate: -45
            },
            tickAmount: 'dataPoints',
            range: 25,
            categories: ['-12 Meses', '-11 Meses', '-10 Meses', '-9 Meses', '-8 Meses', '-7 Meses','-6 Meses', '-5 Meses', '-4 Meses', '-3 Meses', '-2 Meses', '-1 Meses', '30-0', '1 Meses','2 Meses', '3 Meses', '4 Meses', '5 Meses', '6 Meses', '7 Meses','8 Meses', '9 Meses', '10 Meses', '11 Meses', '12 Meses'],
          },
          yaxis: {
            labels: {
              show: false,
            },
            axisBorder: {
              show: false,
            },
          },
          theme: {
            monochrome: {
              enabled: true,
              color: '#1a8e5f',
              shadeIntensity: 0.1
            },
          },
          fill: {
            type: 'gradient',
            gradient: {
              shade: 'light',
              type: "horizontal",
              gradientToColors: ['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
              shadeIntensity: 0.25,
              inverseColors: true,
              opacityFrom: 0.75,
              opacityTo: 0.85,
              stops: [50, 100]
            },
          },
        }

        var Hchart3 = new ApexCharts(
          document.querySelector("#GraficaHorizontal3"),
          options3
        );

        Hchart3.render();
      }

      function Creardonut(){

          var inicio = $('#inicio').val();
          var fin = $('#fin').val();

          $.ajax({
              url:'/DatosDonut',
              method: 'POST',
              data:{
                      "_token": "{{ csrf_token() }}",
                      fecha_inicio : inicio,
                      fecha_fin : fin
              },
              success:function(response){
                  if(response == "\"Error\""){
                      $.jGrowl("Fecha de inicio no puede ser postieror a fecha de fin", { header: 'Error en fechas', theme: 'failure' });
                      $("#donutContainer2").empty();
                      return;
                  }
                  var result = JSON.parse(response);
                  $("#donutContainer2").empty();
                  $("Errortxt").hide;
                  Morris.Donut({
                  	element: 'donutContainer2',
                    data: result,
                  	backgroundColor: '#ffffff',
                  	labelColor: '#666666',
                  	colors:['#1a8e5f', '#262b31', '#434950', '#63686f', '#868a90'],
                  	resize: true,
                  	hideHover: "auto",
                  	gridLineColor: "#e4e6f2",
                  	formatter: function (x) { return x }
                  });
              },
              error:function(response){

              }
          });
      }

  </script>

@endsection
