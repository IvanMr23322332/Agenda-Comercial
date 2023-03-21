<?php

namespace App\Models;
// iconv('utf-8', 'cp1252', $txt)

use Codedge\Fpdf\Fpdf\Fpdf;

class PDF extends FPDF {
    function LoadData($file)
    {
        // Leer las líneas del fichero
        $lines = file($file);
        $data = array();
        foreach($lines as $line)
            $data[] = explode(';',trim($line));
        return $data;
    }

    // Tabla coloreada
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(0,255,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Cabecera
        $w = array(40, 35, 45, 40);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }

    function Cabecera()
    {
        // Logo
        $this->Image('../public/assets/img/logo.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B', 8);
        // Movernos a la derecha
        $this->Cell(40);
        // Título
        $this->Cell(240,4,'CONTRATO / ORDEN DE PUBLICIDAD',1,0,'C');
        // Salto de línea
        $this->Ln(15);
    }

    function TablaRazonSocial($datos){


        // Razon Social
        $string = iconv('utf-8', 'cp1252', "Razón Social:");
        $this->Cell(30,4,$string,"LT",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[0]);
        $this->Cell(105,4,$string,"RT",1,'L');

        //CIF
        $string = iconv('utf-8', 'cp1252', "CIF:");
        $this->Cell(30,4,$string,"L",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[1]);
        $this->Cell(105,4,$string,"R",1,'L');

        //Emisora
        $string = iconv('utf-8', 'cp1252', "Emisora:");
        $this->Cell(30,4,$string,"L",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[2]);
        $this->Cell(105,4,$string,"R",1,'L');

        //Domicilio
        $string = iconv('utf-8', 'cp1252', "Domicilio:");
        $this->Cell(30,4,$string,"L",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[3]);
        $this->Cell(105,4,$string,"R",1,'L');

        //Cpostal, ciudad y provincia
        $string = iconv('utf-8', 'cp1252', "CP:");
        $this->Cell(30,4,$string,"LB",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[4]);
        $this->Cell(35,4,$string,"B",0,'L');

        $string = iconv('utf-8', 'cp1252', "Ciudad:");
        $this->Cell(20,4,$string, "B",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[5]);
        $this->Cell(50,4,$string,"RB",1,'L');


        // $this->MultiCell(105,4,"Razon social:".$razon, 'LTR',0,0,false);
        // $this->MultiCell(105,4,"CIF:".$cif, 'LR',0,0,false);
        // $this->MultiCell(105,4,"Emisora:".$emisora, 'LR',0,0,false);


    }

    function TablaCliente($datos){

        $this->setY(21);
        $this->setX(150);
        // Razon Social
        $string = iconv('utf-8', 'cp1252', "Anunciante:");
        $this->Cell(30,4,$string,"LT",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[1]);
        $this->Cell(110,4,$string,"RT",1,'L');

        $this->setX(150);
        //Emisora
        $string = iconv('utf-8', 'cp1252', "Cliente:");
        $this->Cell(30,4,$string,"L",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[0]);
        $this->Cell(110,4,$string,"R",1,'L');

        $this->setX(150);
        //CIF
        $string = iconv('utf-8', 'cp1252', "CIF:");
        $this->Cell(30,4,$string,"L",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[2]);
        $this->Cell(110,4,$string,"R",1,'L');

        $this->setX(150);
        //Domicilio
        $string = iconv('utf-8', 'cp1252', "Domicilio:");
        $this->Cell(30,4,$string,"L",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[3]);
        $this->Cell(110,4,$string,"R",1,'L');

        $this->setX(150);
        //Cpostal, poblacion y provincia
        $string = iconv('utf-8', 'cp1252', "CP:");
        $this->Cell(10,4,$string,"L",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[4]);
        $this->Cell(20,4,$string,"",0,'L');

        $string = iconv('utf-8', 'cp1252', "Población:");
        $this->Cell(20,4,$string, "",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[5]);
        $this->Cell(50,4,$string,"",0,'L');

        $string = iconv('utf-8', 'cp1252', "Provincia:");
        $this->Cell(20,4,$string, "",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[6]);
        $this->Cell(20,4,$string,"R",1,'L');

        $this->setX(150);
        //Teléfono
        $string = iconv('utf-8', 'cp1252', "Teléfono:");
        $this->Cell(30,4,$string,"LB",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[7]);
        $this->Cell(110,4,$string,"RB",1,'L');
    }

