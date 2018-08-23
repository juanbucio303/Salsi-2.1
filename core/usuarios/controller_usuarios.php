<?php
require_once("../conexion.php");
	switch ($_POST["action"]) 
	{	/*SE CREA LA SENTENCIA SQL PARA CONSULTAR*/
		case "get_all":
			$sql="select id_usuario,nombre,contraseña,role.descripcion from usuarios, role where role.id_role=usuarios.id_role;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			/*SE PARSEAN LOS DATOS YA QUE SON UNA MATRIZ*/
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
		case "insert":
			$NU=$_POST["NU"];
			$Con=$_POST["Con"];
			$RO=isset($_POST["RO"])?$_POST["RO"]:0;
			

			$sql="insert into usuarios values (null,'".$NU."','".$Con."','".$RO."')";
			$conexion->query($sql);
		break;		
		case "delete":
			$sql="delete from usuarios where id_usuario='".$_POST["id_usuario"]."'";
			$conexion->query($sql);
		break;
		case "update":
			$NU=$_POST["NU"];
			$Con=$_POST["Con"];
			$RO=isset($_POST["RO"])?$_POST["RO"]:0;
			

			$sql="update usuarios set nombre='".$NU."',contraseña='".$Con."',id_role='".$RO."' where id_usuario='".$_POST['id_usuario']."'";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;
		case "get_one":
			$sql="select *from usuarios where id_usuario='".$_POST["id_usuario"]."';";
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
				$sql="select id_usuario,nombre,contraseña,role.descripcion from usuarios, role where role.id_role=usuarios.id_role and role.descripcion like '%".$c."%';";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['nombre']."</td><td>".$fila['contraseña']."</td><td>".$fila['descripcion']."</td><td class='centrado'><a class='waves-effect btn-flat btn_eliminar' data-id='".$fila["id_usuario"]."' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>cancel</span></a></td><td class='centrado'><a class='waves-effect btn-flat btn_modificar' data-id='".$fila["id_usuario"]."' style='color: #1976d2'><span class='material-icons'>edit</span></a></td></tr>";
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