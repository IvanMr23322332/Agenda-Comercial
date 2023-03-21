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
          <li class="breadcrumb-item">Ventas</li>
          <li class="breadcrumb-item active">Reporte sobre Ventas</li>
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
                <div class="card-title">Ventas</div>
              </div>
              <div class="card-body">
                <ul class="custom-list2">
                  <li>
                    <a href="/table">Reporte sobre Ventas</a>
                  </li>
                  <li>
                    <a href="/ventas_presupuesto">Histórico de Ventas</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dropdown" style="margin-bottom: 15px; text-align: center;">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        @if(!isset($mes_elegido))
                          <?php $mes_elegido = "Enero" ?>
                        @endif
                        {{$mes_elegido}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 33px, 0px);">
                      @if(!isset($soporte_elegido))
                        <a class="dropdown-item" href="table?mes=Enero">Enero</a>
                        <a class="dropdown-item" href="table?mes=Febrero">Febrero</a>
                        <a class="dropdown-item" href="table?mes=Marzo">Marzo</a>
                        <a class="dropdown-item" href="table?mes=Abril">Abril</a>
                        <a class="dropdown-item" href="table?mes=Mayo">Mayo</a>
                        <a class="dropdown-item" href="table?mes=Junio">Junio</a>
                        <a class="dropdown-item" href="table?mes=Julio">Julio</a>
                        <a class="dropdown-item" href="table?mes=Agosto">Agosto</a>
                        <a class="dropdown-item" href="table?mes=Septiembre">Septiembre</a>
                        <a class="dropdown-item" href="table?mes=Octube">Octube</a>
                        <a class="dropdown-item" href="table?mes=Noviembre">Noviembre</a>
                        <a class="dropdown-item" href="table?mes=Diciembre">Diciembre</a>
                      @else
                        <a class="dropdown-item" href="table?mes=Enero&id={{$soporte_elegido}}">Enero</a>
                        <a class="dropdown-item" href="table?mes=Febrero&id={{$soporte_elegido}}">Febrero</a>
                        <a class="dropdown-item" href="table?mes=Marzo&id={{$soporte_elegido}}">Marzo</a>
                        <a class="dropdown-item" href="table?mes=Abril&id={{$soporte_elegido}}">Abril</a>
                        <a class="dropdown-item" href="table?mes=Mayo&id={{$soporte_elegido}}">Mayo</a>
                        <a class="dropdown-item" href="table?mes=Junio&id={{$soporte_elegido}}">Junio</a>
                        <a class="dropdown-item" href="table?mes=Julio&id={{$soporte_elegido}}">Julio</a>
                        <a class="dropdown-item" href="table?mes=Agosto&id={{$soporte_elegido}}">Agosto</a>
                        <a class="dropdown-item" href="table?mes=Septiembre&id={{$soporte_elegido}}">Septiembre</a>
                        <a class="dropdown-item" href="table?mes=Octube&id={{$soporte_elegido}}">Octube</a>
                        <a class="dropdown-item" href="table?mes=Noviembre&id={{$soporte_elegido}}">Noviembre</a>
                        <a class="dropdown-item" href="table?mes=Diciembre&id={{$soporte_elegido}}">Diciembre</a>
                      @endif
                    </div>
                  </div>
                <div class="table-responsive">
                  <div class="dt-buttons">
                    @if (!isset($soporte_elegido))
                      <a href="table?mes={{$mes_elegido}}"><button class="btn btn-primary active" tabindex="0" aria-controls="copy-print-csv" type="button" style="margin-bottom: 10px"><span>TOTALES</span></button></a>
                    @else
                      <a href="table?mes={{$mes_elegido}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" style="margin-bottom: 10px"><span>TOTALES</span></button></a>
                    @endif

                    @foreach ($soportes as $soporte)
                      @if (isset($soporte_elegido))
                        @if ($soporte_elegido == $soporte->sop_id)
                          <a href="table?id={{$soporte->sop_id}}&mes={{$mes_elegido}}"><button class="btn btn-primary active" tabindex="0" aria-controls="copy-print-csv" type="button" style="margin-bottom: 10px"><span>{{$soporte->imp_sop}}</span></button></a>
                        @else
                          <a href="table?id={{$soporte->sop_id}}&mes={{$mes_elegido}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" style="margin-bottom: 10px"><span>{{$soporte->imp_sop}}</span></button></a>
                        @endif
                      @else
                        <a href="table?id={{$soporte->sop_id}}&mes={{$mes_elegido}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" style="margin-bottom: 10px"><span>{{$soporte->imp_sop}}</span></button></a>
                      @endif
                    @endforeach
                  </div>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Anunciante</th>
                        <th style="width: 14%">{{$anyos[0]->anyo_nombre}}</th>
                        <th style="width: 14%">{{$anyos[1]->anyo_nombre}}</th>
                        <th style="width: 20%">{{$anyos[2]->anyo_nombre}}</th>
                        <th style="width: 14%">{{$anyos[3]->anyo_nombre}}</th>
                        <th>DIFERENCIAL</th>
                      </tr>
                    </thead>
                        <tbody>
                            @foreach($importes as $importe)
                                @if ($importe[0] == 'TOTAL')
                                    <tr style="font-size:14px">
                                    <td><b>{{$importe[0]}}</b></td>
                                    <td><b>{{number_format(floatval($importe[1]), 2, ',', '.')}}</b></td>
                                    <td><b>{{number_format(floatval($importe[2]), 2, ',', '.')}}</b></td>
                                    <td><b>{{number_format(floatval($importe[3]), 2, ',', '.')}}</b></td>
                                    @if (isset($importe[10]))
                                        <td style="color: blue;"><b>{{$importe[4]}}</b></td>
                                    @else
                                        <td style="color: blue;"><b>{{number_format(floatval($importe[4]), 2, ',', '.')}}</b></td>
                                    @endif
                                    <td><b>{{number_format(floatval($importe[5]), 2, ',', '.')}}</b></td>
                                    </tr>
                                @else
                                    <tr style="font-size:14px">
                                    <td><a href="{{url("ver_cliente/".$importe[0])}}">{{$importe[0]}}</a></td>
                                    <td>{{number_format(floatval($importe[1]), 2, ',', '.')}}</td>
                                    <td>{{number_format(floatval($importe[2]), 2, ',', '.')}}</td>
                                    <td>{{number_format(floatval($importe[3]), 2, ',', '.')}}</td>
                                    @if (isset($importe[10]))
                                        <td style="color: blue;">{{$importe[4]}}</td>
                                    @else
                                        <td style="color: blue;">{{number_format(floatval($importe[4]), 2, ',', '.')}}</td>
                                    @endif
                                    <td>{{number_format(floatval($importe[5]), 2, ',', '.')}}</td>
                                    </tr>
                                @endif
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

  <!-- Main Js Required -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  <!-- <script src="{{asset('assets/js/importes.js')}}"></script> -->

@endsection