    function TablaCampanya($datos){
        $this->setY(50);

        //Cabecera
        $string = iconv('utf-8', 'cp1252', "DETALLLE DE CAMPAÑA");
        $this->SetFont("", "B");
        $this->SetFillColor(255,204,255);
        $this->Cell(135,4,$string,"LRT",1,'L',1);

        // Emisora
        $string = iconv('utf-8', 'cp1252', "Emisora:");
        $this->Cell(30,4,$string,"LT",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[0]);
        $this->Cell(105,4,$string,"RT",1,'L');

        //Fecha inicio y fin
        $string = iconv('utf-8', 'cp1252', "Fecha Inicio:");
        $this->Cell(30,4,$string,"L",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[1]);
        $this->Cell(35,4,$string,"",0,'L');

        $string = iconv('utf-8', 'cp1252', "Fecha Fin:");
        $this->Cell(30,4,$string, "",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[2]);
        $this->Cell(40,4,$string,"R",1,'L');

        // Formato
        $string = iconv('utf-8', 'cp1252', "Formato:");
        $this->Cell(30,4,$string,"L",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[3]);
        $this->Cell(105,4,$string,"R",1,'L');

        // Asesor
        $string = iconv('utf-8', 'cp1252', "Asesor:");
        $this->Cell(30,4,$string,"LB",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos[4]);
        $this->Cell(105,4,$string,"RB",1,'L');

    }

    function TablaObservaciones($datos){

        if (isset($datos['accion_comercial'])){
            $accionCom = $datos['accion_comercial'];
        }
        else{
            $accionCom = "";
        }


        $this->setY(50);
        $this->setX(150);

        //Cabecera
        $string = iconv('utf-8', 'cp1252', "OBSERVACIONES");
        $this->SetFont("", "B");
        $this->SetFillColor(255,204,255);
        $this->Cell(140,4,$string,"LRT",1,'L',1);

        $this->setX(150);

        $string = iconv('utf-8', 'cp1252', "Acción comercial:");
        $this->Cell(30,4,$string,"LT",0,'L');
        $string = iconv('utf-8', 'cp1252', $accionCom);
        $this->MultiCell(110,4,$string,"RT",'L',0);

        $this->setX(150);
        $string = iconv('utf-8', 'cp1252', "");
        $this->Cell(140,12,$string,"LRB",1,'L');
    }

    function CabeceraResumen(){
        $this->Ln(5);

        $string = iconv('utf-8', 'cp1252', "PROGRAMA");
        $this->Cell(80,10,$string,"LRBT",0,'C',1);

        $string = iconv('utf-8', 'cp1252', "FORMATO");
        $this->Cell(25,10,$string,"LRBT",0,'C',1);

        $string = iconv('utf-8', 'cp1252', "UNIDADES");
        $this->Cell(20,10,$string,"LRBT",0,'C',1);

        $string = iconv('utf-8', 'cp1252', "PRECIO");
        $this->Cell(25,10,$string,"LRBT",0,'C',1);

        $current_y = $this->GetY();
        $current_x = $this->GetX();
        $string = iconv('utf-8', 'cp1252', "PRECIO TOTAL \nTARIFA");
        $this->MultiCell(35,5,$string,"LRBT",'C',1);

        $this->SetXY($current_x + 35, $current_y);
        $string = iconv('utf-8', 'cp1252', "DTO %");
        $this->Cell(15,10,$string,"LRBT",0,'C',1);

        $current_y = $this->GetY();
        $current_x = $this->GetX();
        $string = iconv('utf-8', 'cp1252', "PRECIO UNITARIO \n(CON DTO)");
        $this->MultiCell(40,5,$string,"LRBT",'C',1);

        $this->SetXY($current_x + 40, $current_y);
        $string = iconv('utf-8', 'cp1252', "PRECIO TOTAL \nNETO");
        $this->MultiCell(40,5,$string,"LRBT",'C',1);

    }

