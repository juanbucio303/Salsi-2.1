<?php session_start();
require_once("../conexion.php");

	$id_usuario=$_SESSION['id_usuario'];

	switch ($_POST["action"])
	{
		case "get_all":

			$id_tipo_l=$_POST["id_tipo_l"];
			$sql="select locaciones.id_locacion,locaciones.numero,tipos_l.descripcion,tipos_l.id_tipo_l,locaciones.id_ticket,locaciones.estado from locaciones,tipos_l where locaciones.estado >0 and locaciones.estado<3 and locaciones.id_tipo_l=tipos_l.id_tipo_l and tipos_l.id_tipo_l='".$id_tipo_l."' group by id_locacion,id_tipo_l;";

			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_ven":
			$id_locacion=$_POST["id_locacion"];
			$id_ticket=$_POST["id_ticket"];
			$sql="select alimentos.descripcion,alimentos.precio,ventas.cantidad,ventas.subtotal,id_venta,ventas.id_cuenta,locaciones.id_tipo_l,ventas.id_alimento,ventas.tipo_v,cuentas.descripcion as cuentas from alimentos,ventas,locaciones,cuentas,tickets where alimentos.id_alimento=ventas.id_alimento and ventas.id_cuenta=cuentas.id_cuenta and cuentas.id_locacion=locaciones.id_locacion and cuentas.id_ticket=tickets.id_ticket and locaciones.id_ticket=tickets.id_ticket and cuentas.id_locacion='".$id_locacion."' and locaciones.id_ticket='".$id_ticket."' and ventas.estado=1 and cuentas.estado=1 union select bebidas.Descripcion,bebidas.precio,ventasb.cantidad,ventasb.subtotal,id_ventaB,ventasb.id_cuenta,locaciones.id_tipo_l,ventasb.id_bebida,ventasb.tipo_v,cuentas.descripcion as cuentas from bebidas,ventasb,locaciones,cuentas,tickets where bebidas.id_bebida=ventasb.id_bebida and ventasb.id_cuenta=cuentas.id_cuenta and cuentas.id_locacion=locaciones.id_locacion and cuentas.id_ticket=tickets.id_ticket and locaciones.id_ticket=tickets.id_ticket and cuentas.id_locacion='".$id_locacion."' and locaciones.id_ticket='".$id_ticket."' and ventasb.estado=1 and cuentas.estado=1 union select complementos.descripcion,complementos.precio,complementos.cantidad,complementos.subtotal,id_complemento,complementos.id_cuenta,locaciones.id_tipo_l,complementos.estado,complementos.tipo_v,cuentas.descripcion as cuentas from complementos,locaciones,cuentas,tickets where complementos.id_cuenta=cuentas.id_cuenta and cuentas.id_locacion=locaciones.id_locacion and cuentas.id_ticket=tickets.id_ticket and locaciones.id_ticket=tickets.id_ticket and cuentas.id_locacion='".$id_locacion."' and locaciones.id_ticket='".$id_ticket."' and complementos.estado=1 and cuentas.estado=1 ORDER BY cuentas DESC;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;


		case "get_all_cuenta":
			$id_locacion=$_POST["id_locacion"];
			$sql="select * from cuentas where id_locacion='".$id_locacion."' and estado=1;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_c":
			$sql="select * from cuentas where cuentas.id_ticket='".$_POST["id_ticket"]."' and estado=1 union select * from cuentas where cuentas.id_ticket='".$_POST["id_ticket"]."' and estado=2";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_cu":
			$sql="select * from cuentas where id_cuenta='".$_POST["id_cuenta"]."' and estado=1 union select * from cuentas where id_cuenta='".$_POST["id_cuenta"]."' and estado=2;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_one_cuenta":
			$sql="select *from cuentas where id_cuenta='".$_POST["id_cuenta"]."';";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;

		case "get_all":

			$id_tipo_l=$_POST["id_tipo_l"];
			$sql="select locaciones.id_locacion,locaciones.numero,tipos_l.descripcion,tipos_l.id_tipo_l,locaciones.id_ticket,locaciones.estado from locaciones,tipos_l where locaciones.estado >0 and locaciones.estado<3 and locaciones.id_tipo_l=tipos_l.id_tipo_l and tipos_l.id_tipo_l='".$id_tipo_l."' group by id_locacion,id_tipo_l;";

			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "getCon":
				$SEG=$_POST["SEG"];
				$sql="select count(id_usuario) from usuarios where id_usuario='".$id_usuario."' and contraseña_cancelacion='".$SEG."';";
				$resultado=$conexion->query($sql);
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "reserva":
				$sql="CALL RESERVA_C('".$_POST["id_locacion"]."');";
				$resultado=$conexion->query($sql);
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "ADD_C":
				$sql="CALL ADD_C('".$_POST["id_locacion"]."');";
				$resultado=$conexion->query($sql);
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "CLEAR_L":
				$sql="CALL CLEAR_L('".$_POST["id_locacion"]."');";
				$resultado=$conexion->query($sql);
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "cuenta":

			$sqlp="select subtotal from tickets where id_ticket='".$_POST["id_ticket"]."';";
				$resultado=$conexion->query($sqlp)or trigger_error($conexion->error."[$sqlp]");
				$datosp=array();
				while($rowp=$resultado->fetch_array())
				$datosp[]=$rowp;
				print_r(json_encode($datosp));

		break;

		case "PAGO_C":
				$MP=isset($_POST["MP"])?$_POST["MP"]:0;
				$DES=isset($_POST["DES"])?$_POST["DES"]:0;
				$EMP=isset($_POST["EMP"])?$_POST["EMP"]:0;
				$CAN=$_POST["CAN"];

				$sql="CALL PAGO_C('".$_POST["id_cuenta"]."','".$MP."','".$CAN."','".$EMP."','".$DES."')";
				$resultado=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

		break;

		case "CORTE":
			$Can=$_POST["Can"];
			$sql="CALL CIERRE_S('".$id_usuario."','".$Can."');";
			$resultado=$conexion->query($sql);
			$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

		break;


		case "AGREGARV":
				$Cat=$_POST["Cat"];
				$Ali=isset($_POST["Ali"])?$_POST["Ali"]:0;
				$Cu=isset($_POST["Cu"])?$_POST["Cu"]:0;
				// $sqlid="SELECT id_categoria_a FROM categorias_a WHERE descripcion='".$Cat."';";
				// $id=$conexion->query($sqlid);
				// $dat=array();
				// while($row=$id->fetch_array())
				// $dat[]=$row;
				// $res=$dat[0]["id_categoria_a"];
				// echo $res;
				$Can=$_POST["Can"];
				$sql="CALL AGREGAR_V('".$Can."','".$Ali."','".$_POST["id_locacion"]."','".$id_usuario."','".$Cu."')";
				$resultado=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "AGREGARVB":
				$Cat=isset($_POST["Cat"])?$_POST["Cat"]:0;
				$Beb=isset($_POST["Beb"])?$_POST["Beb"]:0;
				$Cu=isset($_POST["Cu"])?$_POST["Cu"]:0;
				$Ing=isset($_POST["Ing"])?$_POST["Ing"]:1;
				$Ing2=isset($_POST["Ing2"])?$_POST["Ing2"]:1;
				$Can=$_POST["Can"];
				$Can2=isset($_POST["Can2"])?$_POST["Can2"]:0;
				$Can3=isset($_POST["Can3"])?$_POST["Can3"]:0;
				$sql="CALL AGREGAR_B('".$Can."','".$Beb."','".$_POST["id_locacion"]."','".$Ing."','".$Can2."','".$Ing2."','".$Can3."','".$id_usuario."','".$Cu."')";
				$resultado=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_one_v":
				$sql="select ventas.cantidad from ventas where id_venta='".$_POST["id_venta"]."';";
				$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$result->fetch_array())
					$datos[]=$row;
				print_r(json_encode($datos));
		break;

		case "get_one_b":
				$sql="select ventasB.cantidad from ventasB where id_ventaB='".$_POST["id_venta"]."';";
				$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$result->fetch_array())
					$datos[]=$row;
				print_r(json_encode($datos));
		break;

		case "cancelar_v":

				$Can=$_POST["Can"];
				$sql="CALL CAN_V('".$_POST["id_venta"]."','".$_POST["id_alimento"]."','".$_POST["id_cuenta"]."','".$Can."');";
				$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$result->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "cancelar_b":

				$Can=$_POST["Can"];
				$sql="CALL CAN_B('".$_POST["id_venta"]."','".$_POST["id_alimento"]."','".$_POST["id_cuenta"]."','".$Can."');";
				$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$result->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "AGREGARC":
				$DES=$_POST["DES"];
				$PRE=$_POST["PRE"];
				$CAN=$_POST["CAN"];
				$Cu=isset($_POST["Cu"])?$_POST["Cu"]:0;

				$sql="CALL AGREGAR_C('".$_POST["id_locacion"]."','".$DES."','".$PRE."','".$CAN."','".$id_usuario."','".$Cu."');";
				$resultado=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_one_c":
				$sql="select cantidad from complementos where id_complemento='".$_POST["id_venta"]."';";
				$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$result->fetch_array())
					$datos[]=$row;
				print_r(json_encode($datos));
		break;

		case "cancelar_com":

				$CAN=$_POST["CAN"];
				$sql="CALL CAN_C('".$_POST["id_venta"]."','".$_POST["id_cuenta"]."','".$CAN."','".$id_usuario."');";
				$resultado=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "modificar_com":

				$Cu=isset($_POST["Cu"])?$_POST["Cu"]:0;
				$sql="CALL MODIFICAR_C_C('".$_POST["id_venta"]."','".$Cu."');";
				$resultado=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "modificar_ven":

				$Cu=isset($_POST["Cu"])?$_POST["Cu"]:0;
				$sql="CALL MODIFICAR_V('".$_POST["id_venta"]."','".$Cu."');";
				$resultado=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "modificar_venb":

				$Cu=isset($_POST["Cu"])?$_POST["Cu"]:0;
				$sql="CALL MODIFICAR_V_B('".$_POST["id_venta"]."','".$Cu."');";
				$resultado=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
	}
	$conexion->close();
?>
