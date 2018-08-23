<?php

require_once("../conexion.php");

	
	switch ($_POST["action"]) 
	{
		case "get_all":
			
			$sql="select *from metodos_de_p;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "insert":
			$MP=$_POST["MP"];
            $sql="insert into metodos_de_p values(null,'".$MP."')"; //forma de armar la cadena concatenando las variables
            $conexion->query($sql);	
        break;  

        case "delete":
        	$sql="delete from metodos_de_p where id_mp='".$_POST["id_mp"]."'";
            $conexion->query($sql);
        break;  

        case "update":
			$MP=$_POST["MP"];
			
			$sql="update metodos_de_p set descripcion='".$MP."' where id_mp='".$_POST['id_mp']."'";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;

        case "get_one":
			$sql="select *from metodos_de_p where id_mp='".$_POST["id_mp"]."';";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;	
	}
	$conexion->close();
?>