    function ContenidoResumen($datos) {

        if(!isset($datos)){
            $datos = array(
                'programa'      =>      "",
                'tarifa'        =>      "",
                'formato'       =>      "",
                'unidades'      =>      "",
                'precio'        =>      "",
                'total_tarifa'  =>      "",
                'descuento'     =>      "",
                'precio_dto'    =>      "",
                'total_neto'    =>      "",
            );
        }

        $string = iconv('utf-8', 'cp1252', $datos['programa'] . " - " . $datos['tarifa']);
        $this->Cell(80,5,$string,"LRBT",0,'L');

        $string = iconv('utf-8', 'cp1252', $datos['formato']);
        $this->Cell(25,5,$string,"LRBT",0,'C');

        $string = iconv('utf-8', 'cp1252', $datos['unidades']);
        $this->Cell(20,5,$string,"LRBT",0,'C');

        if($datos['precio'] != "")
            $string = iconv('utf-8', 'cp1252', $datos['precio'] . " €");
        $this->Cell(25,5,$string,"LRBT",0,'C');

        if($datos['total_tarifa'] != "")
            $string = iconv('utf-8', 'cp1252', $datos['total_tarifa'] . " €");
        $this->Cell(35,5,$string,"LRBT",0,'R');

        if($datos['descuento'] != "")
            $string = iconv('utf-8', 'cp1252', $datos['descuento'] . " %");
        $this->Cell(15,5,$string,"LRBT",0,'C');

        if($datos['precio_dto'] != "")
            $string = iconv('utf-8', 'cp1252', $datos['precio_dto'] . " €");
        $this->Cell(40,5,$string,"LRBT",0,'R');

        if($datos['total_neto'] != "")
            $string = iconv('utf-8', 'cp1252', $datos['total_neto'] . " €");
        $this->Cell(40,5,$string,"LRBT",1,'R');

    }

    function tablaPago($factura, $formPago) {
        $this->setY(140);

        $this->SetFontSize(6);
        $string = iconv('utf-8', 'cp1252', "Facturar :");
        $this->Cell(30,5,$string,"",0,'R');

        $this->SetFontSize(8);
        $string = iconv('utf-8', 'cp1252', $factura);
        $this->Cell(105,5,$string,"B",1,'L');

        $this->SetFontSize(6);
        $string = iconv('utf-8', 'cp1252', "Forma de Pago :");
        $this->Cell(30,5,$string,"",0,'R');

        $this->SetFontSize(8);
        $string = iconv('utf-8', 'cp1252', $formPago);
        $this->Cell(105,5,$string,"B",1,'L');
    }

    function vtos($fecha, $cantidad) {

        $this->SetFontSize(6);
        $string = iconv('utf-8', 'cp1252', "Vtos :");
        $this->Cell(30,5,$string,"",0,'R');

        $this->SetFontSize(8);
        $string = iconv('utf-8', 'cp1252', $fecha);
        $this->Cell(40,5,$string,"B",0,'L');
        $string = iconv('utf-8', 'cp1252', $cantidad . " €");
        $this->Cell(40,5,$string,"B",1,'R');

    }

    function numAccount($numCuenta) {
        $this->Ln(5);

        $this->SetFontSize(6);
        $string = iconv('utf-8', 'cp1252', "Código de cuenta :");
        $this->Cell(30,4,$string,"",0,'R');

        $this->SetFontSize(8);
        for($i = 0; $i < 24; $i++) {
            if($i == 23) {
                $string = iconv('utf-8', 'cp1252', $numCuenta[$i]);
                $this->Cell(4,4,$string,"LRBT",1,'L');
            }
            else {
                $string = iconv('utf-8', 'cp1252', $numCuenta[$i]);
                $this->Cell(4,4,$string,"LRBT",0,'L');
            }
        }

        $this->setX(40);
        $string = iconv('utf-8', 'cp1252', "IBAN");
        $this->Cell(16,4,$string,"LRBT",0,'C');
        $string = iconv('utf-8', 'cp1252', "Entidad");
        $this->Cell(16,4,$string,"LRBT",0,'C');
        $string = iconv('utf-8', 'cp1252', "Sucursal");
        $this->Cell(16,4,$string,"LRBT",0,'C');
        $string = iconv('utf-8', 'cp1252', "D.C.");
        $this->Cell(8,4,$string,"LRBT",0,'C');
        $string = iconv('utf-8', 'cp1252', "Número de Cuenta");
        $this->Cell(40,4,$string,"LRBT",0,'C');
    }

