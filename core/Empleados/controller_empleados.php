<?php

require_once("../conexion.php");

	
	switch ($_POST["action"]) 
	{
		case "get_all":
			
			$sql="select *from empleados;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
		
		case "insert":

		$nombre=$_POST["nombre"];
		$apellido_paterno=$_POST["apellido_paterno"];
		$apellido_materno=$_POST["apellido_materno"];
		$telefono=$_POST["telefono"];
		$sql="insert into empleados values(null,'".$nombre."','".$apellido_paterno."','".$apellido_materno."','".$telefono."')";
		$conexion->query($sql);
		break;	

		case "delete":
			$sql="delete from empleados where id_empleado='".$_POST["id_empleado"]."'";
			$conexion->query($sql);
		break;

		case "update":
			$nombre=$_POST["nombre"];
			$apellido_paterno=$_POST["apellido_paterno"];
			$apellido_materno=$_POST["apellido_materno"];
			$telefono=$_POST["telefono"];

			$sql="update empleados set nombre='".$nombre."',ap='".$apellido_paterno."',am='".$apellido_materno."',telefono='".$telefono."' where id_empleado='".$_POST['id_empleado']."'";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;


		case "get_one":
			$sql="select *from empleados where id_empleado='".$_POST["id_empleado"]."';";
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
				$sql="select *from empleados where nombre like '%".$c."%' group by id_empleado;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['nombre']."</td><td>".$fila['ap']."</td><td>".$fila['am']."</td><td>".$fila['telefono']."</td><td class='centrado'><a class='btn_eliminar waves-effect btn-flat' data-id='".$fila["id_empleado"]."' style='color: #ef5350'><span class='material-icons'>cancel</span></a></td><td class='centrado'><a class=' waves-effect btn-flat btn_modificar' data-id='".$fila["id_empleado"]."' style='color: #1976d2'><span class='material-icons'>edit</span></a></td></tr>";
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