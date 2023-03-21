



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
          <li class="breadcrumb-item">Clientes</li>
          <li class="breadcrumb-item active">Solicitud de Baja</li>
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
                        <center>
                            <h3>Fichero descargado con éxito</h3>
                            <br><br><br><br>
                            <h4><u><a href="{{url('buzon_presupuesto')}}" style="color:blue;">Pulsa aquí para volver</a></u></h4>
                        </center>
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

<?php
    use App\Models\PDF;
    // iconv('utf-8', 'cp1252', $txt)
    $pdf = new PDF();

    $pdf->SetFont('Arial','',14);
    $pdf->AddPage('L');
    $pdf->Cabecera();

    $pdf -> TablaRazonSocial  (   $datos  ['razon_social']            );
    $pdf -> TablaCliente      (   $datos  ['cliente']                 );
    $pdf -> TablaCampanya     (   $datos  ['detalles_campanya']       );
    $pdf -> TablaObservaciones(   $datos  ['observaciones_cliente']   );
    $pdf -> CabeceraResumen   ();

    for ($i=0; $i < 7 ; $i++) {
        if(isset($datos['lineas'][$i])){
            $pdf -> ContenidoResumen($datos['lineas'][$i]);
        }
        else{
            $pdf -> ContenidoResumen(null);
        }
    }

    $pdf -> ObservacionesGenerales ($datos  ['observaciones_cliente']['otra_informacion']);

    $pdf->tablaPago( "",
                     ""
    );
    $pdf->vtos( "",
                ""
    );
    $pdf->vtos( "",
                ""
    );
    $pdf->vtos( "",
                ""
    );
    $pdf->numAccount( "ES3820383207196000404755");

    switch (date('m')) {
        case 1:
            $mes = 'Enero';
            break;
        case 2:
            $mes = 'Febrero';
            break;
        case 3:
            $mes = 'Marzo';
            break;
        case 4:
            $mes = 'Abril';
            break;
        case 5:
            $mes = 'Mayo';
            break;
        case 6:
            $mes = 'Junio';
            break;
        case 7:
            $mes = 'Julio';
            break;
        case 8:
            $mes = 'Agosto';
            break;
        case 9:
            $mes = 'Septiembre';
            break;
        case 10:
            $mes = 'Octubre';
            break;
        case 11:
            $mes = 'Noviembre';
            break;
        case 12:
            $mes = 'Diciembre';
            break;
    }

    $pdf->fechaPie( "Elche",
                    date('d'),
                    $mes,
                    date('Y')
    ); //Fecha de hoy o de la creacion?
    $pdf -> precioFin($precios);
    $pdf -> campoFirmas();
    $procesados = array();
    //Bucle para los opticos
    if($isvalid == 1){
        foreach ($datos['lineas'] as $linea) {
            if(!in_array($linea['programa'], $procesados)){

                $pdf -> AddPage('L');
                $pdf -> CabeceraOPT();
                $pdf -> TablaInfoOPT("1","2","3","4","5");
                $pdf -> CabeceraPrincipalOPT();

                foreach($linea['opticos'] as $filaopt){
                    if($filaopt['is_data']){
                        $pdf -> FilaDatos($filaopt);
                    }
                    else{
                        $pdf -> FilaInfo($filaopt);
                    }
                }
                array_push($procesados, $linea['programa']);

            }
        }
    }

    $pdf->Output('D');


?>