    function precioFin($datos) {
        $this->setY(145);
        $this->setX(186);

        $string = iconv('utf-8', 'cp1252', "Total Unidades");
        $this->Cell(35,4,$string,"",0,'L');
        $string = iconv('utf-8', 'cp1252', $datos['total_cunyas']);
        $this->Cell(10,4,$string,"LRBT",0,'R');
        $this->SetFontSize(6);
        $string = iconv('utf-8', 'cp1252', "Total Neto:");
        $this->Cell(19,4,$string,"",0,'R');
        $this->SetFontSize(8);
        $string = iconv('utf-8', 'cp1252', $datos['total_neto'] . " €");
        $this->Cell(40,4,$string,"LRBT",1,'R');

        $this->setX(186);
        $string = iconv('utf-8', 'cp1252', "Gastos de producción");
        $this->Cell(64,4,$string,"",0,'L');
        $string = iconv('utf-8', 'cp1252', $datos['gastos_prod'] . " €");
        $this->Cell(40,4,$string,"LRBT",1,'R');

        $totalGen = $datos['total_neto'] + $datos['gastos_prod'];

        $this->setX(186);
        $string = iconv('utf-8', 'cp1252', "Total General");
        $this->Cell(64,4,$string,"",0,'L');
        $string = iconv('utf-8', 'cp1252', $totalGen . " €");
        $this->Cell(40,4,$string,"LRBT",1,'R');

        $this->setX(186);
        $string = iconv('utf-8', 'cp1252', "IVA");
        $this->Cell(64,4,$string,"",0,'L');
        $string = iconv('utf-8', 'cp1252', $datos['iva'] . " %");
        $this->Cell(40,4,$string,"LRBT",1,'R');

        $totalGenIva = $totalGen *(1+$datos['iva'] / 100);

        $this->setX(186);
        $string = iconv('utf-8', 'cp1252', "Total General (IVA Incluido)");
        $this->Cell(64,4,$string,"",0,'L');
        $string = iconv('utf-8', 'cp1252', $totalGenIva . " €");
        $this->Cell(40,4,$string,"LRBT",1,'R');
        $desc = 100 - $totalGen / $datos['total_bruto'] * 100;

        $this->setX(186);
        $string = iconv('utf-8', 'cp1252', "Descuento aplicado:");
        $this->Cell(64,4,$string,"",0,'L');
        $this->SetFontSize(6);
        $string = iconv('utf-8', 'cp1252', number_format($desc, 2, '.', "")  . " %");
        $this->Cell(40,4,$string,"",1,'R');
    }

    function fechaPie($lugar, $dia, $mes, $anyo) {
        $this->setY(185);
        $this->setX(10);
        $string = iconv('utf-8', 'cp1252', $lugar . " a " . $dia . " de " . $mes . " de " . $anyo);
        $this->Cell(40,4,$string,"B",0,'L');
    }

    function campoFirmas() {
        $current_y = $this->GetY();
        $this->setX(150);
        $this->SetFontSize(8);

        //Cabecera
        $string = iconv('utf-8', 'cp1252', "Firma del agente");
        $this->SetFont("", "B");
        $this->SetFillColor(255,204,255);
        $this->Cell(70,4,$string,"LRT",1,'L',1);

        $this->setX(150);

        $string = iconv('utf-8', 'cp1252', "");
        $this->Cell(70,16,$string,"LRBT",1,'L');

        $this->setY($current_y);
        $this->setX(220);

        //Cabecera
        $string = iconv('utf-8', 'cp1252', "Firma y sello del cliente");
        $this->SetFont("", "B");
        $this->SetFillColor(255,204,255);
        $this->Cell(70,4,$string,"LRT",1,'L',1);

        $this->setX(220);

        $string = iconv('utf-8', 'cp1252', "");
        $this->Cell(70,16,$string,"LRBT",1,'L');
    }

    // Pie de página
    function Pie()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    //PDF OPTICO ------------------------------------

    function CabeceraOPT()
    {
        // Arial bold 15
        $this->SetFont('Arial','B', 16);
        // Título
        $string = iconv('utf-8', 'cp1252', "Planificación de Radiaciones");
        $this->Cell(115,10,$string,1,0,'C');
        // Salto de línea
        $this->Ln(15);
    }

