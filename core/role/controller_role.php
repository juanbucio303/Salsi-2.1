<?php

require_once("../conexion.php");

	
	switch ($_POST["action"]) 
	{	/*SE CREA LA SENTENCIA SQL PARA CONSULTAR*/
		case "get_all":
			
			$sql="select *from role;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			/*SE PARSEAN LOS DATOS YA QUE SON UNA MATRIZ*/
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
	}
	$conexion->close();
?>