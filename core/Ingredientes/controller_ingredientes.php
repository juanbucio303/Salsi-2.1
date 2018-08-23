<?php session_start();
require_once("../conexion.php");

	$id_usuario=$_SESSION['id_usuario'];
	switch ($_POST["action"]) 
	{	/*SE CREA LA SENTENCIA SQL PARA CONSULTAR*/
		case "get_all":
			$sql="select id_ingrediente,ingredientes.Descripcion as desi,cantidad,estado,fecha_c,estado_c,medida.descripcion as desm,ingredientes.id_medida from ingredientes,medida where ingredientes.id_medida=medida.id_medida and id_ingrediente>1 order by ingredientes.Descripcion asc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_i_a":
			$sql="select id_ingrediente,ingredientes.Descripcion as desi,cantidad,estado,fecha_c,estado_c,medida.descripcion as desm,ingredientes.id_medida from ingredientes,medida where ingredientes.id_medida=medida.id_medida order by ingredientes.Descripcion asc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
	
		case "insert":
			$Des=$_POST["DES"];
			$ME=isset($_POST["ME"])?$_POST["ME"]:0;
			$sql="insert into ingredientes values(null,'".$Des."',0,1,curdate(),1,'".$ME."');";
			$conexion->query($sql);
		break;		

		case "delete":
			$sql="delete from ingredientes where id_ingrediente='".$_POST["id_ingrediente"]."'";
			$conexion->query($sql);
		break;

		case "update":
			$DES=$_POST["DES"];
			$ME=isset($_POST["ME"])?$_POST["ME"]:0;
			$EST=isset($_POST["EST"])?$_POST["EST"]:0;

			$sql="update ingredientes set descripcion='".$DES."',id_medida='".$ME."',estado='".$EST."' where id_ingrediente='".$_POST['id_ingrediente']."';";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;

		case "get_one":
			$sql="select *from ingredientes where id_ingrediente='".$_POST["id_ingrediente"]."';";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;

		case "get_btn":
			$sql="select count(id_ingrediente) as btn from ingredientes where  estado_c!=1 or if(id_medida=1 and cantidad<=3000,'1','0')=1 or if(id_medida=2 and cantidad<=50 and id_ingrediente>1,'1','0')=1 or if(id_medida=3 and cantidad<=3000,'1','0')=1;";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;

		case "RestarI":
			$CAN=$_POST["CAN"];
			$sql=" call RESTARI('".$_POST["id_ingrediente"]."','".$CAN."');";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;

		case "get_m":

			$sql="select * from medida;";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "buscar":
			$valor='';
			if(isset($_POST['consulta']))
			{
				$c=$conexion->real_escape_string($_POST['consulta']);
				$sql="select id_ingrediente,ingredientes.Descripcion as desi,cantidad,estado,fecha_c,estado_c,medida.descripcion as desm,ingredientes.id_medida from ingredientes,medida where ingredientes.id_medida=medida.id_medida and id_ingrediente>1 and ingredientes.descripcion like '%".$c."%' order by ingredientes.Descripcion asc;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					if($fila["estado"]==1){
						$clase="libre";
					}else{
						if($fila["estado"]==0)
						{
							$clase="ocupado";
						}
					}
					$valor.="<tr class='".$clase."'><td>".$fila['desi']."</td><td>".$fila['cantidad']."</td><td>".$fila['fecha_c']."</td><td>".$fila['desm']."</td><td class='centrado'><a class='waves-effect btn-flat btn_restar' data-id='".$fila["id_ingrediente"]."' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>remove</span></a></td><td class='centrado'><a class='waves-effect btn-flat btn_eliminar' data-id='".$fila["id_ingrediente"]."' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>cancel</span></a></td><td class='centrado'><a class='waves-effect btn-flat btn_modificar' data-id='".$fila["id_ingrediente"]."' style='color: #1976d2'><span class='material-icons'>edit</span></a></td></tr>";
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