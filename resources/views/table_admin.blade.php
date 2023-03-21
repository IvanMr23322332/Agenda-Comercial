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
          <li class="breadcrumb-item">Importes</li>
          <li class="breadcrumb-item active">Tabla de Importes</li>
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
            <div class="card">
              <div class="card-body">

                <div class="dropdown" style="margin-bottom: 15px; text-align: center;">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        @if(!isset($mes_elegido))
                          <?php $mes_elegido = "Enero" ?>
                        @endif
                        {{$mes_elegido}}
                    </button>

                    <button class="btn btn-info" data-toggle="modal" data-target='#IntroducirDatos' tabindex="0" aria-controls="copy-print-csv" type="button"   style="margin-bottom: 10px; float:right">Introducir Datos</button>
                    <div class="modal fade" id="IntroducirDatos" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <form enctype="multipart/form-data" action="{{url('IntroducirDatos')}}" method="POST">
                                  @csrf
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="basicModalLabel">Introducir Datos</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">×</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <p style="color:red">Atención: El formato del fichero debe ser CSV, para más información haga click <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwjZ6ci08aH3AhWK4YUKHehHBbgQFnoECA4QAw&url=https%3A%2F%2Fsupport.microsoft.com%2Fes-es%2Foffice%2Fimportar-o-exportar-archivos-de-texto-txt-o-csv-5250ac4c-663c-47ce-937b-339e391393ba%23%3A~%3Atext%3DVaya%2520a%2520Archivo%2520%253E%2520Guardar%2520como%2CCSV%2520(delimitado%2520por%2520comas).&usg=AOvVaw1VlkICXSNnps42cX5VUhy5" style="color:blue;text-decoration: underline;" target="_blank"> aquí </a></p>
                                      <div class="form-group">
                                           <label for="message-text" class="col-form-label">Seleccione el fichero</label>
                                           <input type="file" id="fichero" name="fichero" class="form-control" required>
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
                        <a class="dropdown-item" href="table?mes=Octubre">Octubre</a>
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
                        <a class="dropdown-item" href="table?mes=Octubre&id={{$soporte_elegido}}">Octubre</a>
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
                        <th style="width: 30%">Canal</th>
                        <th style="width: 12%">{{$anyos[0]->anyo_nombre}}</th>
                        <th style="width: 12%">{{$anyos[1]->anyo_nombre}}</th>
                        <th style="width: 16%">{{$anyos[2]->anyo_nombre}}</th>
                        <th style="width: 12%">{{$anyos[3]->anyo_nombre}}</th>
                        <th>Diferencial</th>
                      </tr>
                    </thead>
                  </table>
                  <div class="accordion toggle-icons" id="toggleIcons">
                    @foreach ($canales as $canal)
                        <div class="accordion-container">
                          <div class="accordion-header" id="{{$canal[0]}}_head">
                            <table class="table_canal">
                              <tbody>
                                <tr style="font-size:19px">
                                  <td style="width:30.4%"><a href="" class="collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="toggleIconsCollapseOne" data-target="#{{$canal[0]}}" ><b>{{$canal[0]}}<b></a></td>
                                  <td style="width:12.3%">{{ number_format($canal[1], 2, ',', '.') }}</td>
                                  <td style="width:12.3%">{{ number_format($canal[2], 2, ',', '.') }}</td>
                                  <td style="width:16.3%">{{ number_format($canal[3], 2, ',', '.') }}</td>
                                  <td style="width:12.3%; color: blue;">{{ number_format($canal[4], 2, ',', '.') }}</td>
                                  <td>{{$canal[5]}}</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div id="{{$canal[0]}}" class="collapse" aria-labelledby="toggleIconsOne" data-parent="#toggleIcons" style="">
                            <div class="accordion toggle-icons" id="toggleIcons">
                                @foreach ($asesores_data as $asesor_data)
                                  @if($asesor_data[6] == $canal[0])
                  										<div class="accordion-body-agencia">
                                        <div class="accordion-container">
                                          <div class="accordion-header" id="{{$asesor_data[7]}}_head">

                                            <table class="table_canal">
                                              <tbody>
                                                <tr style="font-size:16px">
                                                  <td style="width:30.4%"><a href="" class="collapsed" data-toggle="collapse" aria-expanded="false" target="div{{$asesor_data[7]}}" onclick="accordion(this.target)" aria-controls="toggleIconsCollapseOne" data-target="{{$asesor_data[7]}}"><p>{{$asesor_data[0]}}</p></a></td>
                                                  <td style="width:12.3%">{{ number_format($asesor_data[1], 2, ',', '.') }}</td>
                                                  <td style="width:12.3%">{{ number_format($asesor_data[2], 2, ',', '.') }}</td>
                                                  <td style="width:16.3%">{{ number_format($asesor_data[3], 2, ',', '.') }}</td>
                                                  <td style="width:12.3%; color: blue;">{{ number_format($asesor_data[4], 2, ',', '.') }}</td>
                                                  <td>{{$asesor_data[5]}}</td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <div id="div{{$asesor_data[7]}}" class="collapse-lvl2"  aria-labelledby="toggleIconsOne" data-parent="#toggleIcons" style="display:none">
                                            <div class="accordion-body">
                                              <table class="table">
                                                  @foreach ($importes_data as $key => $importe)
                                                      @if ($key == $asesor_data[0])
                                                          @foreach ($importe as $row)
                                                              <tr style="font-size:14px">
                                                                <td style="width:29.4%"><a href="{{url("ver_cliente/".$row[0])}}">{{$row[0]}}</a></td>
                                                                <td style="width:12.4%">{{ number_format(floatval($row[1]), 2, ',', '.') }}</td>
                                                                <td style="width:12.4%">{{ number_format(floatval($row[2]), 2, ',', '.') }}</td>
                                                                <td style="width:16.4%">{{ number_format(floatval($row[3]), 2, ',', '.') }}</td>
                                                                <td style="width:12.4%; color: blue;">{{ number_format(floatval($row[4]), 2, ',', '.') }}</td>
                                                                <td>{{ number_format(floatval($row[5]), 2, ',', '.') }}</td>
                                                              </tr>
                                                          @endforeach
                                                      @endif
                                                  @endforeach
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                  										</div>
                                    @endif
                                @endforeach
                            </div>
                          </div>
                        </div>
                    @endforeach
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

  <!-- Main Js Required -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  <script src="{{asset('assets/js/importes.js')}}"></script>

@endsection
