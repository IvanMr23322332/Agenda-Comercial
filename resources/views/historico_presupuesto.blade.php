@extends('layouts.app')

@section('section')

  <!-- Container fluid start -->
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
          <li class="breadcrumb-item active">Historico de Presupuestos</li>
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
                  <form action="{{url('filtrar_historico')}}" method="POST">
                      @csrf
                      <input type="hidden" name="primer_anyo" value="{{$anyo}}">
                      <div class="dropdown" style="margin-bottom: 15px; text-align: center;">
                          <div class="dropdown bootstrap-select form-control" style="width: 180px;">
                              <label for="mes">Mes</label>
                              <select class="form-control selectpicker" tabindex="-98" name="mes_filtro" id="mes">
                                  @if (isset($mes_elegido))
                                      <option value="0" >TODOS LOS MESES </option>
                                      @for ($i=1; $i <= count($meses); $i++)
                                          @if ($i == $mes_elegido)
                                              <option value="{{$i}}" selected>{{$meses[$i-1]}}</option>
                                          @else
                                              <option value="{{$i}}" >{{$meses[$i-1]}}</option>
                                          @endif
                                      @endfor
                                  @else
                                      <option value="0" >TODOS LOS MESES </option>
                                      @for ($i=1; $i <= count($meses); $i++)
                                          @if ($i == now()->month)
                                              <option value="{{$i}}" selected>{{$meses[$i-1]}}</option>
                                          @else
                                              <option value="{{$i}}" >{{$meses[$i-1]}}</option>
                                          @endif
                                      @endfor
                                  @endif
                              </select>
                          </div>
                          <div class="dropdown bootstrap-select form-control" style="width: 180px;">
                              <label for="anyo">Año</label>
                              <select class="form-control selectpicker" tabindex="-98" name="anyo_filtro" id="anyo">
                                  @if (isset($anyo_elegido))
                                      <option value="0">TODOS LOS AÑOS </option>
                                      @for ($i=$anyo; $i <= now()->year; $i++)
                                          @if ($i == $anyo_elegido)
                                              <option value="{{$i}}" selected>{{$i}}</option>
                                          @else
                                              <option value="{{$i}}">{{$i}}</option>
                                          @endif
                                      @endfor
                                  @else
                                      <option value="0">TODOS LOS AÑOS </option>
                                      @for ($i=$anyo; $i <= now()->year; $i++)
                                          @if ($i == now()->year)
                                              <option value="{{$i}}" selected>{{$i}}</option>
                                          @else
                                              <option value="{{$i}}">{{$i}}</option>
                                          @endif
                                      @endfor
                                  @endif
                              </select>
                          </div>
                          <div class="dropdown bootstrap-select form-control" style="width: 180px;">
                              <label for="orden">Ordenar Por:</label>
                              <select class="form-control selectpicker" tabindex="-98" name="orden_filtro" id="orden">
                                  @if (isset($orden_elegido))
                                      @if ($orden_elegido == 1)
                                          <option value="">SIN ORDEN  </option>
                                          <option value="1" selected>Aceptados </option>
                                          <option value="2">Rechazados</option>
                                      @else
                                          <option value="">SIN ORDEN  </option>
                                          <option value="1">Aceptados </option>
                                          <option value="2" selected>Rechazados</option>
                                      @endif
                                  @else
                                      <option value="">SIN ORDEN  </option>
                                      <option value="1">Aceptados </option>
                                      <option value="2">Rechazados</option>
                                  @endif
                              </select>
                          </div>
                          <br>
                          <br>
                          <input type="submit" class="btn btn-info" style="margin-top: 15px;" value="Aplicar Filtros">
                      </div>
                  </form>
                  <div class="historico">
                      <div class="table-responsive">
                          <h3>HISTORICO DE PRESUPUESTOS</h3>
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Número</th>
                                <th>Estado</th>
                                <th>Anunciante</th>
                                <th>Gestión</th>
                                <th>Acción Comercial</th>
                                <th>Motivo</th>
                                <th>Aceptado/Rechazado el:</th>
                                <th>Fecha Próxima Reunión</th>
                                <th>Tipo de Reunión</th>
                                <th style="width: 350px;">Opciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              @if (isset($orden_elegido))
                                  @if ($orden_elegido == 1)
                                      @foreach ($presupuestos as $pre)
                                          @if ($pre->pre_estado == 'ACEPTADO')
                                              <tr>
                                                  <td>#{{$pre->pre_id}}</td>
                                                  <td style="color: green;">{{$pre->pre_estado}}</td>
                                                  <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pre->pre_cliente)}}">{{$pre->clientes->cli_anu}}</a></td>
                                                  <td>{{$pre->asesores->ase_nombre}}</td>
                                                  <td>{{$pre->acc_com_name}}</td>
                                                  <td>{{$pre->pre_motivo_rechazo}}</td>
                                                  <td>{{$pre->updated_at->format('d-m-Y')}}</td>
                                                  <td>{{$pre->clientes->cli_dateprox}}</td>
                                                  <td>{{$pre->clientes->cli_tipo_reunion}}</td>
                                                  <td><a href="/presupuesto_ficha/{{$pre->pre_id}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" value="ver_presupuesto">Ver Presupuesto</button></a> <a href="/copiarPresupuesto/{{$pre->pre_id}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="copia_presupuesto">Nuevo Presupuesto</button></a></td>
                                              </tr>
                                          @endif
                                      @endforeach
                                      @foreach ($presupuestos as $pre)
                                          @if ($pre->pre_estado == 'RECHAZADO')
                                              <tr>
                                                  <td>#{{$pre->pre_id}}</td>
                                                  <td style="color: red;">{{$pre->pre_estado}}</td>
                                                  <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pre->pre_cliente)}}">{{$pre->clientes->cli_anu}}</a></td>
                                                  <td>{{$pre->asesores->ase_nombre}}</td>
                                                  <td>{{$pre->acc_com_name}}</td>
                                                  <td>{{$pre->pre_motivo_rechazo}}</td>
                                                  <td>{{$pre->updated_at->format('d-m-Y')}}</td>
                                                  <td>{{$pre->clientes->cli_dateprox}}</td>
                                                  <td>{{$pre->clientes->cli_tipo_reunion}}</td>
                                                  <td><a href="/presupuesto_ficha/{{$pre->pre_id}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" value="ver_presupuesto">Ver Presupuesto</button></a> <a href="/copiarPresupuesto/{{$pre->pre_id}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="copia_presupuesto">Nuevo Presupuesto</button></a></td>
                                              </tr>
                                          @endif
                                      @endforeach
                                  @elseif ($orden_elegido == 2)
                                      @foreach ($presupuestos as $pre)
                                          @if ($pre->pre_estado == 'RECHAZADO')
                                              <tr>
                                                  <td>#{{$pre->pre_id}}</td>
                                                  <td style="color: red;">{{$pre->pre_estado}}</td>
                                                  <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pre->pre_cliente)}}">{{$pre->clientes->cli_anu}}</a></td>
                                                  <td>{{$pre->asesores->ase_nombre}}</td>
                                                  <td>{{$pre->acc_com_name}}</td>
                                                  <td>{{$pre->pre_motivo_rechazo}}</td>
                                                  <td>{{$pre->updated_at->format('d-m-Y')}}</td>
                                                  <td>{{$pre->clientes->cli_dateprox}}</td>
                                                  <td>{{$pre->clientes->cli_tipo_reunion}}</td>
                                                  <td><a href="/presupuesto_ficha/{{$pre->pre_id}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" value="ver_presupuesto">Ver Presupuesto</button></a> <a href="/copiarPresupuesto/{{$pre->pre_id}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="copia_presupuesto">Nuevo Presupuesto</button></a></td>
                                              </tr>
                                          @endif
                                      @endforeach
                                      @foreach ($presupuestos as $pre)
                                          @if ($pre->pre_estado == 'ACEPTADO')
                                              <tr>
                                                  <td>#{{$pre->pre_id}}</td>
                                                  <td style="color: green;">{{$pre->pre_estado}}</td>
                                                  <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pre->pre_cliente)}}">{{$pre->clientes->cli_anu}}</a></td>
                                                  <td>{{$pre->asesores->ase_nombre}}</td>
                                                  <td>{{$pre->acc_com_name}}</td>
                                                  <td>{{$pre->pre_motivo_rechazo}}</td>
                                                  <td>{{$pre->updated_at->format('d-m-Y')}}</td>
                                                  <td>{{$pre->clientes->cli_dateprox}}</td>
                                                  <td>{{$pre->clientes->cli_tipo_reunion}}</td>
                                                  <td><a href="/presupuesto_ficha/{{$pre->pre_id}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" value="ver_presupuesto">Ver Presupuesto</button></a> <a href="/copiarPresupuesto/{{$pre->pre_id}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="copia_presupuesto">Nuevo Presupuesto</button></a></td>
                                              </tr>
                                          @endif
                                      @endforeach
                                  @endif
                              @else
                                  @foreach ($presupuestos as $pre)
                                      @if ($pre->pre_estado == 'ACEPTADO')
                                          <tr>
                                              <td>#{{$pre->pre_id}}</td>
                                              <td style="color: green;">{{$pre->pre_estado}}</td>
                                              <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pre->pre_cliente)}}">{{$pre->clientes->cli_anu}}</a></td>
                                              <td>{{$pre->asesores->ase_nombre}}</td>
                                              <td>{{$pre->acc_com_name}}</td>
                                              <td>{{$pre->pre_motivo_rechazo}}</td>
                                              <td>{{$pre->updated_at->format('d-m-Y')}}</td>
                                              <td>{{$pre->clientes->cli_dateprox}}</td>
                                              <td>{{$pre->clientes->cli_tipo_reunion}}</td>
                                              <td><a href="/presupuesto_ficha/{{$pre->pre_id}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" value="ver_presupuesto">Ver Presupuesto</button></a> <a href="/copiarPresupuesto/{{$pre->pre_id}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="copia_presupuesto">Nuevo Presupuesto</button></a></td>
                                          </tr>
                                      @else
                                          <tr>
                                              <td>#{{$pre->pre_id}}</td>
                                              <td style="color: red;">{{$pre->pre_estado}}</td>
                                              <td><a class="makeshift_link" href="{{url("clientes_ficha/".$pre->pre_cliente)}}">{{$pre->clientes->cli_anu}}</a></td>
                                              <td>{{$pre->asesores->ase_nombre}}</td>
                                              <td>{{$pre->acc_com_name}}</td>
                                              <td>{{$pre->pre_motivo_rechazo}}</td>
                                              <td>{{$pre->updated_at->format('d-m-Y')}}</td>
                                              <td>{{$pre->clientes->cli_dateprox}}</td>
                                              <td>{{$pre->clientes->cli_tipo_reunion}}</td>
                                              <td><a href="/presupuesto_ficha/{{$pre->pre_id}}"><button class="btn btn-primary" tabindex="0" aria-controls="copy-print-csv" type="button" value="ver_presupuesto">Ver Presupuesto</button></a> <a href="/copiarPresupuesto/{{$pre->pre_id}}"><button class="btn btn-info" tabindex="0" aria-controls="copy-print-csv" type="button" value="copia_presupuesto">Nuevo Presupuesto</button></a></td>
                                          </tr>
                                      @endif
                                  @endforeach
                              @endif
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

  <!-- Steps wizard JS -->
  <script src="{{asset('assets/vendor/wizard/jquery.steps.min.js')}}"></script>
  <script src="{{asset('assets/vendor/wizard/jquery.steps.custom.js')}}"></script>

  <!-- Bootstrap Select JS -->
  <script src="{{asset('assets/vendor/bs-select/bs-select.min.js')}}"></script>

  <!-- Main Js Required -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  <!-- <script src="{{asset('assets/js/importes.js')}}"></script> -->

@endsection
