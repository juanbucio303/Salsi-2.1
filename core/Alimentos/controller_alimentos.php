<?php session_start();
require_once("../conexion.php");

	$id_usuario=$_SESSION['id_usuario'];
	switch ($_POST["action"])
	{	/*SE CREA LA SENTENCIA SQL PARA CONSULTAR*/
		case "get_all":
			$sql="select alimentos.id_alimento as pro,alimentos.descripcion,alimentos.precio,categorias_a.descripcion categoria,alimentos.estado as alies,categorias_a.estado as cates,alimentos.cantidad_p,ingredientes.Descripcion,categorias_a.tipo_c from alimentos,categorias_a,ingredientes WHERE alimentos.id_categoria_a=categorias_a.id_categoria_a and ingredientes.id_ingrediente=alimentos.id_ingrediente union select bebidas.id_bebida as pro,bebidas.Descripcion,bebidas.precio,categorias_a.descripcion categoria,bebidas.estado as alies,categorias_a.estado as cates,bebidas.cantidad_p,ingredientes.Descripcion,categorias_a.tipo_c from bebidas,categorias_a,ingredientes where bebidas.id_categoria_a=categorias_a.id_categoria_a and ingredientes.id_ingrediente=bebidas.id_ingrediente ORDER BY categoria;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
		case "get_all_id":

				$id_categoria_a=$_POST["id_categoria_a"];
				$sql="select * from alimentos where id_categoria_a='".$id_categoria_a."' and estado=1 order by descripcion asc;";
				$result=$conexion->query($sql);
				$dat=array();
				while($row=$result->fetch_array())
					$dat[]=$row;
				print_r(json_encode($dat,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_nom":

				$idesc=$_POST["descripcion"];
				$sql="SELECT  alimentos.id_alimento,alimentos.Descripcion,alimentos.Precio, alimentos.id_categoria_a,alimentos.id_tipo_de_a,alimentos.estado,alimentos.cantidad_p,alimentos.id_ingrediente FROM alimentos,categorias_a where categorias_a.descripcion='".$idesc."' AND categorias_a.id_categoria_a=alimentos.id_categoria_a and alimentos.estado=1 order by alimentos.descripcion asc;";
				$result=$conexion->query($sql);
				$dat=array();
				while($row=$result->fetch_array())
					$dat[]=$row;
				print_r(json_encode($dat,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_id_b":

				$id_categoria_a=$_POST["id_categoria_a"];
				$sql="select * from bebidas where id_categoria_a='".$id_categoria_a."' and estado=1 order by descripcion asc;";
				$result=$conexion->query($sql);
				$dat=array();
				while($row=$result->fetch_array())
					$dat[]=$row;
				print_r(json_encode($dat,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "insert":
			$Des=$_POST["Des"];
			$Pre=$_POST["Pre"];
			$Canp=$_POST["Canp"];
			$Cat=isset($_POST["Cat"])?$_POST["Cat"]:0;
			$TA=isset($_POST["TA"])?$_POST["TA"]:0;
			$Ing=isset($_POST["Ing"])?$_POST["Ing"]:0;

			$s="select tipo_c from categorias_a where id_categoria_a='".$Cat."';";
			$result=$conexion->query($s);
			$datos=$result->fetch_assoc();
			$tp=$datos["tipo_c"];

			if($tp==1){
				$sql="insert into alimentos values (null,'".$Des."','".$Pre."','".$Cat."','".$TA."',1,'".$Canp."','".$Ing."');";
				$conexion->query($sql);
			}else{
				$sql="insert into bebidas values (null,'".$Des."','".$Pre."','".$Cat."','".$TA."',1,'".$Canp."','".$Ing."');";
				$conexion->query($sql);
			}
		break;

		case "delete_a":
			$sql="delete from alimentos where id_alimento='".$_POST["id_producto"]."'";
			$conexion->query($sql);
		break;

		case "delete_b":
			$sql="delete from bebidas where id_bebida='".$_POST["id_producto"]."'";
			$conexion->query($sql);
		break;

		case "update_a":
			$Des=$_POST["Des"];
			$Pre=$_POST["Pre"];
			$Cat=$_POST["Cat"];
			$Est=isset($_POST["Est"])?$_POST["Est"]:0;
			$Canp=$_POST["Canp"];
			$TA=isset($_POST["TA"])?$_POST["TA"]:0;
			$Ing=isset($_POST["Ing"])?$_POST["Ing"]:0;

			$sql="update alimentos set descripcion='".$Des."',precio='".$Pre."',id_categoria_a='".$Cat."',id_tipo_de_a='".$TA."',estado='".$Est."',cantidad_p='".$Canp."',id_ingrediente='".$Ing."' where id_alimento='".$_POST['id_producto']."'";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;

		case "update_b":
			$Des=$_POST["Des"];
			$Pre=$_POST["Pre"];
			$Cat=$_POST["Cat"];
			$Est=isset($_POST["Est"])?$_POST["Est"]:0;
			$Canp=$_POST["Canp"];
			$TA=isset($_POST["TA"])?$_POST["TA"]:0;
			$Ing=isset($_POST["Ing"])?$_POST["Ing"]:0;

			$sql="update bebidas set descripcion='".$Des."',precio='".$Pre."',id_categoria_a='".$Cat."',id_tipo_de_a='".$TA."',estado='".$Est."',cantidad_p='".$Canp."',id_ingrediente='".$Ing."' where id_bebida='".$_POST['id_producto']."'";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;

		case "get_one_a":
			$sql="select *from alimentos where id_alimento='".$_POST["id_producto"]."';";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;

		case "get_one_b":
			$sql="select *from bebidas where id_bebida='".$_POST["id_producto"]."';";
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
				$sql="select alimentos.id_alimento as pro,alimentos.descripcion,alimentos.precio,categorias_a.descripcion categoria,alimentos.estado as alies,categorias_a.estado as cates,alimentos.cantidad_p,ingredientes.Descripcion,categorias_a.tipo_c from alimentos,categorias_a,ingredientes WHERE alimentos.id_categoria_a=categorias_a.id_categoria_a and ingredientes.id_ingrediente=alimentos.id_ingrediente  and categorias_a.descripcion like '%".$c."%' union select bebidas.id_bebida as pro,bebidas.Descripcion,bebidas.precio,categorias_a.descripcion categoria,bebidas.estado as alies,categorias_a.estado as cates,bebidas.cantidad_p,ingredientes.Descripcion,categorias_a.tipo_c from bebidas,categorias_a,ingredientes where bebidas.id_categoria_a=categorias_a.id_categoria_a and ingredientes.id_ingrediente=bebidas.id_ingrediente and categorias_a.descripcion like '%".$c."%' ORDER BY categoria;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					if($fila["cates"]==0){
						$clase="ocupadoF";
					}else{
						if($fila["alies"]==1){
							$clase="libre";
						}else{
							$clase="ocupado";
						}
					}
					$valor.="<tr class='".$clase."'><td>".$fila['descripcion']."</td><td>$".$fila['precio']."</td><td>".$fila['categoria']."</td><td>".$fila['cantidad_p']."</td><td>".$fila['Descripcion']."</td><td class='centrado'>    <a class='waves-effect btn-flat  btn_eliminar' data-id='".$fila["pro"]."' data-tipo_c='".$fila["tipo_c"]."' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>cancel</span></a></td>   <td class='centrado'><a class='waves-effect btn-flat btn_modificar' data-id='".$fila["pro"]."' data-tipo_c='".$fila["tipo_c"]."'style='color: #1976d2'><span class='material-icons'  style='margin-top: 0.2em'>edit</span></a></td></tr>";
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
