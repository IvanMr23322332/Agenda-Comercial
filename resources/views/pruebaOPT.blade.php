<?php
// iconv('utf-8', 'cp1252', $txt)
use App\Models\PDF;

$pdf = new PDF();

$array = array(
    ["ENERO","L","M","X","J","V","S","D","L","M","X","J","V","S","D","L","M","X","J","V","S","D","L","M","X","J","V","S","D","L","M","X"],
    [" ","5","ANDA YA"," ",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0],
    ["FEBRERO","L","M","X","J","V","S","D","L","M","X","J","V","S","D","L","M","X","J","V","S","D","L","M","X","J","V","S","D"," "," "," "],
    [" ","5","ANDA YA"," ",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,6,0,0,0," "," "," ",0],
    [" ","5","ANDA YA"," ",0,0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0," "," "," ",0]
);

$pdf->SetFont('Arial','',14);
$pdf->AddPage('L');
$pdf->CabeceraOPT();

$pdf->TablaInfoOPT( "FECHAINI",
                    "CLIENTE",
                    "ANUNCIANTE",
                    "EMISORA",
                    "AGENTE"
);

$pdf->CabeceraPrincipalOPT();

for($i = 1; $i <= 2; $i++) {
    $pdf->ContenidoPrincipalOPT($array);
}

$pdf->TablaObservacionesOPT();

$pdf->Output('D');
?>
