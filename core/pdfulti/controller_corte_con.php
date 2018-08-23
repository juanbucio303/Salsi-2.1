<?php
	require_once('../mpdf/mpdf.php');
	require_once("../conexion.php");

  $pdf=json_decode($_GET["pdf"]);

	$sqld="select usuarios.nombre ,bitacoracor.fecha_corte from bitacoracor,usuarios where usuarios.id_usuario=bitacoracor.id_usuario and id_bitacora='".$pdf."'";
  $result=$conexion->query($sqld);
      $datosd=array();
      while ($row=$result->fetch_array()) 
      {
        $datosd[]=$row;
      }
    
  $sqlb="select * from bitacoracor where id_bitacora='".$pdf."'";
  $result=$conexion->query($sqlb);
      $datosb=array();
      while ($row=$result->fetch_array()) 
      {
        $datosb[]=$row;
      }
    $conexion->close(); 
	$html.='<body>

    <header class="clearfix">
      <div id="logo" class="text-center">
        <img src="../../img/logo.png" width="40%" class="img-rounded">
      </div>
      <br>
      <br>
      <h1 class="text-center" style="background:#D3D3D3;">SNACK BAR SAL SI PUEDES</h1>
      <div class="clearfix">
      <br>
      <br>
    		<h3 class="text-center" style="background:#F5F5F5;">CORTE DE DIA</h3>
      </div>
      <div id="project">';
      foreach ($datosd as $datosd) 
        {
          $html.='<tr><strong>Fecha de corte:</strong> '.$datosd["fecha_corte"].' 
          <br><strong>Usuario:</strong>'.$datosd["nombre"].'';
        }
    $html.='</div>
    </header>
    <main>
    <div class="panel-body table-responsive">
    <br>
    <br>
    <br>
      <table class="table table-bordered">
       
          <tr>
            <th>Total en el sistema</th>
            <th>Total ingresado</th>
            <th>Efectivo en el sistema</th>
            <th>Efectivo ingresado</th>
            <th>Credito en el sistema</th>
            <th>Credito ingresado</th>
            <th>Cantidad con la que inicio el corte</th>
            <th>Desfase</th>
          </tr>
        
        <tbody>';
        foreach ($datosb as $datosb) 
        {
        	$html.='<tr ><td>'.$datosb['total_c'].'</td><td>'.$datosb['total_in'].'</td><td>'.$datosb['c_efectivo'].'</td><td>'.$datosb['c_efectivo_i'].'</td><td>'.$datosb['c_credito'].'</td><td>'.$datosb['c_credito_i'].'</td><td>'.$datosb['cantidad_i'].'</td><td>'.$datosb['desfase'].'</td><tr>';
        }
        foreach ($dato as $dato)
        {
          $html.='<tr><td colspan="3">HORAS POR SEMANA</td><td>'.$dato['horas_tot'].'</td></tr>';
        }
    $html.='</tbody>
      </table>
    </main>
    </div>
    <footer  style="text-align: center; padding: 1em; margin: 1em 0em; top:90%; position:absolute; width:92%; background-color: #ecf0f1">
            TESVB POWER BY PROGRAMMING
    </footer>
  </body>';

	$mpdf=new mPDF('c','A4');
  $css= file_get_contents('../../css/bootstrap.css');
	$mpdf->writeHTML($css, 1);
	$mpdf->writeHTML($html);
  $mpdf->Output('corte de dia.pdf','I');
?>