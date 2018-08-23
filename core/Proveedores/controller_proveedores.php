<?php session_start();
require_once("../conexion.php");

	$id_usuario=$_SESSION['id_usuario'];
	switch ($_POST["action"]) 
	{	/*SE CREA LA SENTENCIA SQL PARA CONSULTAR*/
		case "get_all":
			$sql="select * from proveedores;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
	
		case "insert":
			$DES=$_POST["DES"];
			$TEL=$_POST["TEL"];
			$CON=$_POST["CON"];

			$sql="insert into proveedores values (null,'".$DES."','".$TEL."','".$CON."','1')";
			$conexion->query($sql);
		break;		

		case "delete":
			$sql="delete from proveedores where id_proveedor='".$_POST["id_proveedor"]."'";
			$conexion->query($sql);
		break;

		case "update":
			$DES=$_POST["DES"];
			$TEL=$_POST["TEL"];
			$CON=$_POST["CON"];
			$EST=isset($_POST["EST"])?$_POST["EST"]:0;

			$sql="update proveedores set descripcion='".$DES."',telefono='".$TEL."',contacto='".$CON."',estado='".$EST."' where id_proveedor='".$_POST['id_proveedor']."';";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;

		case "get_one":
			$sql="select *from proveedores where id_proveedor='".$_POST["id_proveedor"]."';";
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
				$sql="select alimentos.id_alimento,alimentos.descripcion,alimentos.precio,categorias_a.descripcion categoria,alimentos.estado as alies,categorias_a.estado as cates,alimentos.existencia from alimentos,categorias_a WHERE categorias_a.descripcion like '%".$c."%' and alimentos.id_categoria_a=categorias_a.id_categoria_a order by descripcion asc;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['descripcion']."</td><td>".$fila['precio']."</td><td>".$fila['categoria']."</td><td>".$fila['existencia']."</td><td><a class='btn btn-danger btn_eliminar' data-id='".$fila["id_alimento"]."'><span class='glyphicon glyphicon-minus'></span></a></td><td>".$fila['existencia']."</td><td><a class='btn btn-warning btn_modificar' data-id='".$fila["id_alimento"]."'><span class='glyphicon glyphicon-pencil'></span></a></td></tr>";
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