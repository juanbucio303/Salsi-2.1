<?php session_start();
if(!isset($_SESSION['id_usuario']))
	header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0"> 
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/materialize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="fonts/icons/material-icons.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<title>Surtido</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$('.datepicker').datepicker({
				format:'yyyy-mm-dd'
			});	
			$("#alerta").on("click",function(){
				get_all_i();
			});
			get_all();
			/*EJECUTA EL MODAL DEL FORMULARIO DE ALIMENTOS*/
			$("#add_entradas").click(function()
			{
				$("#container_modal").load("core/Existencias/form_existencias.php");
			});
//////////////////////////////////////////////////////////////////////////////////////		
			$("#content_table").on("click","a.btn_eliminar",function(){
				var estado=$(this).data("estado");
				if(estado==1)
				{
					$("#Modal_confirm_deleteV").modal();
					$("#Modal_confirm_deleteV").modal('open');
					$("#btn_confirm_deleteV").data("id",$(this).data("id"));
				}else{
					if(estado==3)
					{
						var id_entrada=$(this).data("id");
						$("#container_modal2").load("core/Existencias/form_liberar.php?id_entrada="+id_entrada);
					}
				}
			});

			$("#btn_confirm_deleteV").click(function(event){
				var id_entrada=$(this).data("id");
				$.post("core/Existencias/controller_existencias.php",{action:'LiberarE',id_entrada:id_entrada},
					function(res){
						var datos=JSON.parse(res);
						var info=datos[0];
						M.toast({html:"<h5 style='color:#212121;'>"+info[0]+"</h5>", classes: 'rounded'});
						get_all();
						$("#Modal_confirm_deleteV").modal('close');
					});
			});

			$("#rec").click(function(event){
				window.location.href="Existencias.php";
			});
		});	
////////////////////////////////////////////////////////////////////////////////////////////
		function get_all()
		{

			$.post("core/Existencias/controller_existencias.php",{action:"get_all"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					if(info["estado"]==1){
						clase="libre";
					}else{
						if(info["estado"]==3)
						{
							clase="caducado";
						}
					}
					cod_html+="<tr class='"+clase+"'><td>"+info['Descripcion']+"</td><td>"+info['cantidad_e']+"</td><td>"+info['fecha_e']+"</td><td>"+info['fecha_c']+"</td><td>"+info['descripcion']+"</td><td class='centrado'><a class='waves-effect btn_eliminar' data-id='"+info["id_entrada"]+"' data-estado='"+info["estado"]+"' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>lock</span></a></td></tr>";
					//se insertan los datos a la tabla
					"1" 
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_d(consulta)
		{
			$.post("core/Existencias/controller_existencias.php",{action:"buscar",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('change','#busc',function()
		{
				var da=$(this).val();
				if (da!="")
				{
					buscar_d(da);
				}
				else
				{
					get_all();
				}
		});
/////////////////////////////////////////////////////////////////////////////////////////////
	/*jQuery.validator.addMethod("validar_inp", function(value, element) {
 	 return this.optional(element) || /^[a-z ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#div_bus").validate({
		errorClass: "invalid",
		rules:{
			busc:{validar_inp:true},
		},

		messages:{
				busc:{
					validar_inp:"No se Permiten Caracteres Especiales"
			},
		},
	});*/			
	</script>
</head>
<body>
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<div style="background-color: #5C5757;" class="align-centerx">
		<?php
			require_once("menu.php");
		?>
	</div>
	<!--SECCION EN LA CUAL ESTA LA TABLA EN LA CUAL SE IMPRIMEN LOS DATOS DE LA CONSULTA SQL-->
	<section class="container">
		
		<div class="card-panel z-depth-3 grey lighten-2">
			<div class="container">
				<div class="input-field align-center">
					<input type="text" id="busc" name="busc" class="datepicker"  placeholder="Buscar por Fecha" style="width: 80%;">
					<label for="busc">Buscar</label>
					<a class="waves-effect waves-light btn" id="rec" style="position: relative; left: 10%;"><i class="material-icons right">refresh</i>Recargar</a>
				</div>
				<div class="text-center"><a class="waves-effect waves-teal btn green tooltipped" data-position="right" data-tooltip="Agregar Entrada" style="width: 2em;height: 2em;padding: 0.2em;float: right;" id="add_entradas"><span class="material-icons">add</span></a>
				<h4>Surtido</h4>
				</div>
					 <table class="table responsive-table bordered">
					 	<tr>
					 		<th>Ingrediente</th>
					 		<th>Cantidad</th>
					 		<th>Fecha de entrada</th>
					 		<th>Fecha de caducidad</th>
					 		<th>Proveedor</th>
					 		<th class='centrado'>Liberar</th>
					 	</tr>
					 	<tbody id="content_table"></tbody>
					 	
					 </table>
				</div>
				<?php
					require_once("boton.php");
				?>

	</section>
	<aside id="container_modal">
  	</aside>

<div class="modal fade" id="Modal_confirm_deleteV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >

			<div class="modal-body">
				 Seguro que desea Liberar la entrada	
			</div>

			<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
			<input  type="button" class="btn blue" id="btn_confirm_deleteV" value="Aceptar">
			</div>
		</div > 
	</div > 
</div >

	<aside id="container_modal2">
	</aside>
</body>
<style type="text/css">
	table tr:hover
	{
		background-color: lightgray;
	}
	table .centrado
	{
		text-align: center;
	}
	table tr td
	{
		padding: 0em;
	}
</style>
</html>