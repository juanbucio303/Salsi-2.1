<?php session_start();
if(!isset($_SESSION['id_usuario']))
	header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0"> 
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/materialize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="fonts/icons/material-icons.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<title>Locaciones</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#alerta").on("click",function(){
				get_all_i();
			});
			get_tl();
			$("#cont_nav_tabs").on("click", "li a",function(){
				var id=$(this).data("id");
				get_all(id);
			});


//////////////////////////////AGREGAR LOCACIONES//////////////////////////////////////////			
			$("#cont_info_nav_tabs").on("click","#button_add",function()
			{
				var id_tipo_l=$(this).data("id_tipo_l");

				$("#container_modal").load("core/Locaciones/form_locaciones.php?id_tipo_l="+id_tipo_l);
			});
/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////ELIMINAR LOCACION///////////////////////////////////////////
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_eliminar",function(){
				$("#btn_confirm_deleteL").data("id",$(this).data("id"));
				$("#btn_confirm_deleteL").data("id_tipo_l",$(this).data("id_tipo_l"));

				$("#Modal_confirm_deleteL").modal();
				$("#Modal_confirm_deleteL").modal("open");
			});

			$("#btn_confirm_deleteL").click(function(event){
				var id_locacion=$(this).data("id");
				var id=$(this).data("id_tipo_l");
				$.post("core/Locaciones/controller_locaciones.php",{action:'delete',id_locacion:id_locacion},
					function(){
						get_all(id);
						$("#Modal_confirm_deleteL").modal("close");
					});
			});
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////MODIFICAR LOCACION////////////////////////////////////			
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_modificar",function(){
				var id_locacion=$(this).data("id");
				var id_tipo_l=$(this).data("id_tipo_l");

				$("#container_modal").load("core/Locaciones/form_locaciones_u.php?id_locacion="+id_locacion+"&id_tipo_l="+id_tipo_l);
			});

		});
///////////////////////////////////////////////////////////////////////////////////////
		function get_all(id_tipo_l)
		{
			$.post("core/Locaciones/controller_locaciones.php",{action:"get_all","id_tipo_l":id_tipo_l},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					if(info["estado"]==1){
							clase="mesa-libre";
						}
						else{
							clase="mesa-fueraser";
							}
							
					    cod_html+="<center><div id='div_loc' class='col s3 m3 l3'><div class='"+clase+"'><br/><label id='lbl_locacion'>Numero de locación: "+info["numero"]+"<br>Locacion: "+info["descripcion"]+"<center></label><div id='btn_div'>  <a href='#!' class='btn btn_modificar transparent btn-flat tooltipped' data-position='top' data-tooltip='Modificar Locacion' data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"'><span class='material-icons'>edit</span></a> <a href='#!' class='btn btn_eliminar transparent btn-flat tooltipped' data-position='top' data-tooltip='Eliminar Locacion' data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"'><span class='material-icons'>delete</span></a></div></div></center></div></center>";
				}
				$("#content_tab"+id_tipo_l).html(cod_html);	
				$('.tooltipped').tooltip();	
			});
		}
/////////////////////////////////////////////////////////////////////////////////////////////
		function get_tl()
		{
			$.post("core/Tipos_locaciones/controller_t_l.php",{action:"get_all"},
				function(res)
				{
					var datos=JSON.parse(res);
					var cod_title="";
					var cod_cont="";
					for (var i=0;i<datos.length;i++)
					{
						var info=datos[i];
						cod_title+="<li class='tab col s3'><a data-id='"+info["id_tipo_l"]+"' href='#target"+info["id_tipo_l"]+"'>"+info["descripcion"]+"</a><li>";

						cod_cont+="<div id='target"+info["id_tipo_l"]+"' class='col s12 card-panel grey lighten-2' style='padding: 1em;'><a class='waves-effect waves-teal btn green tooltipped' data-position='right' data-tooltip='Agregar Locacion' id='button_add' style='width: 2em;height: 2em;padding: 0.2em;float: right;' data-id_tipo_l='"+info["id_tipo_l"]+"'><span class='material-icons'>add</span></a><div><h5>Sección de "+info["descripcion"]+"</h5></div><div id='content_tab"+info["id_tipo_l"]+"'></div></div>";

						//el contenido del tipo de locación se pasó a la accion cuadno se haga clic en uno de los tabs
						$("#cont_info_nav_tabs").html(cod_cont);
							
					}
					$("#cont_nav_tabs").html(cod_title);
					//$("#cont_info_nav_tabs").html(cod_cont);
					//$('cont_nav_tabs.tabs.a:first').tabs('select_tab', 'show');
					/*Forma de inicializar el tab especifcando el contenedor y el primer hijo que sea a , con palabra select_tab y show*/
					get_all($('#cont_nav_tabs.tabs a:first').data("id"));
					/*Get all especificando que cargara la primera a con su respectivo data(id)*/
			$('.tabs').tabs();
			$('.tooltipped').tooltip();
				});
		}
		
//////////////////////////////////////////////////////////////////////////////////////////////
	</script>
</head>
<body>
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<div style="background-color: #5C5757;" class="align-centerx">
		<?php
			require_once("menu.php");
		?>
	</div>

	<section class="container">
		
		<div class="row">	
			<div class="col s12  card-panel">
				<ul id="cont_nav_tabs" class="tabs">
							
				</ul>
			</div>	
		</div>
		<div class="row" id="cont_info_nav_tabs">
		
		</div>
		<?php
			require_once("boton.php");
		?>
	</section>

	<aside id="container_modal">
	</aside>

	<aside id="container_modal2l">
	</aside>


<div class="modal" id="Modal_confirm_deleteL"> 
	<div class="modal-content"> 
		<div class="modal-header"> 
			<h4 class="modal-title" id="myModalLabel">
			</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
		</div >
		<div class="modal-body">
			 ¿Seguro que desea eliminar el registro?		
		</div>
		<div class="modal-footer"> 
		<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"></input> 
		<input  type="button" class="btn waves-effect waves-teal blue" id="btn_confirm_deleteL" value="Aceptar">
		</div > 
	</div > 
</div >
</body>
</html>