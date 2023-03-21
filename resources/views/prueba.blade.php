<?php
// iconv('utf-8', 'cp1252', $txt)
use App\Models\PDF;
use App\Models\presupuestos;

$pdf = new PDF();

$pdf->SetFont('Arial','',14);
$pdf->AddPage('L');
$pdf->Cabecera();



$pdf->TablaRazonSocial( "INICIATIVAS DE PUBLICIDAD GENERAL",
                        "B-03486081",
                        "CADENA SER",
                        "DOCTOR CARO, 43",
                        "03201",
                        "ELCHE (Alicante)"
);



$pdf->TablaCliente( "GO KARTS KARTING CIUDAD QUESADA S.L.",
                        "GOKART CIUDAD QUESADA",
                        "B-54836473",
                        "Carretera Cv-905, Km 2'8",
                        "03201",
                        "ELCHE",
                        "Alicante",
                        "619971223"
);

//TODO Query para tabla campaña

$pdf->TablaCampanya( "CADENA SER",
                        "01/01/2022",
                        "31/01/2022",
                        "20\" sg",
                        "Domingo Candela, Asesor Publicidad. Movil 600 994 927"
);





$pdf->CabeceraResumen();
$pdf->ContenidoResumen( "Los 40 Elche - ANDA YA",
                        "20\" sg",
                        100,
                        51.00,
                        5100.00,
                        70,
                        15.30,
                        1530.00
);

$pdf->tablaPago( "Todo en Noviembre",
                 "3 Recibos banco"
);
$pdf->vtos( "30 Diciembre",
            1001.1
);
$pdf->vtos( "30 Diciembre",
            1001.1
);
$pdf->vtos( "30 Diciembre",
            1001.1
);
$pdf->numAccount( "ES3820383207196000404755");
$pdf->fechaPie( "Elche",
                13,
                "Enero",
                2022
);

$pdf->precioFin( 9999,
                 2730,
                 0,
                 2730,
                 21,
                 3303.3,
                 81.68
);
$pdf->campoFirmas();

// $pdf->BasicTable($header,$data);
// $pdf->AddPage('L');
// $pdf->ImprovedTable($header,$data);
// $pdf->AddPage('L');
// $pdf->Image('../public/assets/img/logo.png',100,100,100);
// $pdf->FancyTable($header,$data);
$pdf->Output('D');
?>
