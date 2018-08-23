<?php

require_once("../conexion.php");

	
	switch ($_POST["action"]) 
	{	
		case "get_all_Corte":
			$sql="select id_bitacora, total_c,c_efectivo,c_credito,cantidad_i,ganancia,fecha_inicio,fecha_corte,usuarios.nombre from bitacoracor , usuarios where usuarios.id_usuario=bitacoracor.id_usuario group by id_bitacora order by fecha_corte desc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

		break;

		case "buscar_corte":
				$valor='';
				if(isset($_POST['consulta']))
				{
					$c=$conexion->real_escape_string($_POST['consulta']);

					$sql="select id_bitacora, total_c,c_efectivo,c_credito,cantidad_i,ganancia,fecha_inicio,fecha_corte,usuarios.nombre from bitacoracor , usuarios where usuarios.id_usuario=bitacoracor.id_usuario and fecha_inicio like '%".$c."%'  group by id_bitacora order by fecha_corte desc;";
				}
				$rest=$conexion->query($sql);
				if ($rest->num_rows >0)
				{
					while ($fila=$rest->fetch_assoc())
					{
						$valor.="<tr><td>".$fila['id_bitacora']."</td><td>".$fila['fecha_inicio']."</td><td>".$fila['fecha_corte']."</td><td>".$fila['nombre']."</td><td class='centrado'><a class='waves-effect btn-flat btn_pdf' data-id='".$fila["id_bitacora"]."' data-fi='".$fila["fecha_inicio"]."' data-fc='".$fila["fecha_corte"]."' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>print</span></a></td></tr>";	
					}
				}
				else
				{
					$valor.="<br><div class='alert alert-warning col-md-12'><h4>No hay datos que coincidan con los criterios de busqueda.</h4></div>";
				}
				echo $valor;
		break;

		case "get_all_CorteE":
		$id_corte=$_POST["id_corte"];
			$sql="select id_bitacora, total_c,c_efectivo,c_credito,cantidad_i,ganancia,fecha_inicio,fecha_corte,usuarios.nombre from bitacoracor , usuarios where usuarios.id_usuario=bitacoracor.id_usuario and bitacoracor.id_bitacora='".$id_corte."' group by id_bitacora order by fecha_corte desc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

		break;

		case "get_all_CorteV":
			$fecha_inicio=$_POST["fecha_inicio"];
			$fecha_corte=$_POST["fecha_corte"];

			$sql="select cuentas.id_cuenta as cu,complementos.Descripcion as desi,complementos.cantidad,complementos.precio,complementos.subtotal from complementos,cuentas where complementos.id_cuenta=cuentas.id_cuenta and complementos.estado=0 and cuentas.estado=0 and cuentas.fecha BETWEEN ('".$fecha_inicio."') and ('".$fecha_corte."') union select cuentas.id_cuenta as cu,bebidas.Descripcion as desi,ventasB.cantidad,bebidas.precio,ventasB.subtotal from ventasB,cuentas,bebidas where ventasB.id_cuenta=cuentas.id_cuenta 
and ventasB.id_bebida=bebidas.id_bebida and ventasB.estado=0 and cuentas.estado=0 and cuentas.fecha BETWEEN ('".$fecha_inicio."') and ('".$fecha_corte."') union select cuentas.id_cuenta as cu,alimentos.Descripcion as desi,ventas.cantidad,alimentos.precio,ventas.subtotal from ventas,cuentas,alimentos where ventas.id_cuenta=cuentas.id_cuenta and ventas.id_alimento=alimentos.id_alimento and ventas.estado=0 and cuentas.estado=0 and cuentas.fecha BETWEEN ('".$fecha_inicio."') and ('".$fecha_corte."') order by cu asc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

		break;

		case "get_all_Bvm":
			$sql="select bventas.id_ventaN as id_ventaN,cuentas.descripcion as cuenta,bventas.cantidadN as cantidadN,bventas.cantidadO as cantidadO,alimentos.descripcion as alimento,bventas.subtotalN as subtotalN,bventas.subtotalO as subtotalO,bventas.fecha as fecha,usuarios.nombre as nombre from bventas,ventas,cuentas,alimentos,usuarios where bventas.id_ventaN=ventas.id_venta and bventas.id_cuentaN=cuentas.id_cuenta and bventas.id_alimentoN=alimentos.id_alimento and bventas.id_usuarioN=usuarios.id_usuario GROUP BY id_Bventa;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));	 
		break;

		case "buscar_Bvm":
			$valor='';
			if(isset($_POST['par']))
			{
				$c=$conexion->real_escape_string($_POST['par']);
				$c2=$conexion->real_escape_string($_POST['par2']);
				
				$sql="select cuentas.id_cuenta as cu,complementos.Descripcion as desi,complementos.cantidad,complementos.precio,complementos.subtotal from complementos,cuentas where complementos.id_cuenta=cuentas.id_cuenta and complementos.estado=0 and cuentas.estado=0 and cuentas.fecha BETWEEN ('".$c."') and ('".$c2."') union select cuentas.id_cuenta as cu,bebidas.Descripcion as desi,ventasB.cantidad,bebidas.precio,ventasB.subtotal from ventasB,cuentas,bebidas where ventasB.id_cuenta=cuentas.id_cuenta and ventasB.id_bebida=bebidas.id_bebida and ventasB.estado=0 and cuentas.estado=0 and cuentas.fecha BETWEEN ('".$c."') and ('".$c2."') union select cuentas.id_cuenta as cu,alimentos.Descripcion as desi,ventas.cantidad,alimentos.precio,ventas.subtotal from ventas,cuentas,alimentos where ventas.id_cuenta=cuentas.id_cuenta and ventas.id_alimento=alimentos.id_alimento and ventas.estado=0 and cuentas.estado=0 and cuentas.fecha BETWEEN ('".$c."') and ('".$c2."') order by cu asc;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['cu']."</td><td>".$fila['desi']."</td><td>".$fila['cantidad']."</td><td>".$fila['precio']."</td><td>".$fila['subtotal']."</td></tr>";
				}
			}
			else
			{
				$valor.="<br><div class='alert alert-warning col-md-12'><h4>No hay datos que coincidan con los criterios de busqueda.</h4></div>";
			}
			echo $valor;
		break;


		case "buscar_Bvc":
			$valor='';
			if(isset($_POST['par']))
			{
				$c=$conexion->real_escape_string($_POST['par']);
				$c2=$conexion->real_escape_string($_POST['par2']);
				
				$sql="select entradas.id_entrada as entri,ingredientes.Descripcion as desi,entradas.cantidad_e as cane,entradas.fecha_e as fe,entradas.fecha_c as fc,proveedores.descripcion as prove from ingredientes,proveedores,entradas where entradas.id_ingrediente=ingredientes.id_ingrediente and entradas.id_proveedor=proveedores.id_proveedor and entradas.estado=2 and entradas.fecha_c BETWEEN ('".$c."') and ('".$c2."') union select entradas.id_entrada as entri,ingredientes.Descripcion as desi,entradas.cantidad_e as cane,entradas.fecha_e as fe,entradas.fecha_c as fc,proveedores.descripcion as prove from ingredientes,proveedores,entradas where entradas.id_ingrediente=ingredientes.id_ingrediente and entradas.id_proveedor=proveedores.id_proveedor and entradas.estado=2 and entradas.fecha_e BETWEEN ('".$c."') and ('".$c2."') ORDER BY entri asc;";

			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['entri']."</td><td>".$fila['desi']."</td><td>".$fila['cane']."</td><td>".$fila['fe']."</td><td>".$fila['fc']."</td><td>".$fila['prove']."</td></tr>";
				}
			}
			else
			{
				$valor.="<br><div class='alert alert-warning col-md-12'><h4>No hay datos que coincidan con los criterios de busqueda.</h4></div>";
			}
			echo $valor;
		break;

		case "buscar_Bcm":
			$valor='';
			if(isset($_POST['par']))
			{
				$c=$conexion->real_escape_string($_POST['par']);
				$c2=$conexion->real_escape_string($_POST['par2']);
				
				$sql="select entradas.id_entrada as entri,ingredientes.Descripcion as desi,entradas.cantidad_e as cane,entradas.fecha_e as fe,entradas.fecha_c as fc,proveedores.descripcion as prove from ingredientes,proveedores,entradas where entradas.id_ingrediente=ingredientes.id_ingrediente and entradas.id_proveedor=proveedores.id_proveedor and entradas.estado=4 and entradas.fecha_c BETWEEN ('".$c."') and ('".$c2."') union select entradas.id_entrada as entri,ingredientes.Descripcion as desi,entradas.cantidad_e as cane,entradas.fecha_e as fe,entradas.fecha_c as fc,proveedores.descripcion as prove from ingredientes,proveedores,entradas where entradas.id_ingrediente=ingredientes.id_ingrediente and entradas.id_proveedor=proveedores.id_proveedor and entradas.estado=4 and entradas.fecha_e BETWEEN ('".$c."') and ('".$c2."') ORDER BY entri asc;";

			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['entri']."</td><td>".$fila['desi']."</td><td>".$fila['cane']."</td><td>".$fila['fe']."</td><td>".$fila['fc']."</td><td>".$fila['prove']."</td></tr>";
				}
			}
			else
			{
				$valor.="<br><div class='alert alert-warning col-md-12'><h4>No hay datos que coincidan con los criterios de busqueda.</h4></div>";
			}
			echo $valor;
		break;

		case "buscar_Bcc":
			$valor='';
			if(isset($_POST['par']))
			{
				$c=$conexion->real_escape_string($_POST['par']);
				$c2=$conexion->real_escape_string($_POST['par2']);
				
				$sql="select bcomc.id_complementoN as venta,bcomc.id_cuentaN as cuenta,cuentas.descripcion as descu,bcomc.descripcion as desi,bcomc.cantidad as canti,bcomc.subtotal as sub,usuarios.nombre as usi from bcomc,complementos,cuentas,usuarios where bcomc.id_cuentaN=cuentas.id_cuenta and bcomc.id_usuarioN=usuarios.id_usuario union select bventasc.id_BventasC as venta,bventasc.id_cuentaN as cuenta,cuentas.descripcion as descu,alimentos.Descripcion as desi,bventasc.cantidadO as canti,bventasc.subtotalO as sub,usuarios.nombre as usi from bventasc,cuentas,ventas,alimentos,usuarios where bventasc.id_ventaN=ventas.id_venta and bventasc.id_cuentaN=cuentas.id_cuenta and bventasc.id_alimentoN=alimentos.id_alimento and bventasc.id_usuarioN=usuarios.id_usuario union select bventascb.id_ventaBN as venta,bventascb.id_cuentaN as cuenta,cuentas.descripcion as descu,bebidas.Descripcion as desi,bventascb.cantidadO as canti,bventascb.subtotalO as sub,usuarios.nombre as usi from bventascb,cuentas,ventasb,bebidas,usuarios where bventascb.id_ventaBN=ventasb.id_ventaB and bventascb.id_cuentaN=cuentas.id_cuenta and bventascb.id_bebidaN=bebidas.id_bebida and bventascb.id_usuarioN=usuarios.id_usuario and cuentas.fecha BETWEEN ('".$c."') and ('".$c2."') ORDER by cuenta asc;";

			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['venta']."</td><td>".$fila['cuenta']."</td><td>".$fila['descu']."</td><td>".$fila['desi']."</td><td>".$fila['canti']."</td><td>".$fila['sub']."</td><td>".$fila['usi']."</td></tr>";
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