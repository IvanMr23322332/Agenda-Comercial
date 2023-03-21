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
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Leyenda</div>
                </div>
                <div class="card-body">
                  <ul class="custom-list2">
                    <li><span style="border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 2px; margin-right: 10px; background-color: #107a39;"></span>Sin Presupuesto</li><br>
                    <li><span style="border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 2px; margin-right: 10px; background-color: #103e7a;"></span>Con Presupuesto</li><br>
                  </ul>
                </div>
              </div>
            </div>


            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">

                @if ($_SESSION['status'] == 'admin')
                    <div style="overflow-y: scroll;">
                        <?php $i = 0; ?>

                        @foreach ($contador as $cont)
                            <h3>{{$cont->user_name}}</h3>
                            <div id="calendar{{$i}}" style="border: 1px solid #000;">

                                <button id="btnEvent" data-toggle="modal" data-target='#eventForm' tabindex="0" aria-controls="copy-print-csv" type="button" style="display: none;"></button>
                                <div class="modal fade" id="eventForm" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <form action="{{url('formulario_evento')}}" method="POST">
                                              <meta name="csrfToken" content="{{ csrf_token() }}">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="basicModalLabel">Cambiar evento</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">×</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <input type="number" name="id_presupuesto" id="id_presupuesto" style="display:none">
                                                      <input type="date" name="fecha_cambio" id="fecha_cambio" style="display:none">
                                                      <label for="visita_tipo" class="col-form-label">Tipo de la nueva visita:</label>
                                                      <select class="form-control" id="visita_tipo" name="visita_tipo" required>
                                                          <option value="">Seleccione un tipo de visita</option>
                                                          <option value="Llamada">Llamada</option>
                                                          <option value="Reunion">Reunión</option>
                                                          <option value="Email">Email</option>
                                                      </select>
                                                      <label for="motivo" class="col-form-label">Motivo del cambio:</label>
                                                      <br>
                                                      <select class="form-control" id="motivo" name="motivo" required>
                                                          <option value="">Seleccione un tipo de visita</option>
                                                          <option value="No contesta llamada">No contesta llamada</option>
                                                          <option value="No puede el dia propuesto">No puede el día propuesto</option>
                                                          <option value="Necesita mas tiempo">Necesita más tiempo</option>
                                                          <option value="Vacaciones">Vacaciones</option>
                                                          <option value="Sin motivo">Sin motivo</option>
                                                      </select>
                                                   </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button class="btn btn-secondary" data-dismiss="modal" onclick="devolver()">Cancelar</button>
                                                  <button class="btn btn-primary" onclick="enviar()">Aceptar</button>
                                              </div>
                                          </form>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <?php $i++ ?>
                        @endforeach

                    </div>
                @else
                    <div id="calendar" style="border: 1px solid #000;">

                        <button id="btnEvent" data-toggle="modal" data-target='#eventForm' tabindex="0" aria-controls="copy-print-csv" type="button" style="display: none;"></button>
                        <div class="modal fade" id="eventForm" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <form method="POST">
                                      <meta name="csrfToken" content="{{ csrf_token() }}">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="basicModalLabel">Cambiar evento</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">×</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                              <input type="number" name="id_presupuesto" id="id_presupuesto" style="display:none">
                                              <input type="date" name="fecha_cambio" id="fecha_cambio" style="display:none">
                                              <label for="visita_tipo" class="col-form-label">Tipo de la nueva visita:</label>
                                              <select class="form-control" id="visita_tipo" name="visita_tipo" required>
                                                  <option value="">Seleccione un tipo de visita</option>
                                                  <option value="Llamada">Llamada</option>
                                                  <option value="Reunion">Reunión</option>
                                                  <option value="Email">Email</option>
                                              </select>
                                              <label for="motivo" class="col-form-label">Motivo del cambio:</label>
                                              <br>
                                              <select class="form-control" id="motivo" name="motivo" required>
                                                  <option value="">Seleccione un tipo de visita</option>
                                                  <option value="No contesta llamada">No contesta llamada</option>
                                                  <option value="No puede el dia propuesto">No puede el día propuesto</option>
                                                  <option value="Necesita mas tiempo">Necesita más tiempo</option>
                                                  <option value="Vacaciones">Vacaciones</option>
                                                  <option value="Sin motivo">Sin motivo</option>
                                              </select>
                                              <center><label id="control" class="col-form-label" style="color:red; display:none">Error, se han de rellenar todos los campos</label></center>
                                           </div>
                                      </div>
                                      <div class="modal-footer">

                                          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="devolver()">Cancelar</button>
                                          <button type="button" class="btn btn-primary" onclick="enviar()">Aceptar</button>
                                      </div>
                                  </form>
                                </div>
                            </div>
                        </div>

                    </div>
                @endif

            </div>

            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Información</div>
                </div>
                <div class="card-body">
                  <ul class="custom-list2">
                      @foreach ($intereses as $interes)
                          <li>
                              <p>{{$interes->clientes->cli_anu}}</p>
                              <p>Finaliza el: {{$interes->pre_datefin}}</p>
                              <a class="makeshift_link" href="{{url('presupuesto_ficha/'.$interes->pre_id)}}">Ver Presupuesto</a>
                              <br>
                          </li>
                      @endforeach
                  </ul>
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
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
@section('script')

  <!-- *************
    ************ Required JavaScript Files *************
  ************* -->
  <!-- Required jQuery first, then Bootstrap Bundle JS -->

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
    <script>

        {
            var calendar;
        }

        function enviar(){
            var fecha = $('#fecha_cambio').val();
            var id = $('#id_presupuesto').val();
            var motivo = $('#motivo').val();
            var tipo = $('#visita_tipo').val();

            if(motivo == "" || tipo == ""){
                $('#control').show();
                return false;
            }
            else{
                $('#control').hide();
            }
            //Comprobaciones de nulos
            $.ajax({
                url:'/cambiarEvento',
                method: 'POST',
                data:{
                        "_token": "{{ csrf_token() }}",
                        id_cambio : id,
                        fecha_cambio : fecha,
                        motivo_cambio : motivo,
                        tipo_cambio : tipo
                },
                success:function(response){
                    if(response = "Success"){
                        $.jGrowl("Se ha actualizado el evento", { header: 'Actualización de datos', theme: 'success' }, );
                        $('#eventForm').modal('toggle');

                    }
                    else{
                        $.jGrowl("Error, inténtelo de nuevo más tarde", { header: 'Actualización de datos', theme: 'failure' });
                        $('#eventForm').modal('toggle');
                    }
                    location.reload();
                },

                error:function(response){
                    $.jGrowl("Error, inténtelo de nuevo más tarde", { header: 'Actualización de datos', theme: 'failure' });
                    $('#eventForm').modal('toggle');

                }
            });
        }

        function procesar(event){
            $('#id_presupuesto').val(event.id);
            $('#fecha_cambio').val(event.start.toISOString());
            $('#btnEvent').click();
        }

        function devolver(){
            location.reload();
        }

        $(document).ready(function() {
            var eventos = @json($array_eventos);
            if($('#isadmin').val() != 0){
                for (var i = 0; i < @json($contador).length; i++) {
                    $('#calendar'+i).fullCalendar({
                        locale: 'es',
                        header:{
                            right: 'month, agendaWeek, agendaDay, listMonth',
                            center: 'title',
                            left: 'prev, next, today',
                        },
                        buttonText: {
                           //Here I make the button show French date instead of a text.
                           today: 'Hoy',
                           month: 'Mes',
                           week: 'Semana',
                           day:    'Día',
                           listMonth: "Eventos"

                        },
                        editable: false,
                        eventDrop: function(event) {
                            procesar(event);
                        },
                        weekends: true,
                        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
                        dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
                        dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
                        events: eventos[i]
                    });
                }
            } else {

                calendar = $('#calendar').fullCalendar({
                    locale: 'es',
                    header:{
                        right: 'month, agendaWeek, agendaDay, listMonth',
                        center: 'title',
                        left: 'prev, next, today',
                    },
                    firstDay: 1,
                    buttonText: {
                       today: 'Hoy',
                       month: 'Mes',
                       week: 'Semana',
                       day:    'Día',
                       listMonth: "Eventos"

                    },
                    editable: true,
                    eventDrop: function(event) {
                        procesar(event);
                    },
                    weekends: true,
                    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
                    dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
                    dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
                    events: eventos
                });
            }
        });

    </script>

  <!-- Main Js Required -->
  <script src="{{asset('assets/js/main.js')}}"></script>

@endsection
