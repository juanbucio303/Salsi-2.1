<?php
require_once("../conexion.php");
	switch ($_POST["action"]) 
	{	/*SE CREA LA SENTENCIA SQL PARA CONSULTAR*/
		case "get_all":
			$sql="select entradas.id_entrada,ingredientes.Descripcion,entradas.cantidad_e,entradas.fecha_e,entradas.fecha_c,proveedores.descripcion,entradas.estado from entradas,ingredientes,proveedores where entradas.id_ingrediente=ingredientes.id_ingrediente and proveedores.id_proveedor=entradas.id_proveedor and entradas.estado=1 union select entradas.id_entrada,ingredientes.Descripcion,entradas.cantidad_e,entradas.fecha_e,entradas.fecha_c,proveedores.descripcion,entradas.estado from entradas,ingredientes,proveedores where entradas.id_ingrediente=ingredientes.id_ingrediente and proveedores.id_proveedor=entradas.id_proveedor and entradas.estado=3;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			/*SE PARSEAN LOS DATOS YA QUE SON UNA MATRIZ*/
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
		case "insert":
			$Ing=isset($_POST["Ing"])?$_POST["Ing"]:0;
			$Pro=isset($_POST["Pro"])?$_POST["Pro"]:0;
			$Can=$_POST["Can"];
			$Fcc=$_POST["Fcc"];

			$sql="call ENTRADAS('".$Ing."','".$Can."','".$Fcc."','".$Pro."');";
			$resultado=$conexion->query($sql);
			$datos=array();
			while($row=$resultado->fetch_array())
			$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
		case "insertN":
			$Pro=isset($_POST["Pro"])?$_POST["Pro"]:0;
			$Can=$_POST["Can"];
			$Fcc=$_POST["Fcc"];

			$sql="call ENTRADAS('".$_POST["id_ingrediente"]."','".$Can."','".$Fcc."','".$Pro."');";
			$resultado=$conexion->query($sql);
			$datos=array();
			while($row=$resultado->fetch_array())
			$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;		
		case "LiberarEC":
			$Can=$_POST["Can"];
			$sql="call LENTRADASC('".$_POST["id_entrada"]."','".$Can."');";
			$resultado=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$resultado->fetch_array())
			$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "LiberarE":
			$sql="call LENTRADAS('".$_POST["id_entrada"]."');";
			$resultado=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$resultado->fetch_array())
			$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "buscar":
			$valor='';
			if(isset($_POST['consulta']))
			{
				$c=$conexion->real_escape_string($_POST['consulta']);
				$sql="select entradas.id_entrada,ingredientes.Descripcion,entradas.cantidad_e,entradas.fecha_e,entradas.fecha_c,proveedores.descripcion,entradas.estado from entradas,ingredientes,proveedores where entradas.id_ingrediente=ingredientes.id_ingrediente and proveedores.id_proveedor=entradas.id_proveedor and entradas.estado=1 and entradas.fecha_e like '%".$c."%' 
union select entradas.id_entrada,ingredientes.Descripcion,entradas.cantidad_e,entradas.fecha_e,entradas.fecha_c,proveedores.descripcion,entradas.estado from entradas,ingredientes,proveedores where entradas.id_ingrediente=ingredientes.id_ingrediente and proveedores.id_proveedor=entradas.id_proveedor and entradas.estado=3 and entradas.fecha_e like '%".$c."%';";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					if($fila["estado"]==1){
						$clase="libre";
					}else{
						if($fila["estado"]==3)
						{
							$clase="caducado";
						}
					}
					$valor.="<tr class='".$clase."'><td>".$fila['Descripcion']."</td><td>".$fila['cantidad_e']."</td><td>".$fila['fecha_e']."</td><td>".$fila['fecha_c']."</td><td>".$fila['descripcion']."</td><td class='centrado'><a class='waves-effect btn_eliminar' data-id='".$fila["id_entrada"]."' data-estado='".$fila["estado"]."' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>lock</span></a></td></tr>";
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