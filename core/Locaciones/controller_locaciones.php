<?php

require_once("../conexion.php");

	
	switch ($_POST["action"]) 
	{
		case "get_all":
			
			$id_tipo_l=$_POST["id_tipo_l"];
			$sql="select id_locacion,numero,tipos_l.descripcion,tipos_l.id_tipo_l,locaciones.estado from locaciones,tipos_l where locaciones.id_tipo_l=tipos_l.id_tipo_l and tipos_l.id_tipo_l='".$id_tipo_l."' and locaciones.estado<2;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));			
		break;

		case "insert":
			$NL=$_POST["NL"];
			$TL=$_POST["TL"];
			$tipo_l=$_POST["tipo_l"];
			$sql="insert into locaciones values(null,'".$NL."','".$tipo_l."',0,1);";
			$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
		break;

		case "delete":
			$sql="delete from locaciones where id_locacion='".$_POST["id_locacion"]."'";
			$conexion->query($sql);
		break;		

		case "update":
			$NL=$_POST["NL"];
			$TL=isset($_POST["TL"])?$_POST["TL"]:0;
			$EST=isset($_POST["EST"])?$_POST["EST"]:0;
			
			$sql="update locaciones set numero='".$NL."',id_tipo_l='".$TL."',estado='".$EST."' where id_locacion='".$_POST['id_locacion']."';";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;

		case "get_one":
			$sql="select *from locaciones where id_locacion='".$_POST["id_locacion"]."';";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;
	}
	$conexion->close();
?>