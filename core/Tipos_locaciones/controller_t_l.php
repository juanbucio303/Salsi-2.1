<?php

require_once("../conexion.php");

	
	switch ($_POST["action"]) 
	{
		case "get_all":
			
			$sql="select *from tipos_l;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;	

		case "insert":
			$TL=$_POST["TL"];
            $sql="insert into tipos_l values(null,'".$TL."')"; //forma de armar la cadena concatenando las variables
            $conexion->query($sql);	
        break;  

        case "delete":
        	$sql="delete from tipos_l where id_tipo_l='".$_POST["id_tipo_l"]."'";
            $conexion->query($sql);
        break;	

        case "update":
			$TL=$_POST["TL"];
			
			$sql="update tipos_l set descripcion='".$TL."' where id_tipo_l='".$_POST['id_tipo_l']."'";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;	

        case "get_one":
			$sql="select *from tipos_l where id_tipo_l='".$_POST["id_tipo_l"]."';";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;	
	}
	$conexion->close();
?>