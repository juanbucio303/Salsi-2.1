<?php

require_once("../conexion.php");

	
	switch ($_POST["action"]) 
	{
		case "get_all":
			
			$sql="select *from categorias_a order by descripcion asc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_a":
			
			$sql="select *from categorias_a where estado=1 and tipo_c=1 order by descripcion asc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_b":
			
			$sql="select *from categorias_a where estado=1 and tipo_c=2 order by descripcion asc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_alac":
			
			$sql="select *from categorias_a where estado=1 order by descripcion asc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "insert":
			$CA=$_POST["CA"];
			$TC=isset($_POST["TC"])?$_POST["TC"]:0;
			$sql="insert into categorias_a values(null,'".$CA."',1,'".$TC."')"; //forma de armar la cadena concatenando las variables
            $conexion->query($sql);	
		break;

		case "delete":
			$sql="delete from categorias_a where id_categoria_a='".$_POST["id_categoria_a"]."'";
            $conexion->query($sql)or trigger_error($conexion->error."[$sql]");
		break;	

		case "update":
			$CA=$_POST["CA"];
			$TC=isset($_POST["TC"])?$_POST["TC"]:0;
			$Est=isset($_POST["Est"])?$_POST["Est"]:0;

			$sql="update categorias_a set descripcion='".$CA."',estado='".$Est."', tipo_c='".$TC."' where id_categoria_a='".$_POST['id_categoria_a']."'";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;	

		case "get_one":
			$sql="select *from categorias_a where id_categoria_a='".$_POST["id_categoria_a"]."';";
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
				$sql="select *from categorias_a where descripcion like '%".$c."%' group by id_categoria_a;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					if($fila["estado"]==1){
						$clase="libre";
					}else{
						$clase="ocupado";
					}
					$valor.="<tr class='".$clase."'><td>".$fila['descripcion']."</td><td  class='centrado'><a class='waves-effect btn_eliminar' data-id= '".$fila["id_categoria_a"]."' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>cancel</span></a></td><td  class='centrado'><a class='waves-effect btn-flat btn_modificar' data-id='".$fila["id_categoria_a"]."' style='color: #1976d2'><span class='material-icons' style='margin-top: 0.2em'>edit</span></a></td></tr>";
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