<?php session_start();
	require_once("../conexion.php");
	switch ($_POST["action"]) 
	{
		case 'get_user':
			$sql="select *from usuarios where nombre='".$_POST["user"]."' and contraseña='".$_POST["password"]."';";
			$result=$conexion->query($sql);
			if($result->num_rows>0)
			{
				$datos=$result->fetch_assoc();
				$_SESSION["id_usuario"]=$datos["id_usuario"];
				$_SESSION["nombre"]=$datos["nombre"];
				$id_usuario=$datos["id_usuario"];
				$tu=$datos["id_role"];
				$_SESSION['id_usuario']=$id_usuario;
				
				
				if ($tu==1)
				{
					?>
					<script>
						window.location.href="alimentos.php";
					</script>
					<?php
				}
				else
				{
					?>
					<script>
						window.location.href="ventas.php";
					</script>
					<?php

					$sql="CALL INICIAR_S('".$id_usuario."');";
					$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
				}
			}
			else
			{
			?>
				<script>		
					M.toast({html:"<h5 style='color:#212121;'>El usuario y la contraseña es incorrecta</h5>", classes: 'rounded'});	
				</script>
			<?php
			}
		break;
		
		case "destruir":
			$sql="update prueba set id_usuario2='".$id_usuario3."' where id_usuario1='".$id_usuario3."';";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
			session_destroy();
		break;
	}
	$conexion->close();
 ?>