    function TablaInfoOPT($fechaini, $cliente, $anunciante, $emisora, $agente){
        $this->SetFontSize(8);

        //Fecha
        $string = iconv('utf-8', 'cp1252', "Fecha :");
        $this->Cell(30,5,$string,"LT",0,'R');

        $string = iconv('utf-8', 'cp1252', $fechaini);
        $this->Cell(85,5,$string,"RTB",1,'L');

        //Cliente
        $string = iconv('utf-8', 'cp1252', "Cliente :");
        $this->Cell(30,5,$string,"L",0,'R');

        $string = iconv('utf-8', 'cp1252', $cliente);
        $this->Cell(85,5,$string,"RB",1,'L');

        //Anunciante
        $string = iconv('utf-8', 'cp1252', "Anunciante :");
        $this->Cell(30,5,$string,"L",0,'R');

        $string = iconv('utf-8', 'cp1252', $anunciante);
        $this->Cell(85,5,$string,"RB",1,'L');

        //Emisora
        $string = iconv('utf-8', 'cp1252', "Emisora :");
        $this->Cell(30,5,$string,"L",0,'R');

        $string = iconv('utf-8', 'cp1252', $emisora);
        $this->Cell(85,5,$string,"RB",1,'L');

        //Agente
        $string = iconv('utf-8', 'cp1252', "Agente :");
        $this->Cell(30,5,$string,"L",0,'R');

        $string = iconv('utf-8', 'cp1252', $agente);
        $this->Cell(85,5,$string,"RB",1,'L');

        $this->Cell(115,1," ","LRB",1,'L');
    }

    function CabeceraPrincipalOPT(){
        $this->Ln(5);
        $this->SetFillColor(255,204,255);

        $string = iconv('utf-8', 'cp1252', "MATRICULA");
        $this->Cell(22,8,$string,"LRBT",0,'C',1);

        $string = iconv('utf-8', 'cp1252', "DURACIÓN");
        $this->Cell(17,8,$string,"LRBT",0,'C',1);

        $string = iconv('utf-8', 'cp1252', "TARIFA");
        $this->Cell(35,8,$string,"LRBT",0,'C',1);

        $string = iconv('utf-8', 'cp1252', "HORA");
        $this->Cell(10,8,$string,"LRBT",0,'C',1);

        for($i = 1; $i <= 31; $i++) {
            $string = iconv('utf-8', 'cp1252', $i);
            $this->Cell(6,8,$string,"LRBT",0,'C',1);
        }

        $string = iconv('utf-8', 'cp1252', "UDS.");
        $this->Cell(10,8,$string,"LRBT",1,'C',1);

    }

    function FilaInfo($fila){
        $this->SetFillColor(204,245,255);
        $string = iconv('utf-8', 'cp1252', $fila['mes']);
        $this->Cell(84,6,$string,"LRBT",0,'C',1);

        for($j = 1; $j <= 31; $j++) {

            $index = "data" . $j;

            if($fila[$index] == "S" || $fila[$index] == "D"){
                $this->SetFillColor(255,238,204);
            }else{
                $this->SetFillColor(204,245,255);
            }
            $string = iconv('utf-8', 'cp1252', $fila[$index]);
            $this->Cell(6,6,$string,"LRBT",0,'C',1);
        }

        $string = iconv('utf-8', 'cp1252', " ");
        $this->Cell(10,6,$string,"LRBT",1,'C',1);

    }

    function FilaDatos($fila){
        $string = iconv('utf-8', 'cp1252', $fila['matricula']);
        $this->Cell(22,6,$string,"LRBT",0,'C');

        $string = iconv('utf-8', 'cp1252', $fila['duracion']);
        $this->Cell(17,6,$string,"LRBT",0,'C');

        $string = iconv('utf-8', 'cp1252', $fila['tarifa_name']);
        $this->Cell(35,6,$string,"LRBT",0,'C');

        $string = iconv('utf-8', 'cp1252', $fila['hora']);
        $this->Cell(10,6,$string,"LRBT",0,'C');

        for($j = 1; $j <= 31; $j++) {

            $index = "data" . $j;

            $string = iconv('utf-8', 'cp1252', $fila[$index]);

            if($string === "-1"){
                $this->SetFillColor(160,160,160);
                $this->Cell(6,6,"","LRBT",0,'C',1);
            }else{
                $this->Cell(6,6,$string,"LRBT",0,'C');
            }


        }

        $string = iconv('utf-8', 'cp1252', $fila['total']);
        $this->Cell(10,6,$string,"LRBT",1,'C');
    }

    function TablaObservacionesOPT(){
        $this->Ln(5);

        //Cabecera
        $string = iconv('utf-8', 'cp1252', "OBSERVACIONES");
        $this->SetFont("", "B");
        $this->SetFillColor(255,204,255);
        $this->Cell(280,6,$string,"LRTB",1,'L',1);

        $string = iconv('utf-8', 'cp1252', "");
        $this->Cell(280,26,$string,"LRB",1,'L');
    }

    function ObservacionesGenerales ($datos){
        $string = iconv('utf-8', 'cp1252', $datos);
        $this->MultiCell(280,5,$string,"LRBT",'L',0);
    }
}

?>
