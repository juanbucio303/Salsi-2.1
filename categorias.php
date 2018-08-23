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
	<link rel="stylesheet" href="css/materialize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="fonts/icons/material-icons.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<title>Categorias</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#alerta").on("click",function(){
				get_all_i();
			});
			get_all();
			$("#add_categoria").click(function()
			{
				$("#container_modal").load("core/Categorias/form_categorias.php");
			});
/////////////////////////////////////////////////////////////////////////////////////
			$("#content_table").on("click","a.btn_eliminar",function(){
				$("#Modal_confirm_deleteCa").modal();
				$("#Modal_confirm_deleteCa").modal('open');
				$("#btn_confirm_deleteCa").data("id",$(this).data("id"));
			});
			$("#btn_confirm_deleteCa").click(function(event){
				var id_categoria_a=$(this).data("id");
				$.post("core/Categorias/controller_categorias.php",{action:'delete',id_categoria_a:id_categoria_a},
					function(){
						get_all();
						$("#Modal_confirm_deleteCa").modal('close');
					});
			});
/////////////////////////////////////////////////////////////////////////////////////		
			$("#content_table").on("click","a.btn_modificar",function(){
				var id_categoria_a=$(this).data("id");
				$("#container_modal").load("core/Categorias/form_categorias_u.php?id_categoria_a="+id_categoria_a);
			})

		});
////////////////////////////////////////////////////////////////////////////////////		
		function get_all()
		{

			$.post("core/Categorias/controller_categorias.php",{action:"get_all"},
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
						clase="ocupado";
					}	
					cod_html+="<tr class='"+clase+"'><td>"+info['descripcion']+"</td><td  class='centrado'><a class='waves-effect btn_eliminar' data-id= '"+info["id_categoria_a"]+"' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>cancel</span></a></td><td  class='centrado'><a class='waves-effect btn-flat btn_modificar' data-id='"+info["id_categoria_a"]+"' style='color: #1976d2'><span class='material-icons' style='margin-top: 0.2em'>edit</span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_d(consulta)
		{
			$.post("core/Categorias/controller_categorias.php",{action:"buscar",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('keyup','#busc',function()
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
		
		<div class="card-panel z-depth-3 grey lighten-2">
			<div class="container">
				<div class="input-field align-center">
					<input type="text" id="busc" name="busc"  placeholder="Buscar por Descripcion"><label for="busc">Buscar</label>
				</div>
				<div class="text-center"><a class="waves-effect waves-teal btn green tooltipped" data-position="right" data-tooltip="Agregar Categoria" style="width: 2em;height: 2em;padding: 0.2em;float: right;" id="add_categoria" ><span class="material-icons">add</span></a>
				<h4>Categorías</h4>
				</div>
					 <table class="table responsive-table bordered">
					 	<tr>
					 		<th>Descripcion</th>
					 		<th class='centrado'>Eliminar</th>
					 		<th class='centrado'>Editar</th>
					 	</tr>
					 	<tbody id="content_table"></tbody>
					 	
					 </table>
				</div>
		</div>
		<?php
			require_once("boton.php");
		?>
	</section>
	<aside id="container_modal">
  	</aside>

<div class="modal fade" id="Modal_confirm_deleteCa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				 Seguro que desea eliminar el registro		
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">  
				<input  type="button" class="btn blue" id="btn_confirm_deleteCa" value="Aceptar">
			</div > 
		</div > 
	</div>
</div>	
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