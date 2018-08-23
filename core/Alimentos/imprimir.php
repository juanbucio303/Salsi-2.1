<?php
require('../../fpdf181/fpdf.php');
require_once("../conexion.php");

$sql="select alimentos.descripcion,alimentos.precio,ventas.cantidad,(ventas.cantidad*alimentos.precio) from alimentos,ventas,tickets where alimentos.id_alimento=ventas.id_alimento and tickets.id_ticket=ventas.id_ticket and tickets.id_ticket=1 order by alimentos.descripcion,alimentos.precio,ventas.cantidad;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
$sql2='select sum(ventas.subtotal) total from alimentos,ventas,tickets where alimentos.id_alimento=ventas.id_alimento and tickets.id_ticket=ventas.id_ticket and tickets.id_ticket=1;';
			$result=$conexion->query($sql2);
			$datos2=array();
			while ($row=$result->fetch_array())
				$datos2[]=$row;

			//print_r($datos);
			/*SE PARSEAN LOS DATOS YA QUE SON UNA MATRIZ*/

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
	// Logo
	//$this->Image('logo_pb.png',10,8,33);
	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Movernos a la derecha
	$this->Cell(70);
	// Título
	$this->Cell(50,10,'Sal Si Puedes',1,0,'C');
	$this->Cell(-70,30,'Descripcion                               Cantidad                                  Precio',0,0,'C');
	
	
	// Salto de línea
	$this->Ln(20);
}

// Pie de página
function Footer()
{
	// Posición: a 1,5 cm del final
	$this->SetY(-10);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Número de página
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
//$pdf->SetMargins(15,15);
$pdf->SetAutoPageBreak(true);
$X=20;
$Y=30;
foreach ($datos as $value) 
{
	$pdf->Cell(160,10,utf8_decode($value[0]));
	$pdf->Cell(-75,10,'$'.$value[1].'.00');
	$pdf->Cell(30,10,$value[2]);
	

	//$Y=$Y+5;
	//se condiciona para hacer el salto pagina
	/*if ($Y>270) 
	{
		$Y=30;
		$pdf->AddPage();
	}*/
	$pdf->Ln();
}
foreach ($datos2 as $value2) 
{
	$pdf->SetX(100);
	$pdf->Cell(10,10,"Total Neto ".$value2[0]);
	$pdf->Ln();
}

$pdf->Output();
?>
