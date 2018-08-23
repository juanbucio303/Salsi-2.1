<?php

require_once("../conexion.php");

	switch ($_POST["action"]) 
	{
		case "get_all":
			
			$sql="select *from descuentos;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
		case "insert":
				$Porce=$_POST["Porce"];
				$sql="insert into descuentos values(null,'".$Porce."')";
				$conexion->query($sql);
		break;
		case "delete":
				$sql="delete from descuentos where id_descuento='".$_POST["id_descuento"]."'";
				$conexion->query($sql);
		break;

		case "update":
			$Porce=$_POST["Porce"];
			
			$sql="update descuentos set monto='".$Porce."' where id_descuento='".$_POST['id_descuento']."'";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;

		case "get_one":
			$sql="select *from descuentos where id_descuento='".$_POST["id_descuento"]."';";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;		

		case "buscar":
			$valor='';
			if(isset($_POST['consulta']))
			{
				$c=$conexion->real_escape_string($_POST['consulta']);
				$sql="select *from descuentos where monto like '%".$c."%' group by id_descuento;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>%".$fila['monto']."</td><td class='centrado'><a class='waves-effect btn-flat btn_eliminar' data-id='".$fila["id_descuento"]."'><span class='material-icons' style='color: #ef5350'>cancel</span></a></td><td class='centrado'><a class='waves-effect btn-flat  btn_modificar' style='color: #1976d2' data-id='".$fila["id_descuento"]."'><span class='material-icons'>edit</span></a></td></tr>";
				}
			}
			else
			{
				$valor.="<br><div class='alert alert-warning col-md-12'><h4>No hay datos que coincidan con los criterios de busqueda.</h4></div>";
			}
			echo $valor;
		break;
	}
	$conexion->close();
?>