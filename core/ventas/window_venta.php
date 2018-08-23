<div class="modal" id="modal_w" style="width: 80%; height: 80%;">
				<div class="modal-content" id="MoBcc">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">
						Catalogo de Ventas
						</h4>
					</div >
					<div class="modal-body">
						<div class="panel panel-default">

							<div class="panel-heading">
								<a class="btn waves-effect waves-teal btn green modal-trigger tooltipped"  data-position="top" data-delay="50" data-tooltip="Ventas de Menu" id="add_ventas" data-id_locacion="<?php echo $_GET["id_locacion"];?>"><span class="material-icons">local_pizza</span></a>

								<a class="btn waves-effect waves-teal btn green modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Ventas fuera de Menu" id="add_ventas_c" data-id_locacion="<?php echo $_GET["id_locacion"];?>"><span class="material-icons">local_dining</span></a>

								<a class="btn waves-effect waves-teal btn green modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Ventas de Bebidas" id="add_ventas_b" data-id_locacion="<?php echo $_GET["id_locacion"];?>"><span class="material-icons">local_bar</span></a>

								<a class="btn waves-effect waves-teal btn green modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Añadir cuenta" id="add_cuenta" data-id_locacion="<?php echo $_GET["id_locacion"];?>"><span class="material-icons">add</span></a>

								<a class="btn waves-effect waves-teal btn green modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Liberar locacion" id="clear_loc" data-id_locacion="<?php echo $_GET["id_locacion"];?>"><span class="material-icons">lock_open</span></a>
							</div>

							<div class="panel">
								<table class="table responsive-table bordered">
								 	<tr>
								 		<th>Producto</th>
								 		<th>Precio Unitario</th>
								 		<th>Cantidad</th>
								 		<th>Subtotal</th>
								 		<th>Numero de Cuenta</th>
								 		<th class="centrado">Cancelaciones</th>
								 		<th class="centrado">Editar Cuenta</th>
								 	</tr>
								 	<tbody id="content_table"></tbody>
								 </table>
								 <!--AQUI SE INSERTA EL LABEL DEL TOTAL GENERAL QUE SE ESTA VENDIENDO-->
								 <div id="tot"></div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
						<?php
								if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';

								if(isset($_GET["id_tipo_l"]))
								echo '<input value="'.$_GET["id_tipo_l"].'"id="id_tipo_l" name="id_tipo_l" type="hidden">';

								if(isset($_GET["id_ticket"]))
								echo '<input value="'.$_GET["id_ticket"].'"id="id_ticket" name="id_ticket" type="hidden">';
						?>
					</div >
				</div >
</div >



<aside id="container_modal_f">
</aside>

<aside class="modal" id="container_modal">
</aside>

<div class="modal fade" id="Modal_confirm_c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >

			<div class="modal-body">
				 Seguro que desea agregar otra cuenta
			</div>

			<div class="modal-footer">
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
			<input  type="button" class="btn blue" id="btn_confirm_c" value="Aceptar">
			</div>
		</div >
	</div >
</div >

<script type="text/javascript">
$(document).ready(function(){
	$('.tooltipped').tooltip({delay: 50});
	get_all_v();
	get_all_tot();

	$("#modal_w").modal();
	$("#modal_w").modal('open');

	$("#add_ventas").click(function(){
		var id_locacion=$(this).data("id_locacion");
		$("#container_modal_f").load("core/ventas/form_ventas.php?id_locacion="+id_locacion);
	});

	$("#add_ventas_b").click(function(){
		var id_locacion=$(this).data("id_locacion");
		$("#container_modal_f").load("core/ventas/form_ventas_b.php?id_locacion="+id_locacion);
	});

	$("#add_ventas_c").click(function(){
		var id_locacion=$(this).data("id_locacion");
		$("#container_modal_f").load("core/ventas/form_complementos.php?id_locacion="+id_locacion);
	});

	$("#add_cuenta").click(function(){
		$("#Modal_confirm_c").modal();
		$("#Modal_confirm_c").modal('open');
		$("#btn_confirm_c").data("id_locacion",$(this).data("id_locacion"));
	});

	$("#btn_confirm_c").click(function(event){
			var id_locacion=$(this).data("id_locacion");
			$.post("core/ventas/controller_ventas.php",{action:'ADD_C',id_locacion:id_locacion},
					function(res){
						var datos=JSON.parse(res);
						var info=datos[0];
						Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');
						get_all_v();
						get_all_tot();
					});
			$("#Modal_confirm_c").modal('close');
		});

	$("#clear_loc").click(function(){
		var id_locacion=$(this).data("id_locacion");
		var id_tipo_l=$("#id_tipo_l").val();
		$.post("core/ventas/controller_ventas.php",{action:'CLEAR_L',id_locacion:id_locacion},
					function(res){
						var datos=JSON.parse(res);
						var info=datos[0];
						Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');
						get_all_v();
						get_all_tot();
						get_all(id_tipo_l);
						$("#modal_w").modal('close');
					});
	});

////////////////////////////////////////////////////////////////////////
	$("#content_table").on("click","a.btn_eliminar",function(){
			var tipo_v=$(this).data("id_tipo_v");
			if(tipo_v==1)
			{
				var id_venta=$(this).data("id");
				var id_cuenta=$(this).data("id_cuenta");
				var id_alimento=$(this).data("id_alimento");
				var id_tipo_l=$("#id_tipo_l").val();


				$("#container_modal_f").load("core/ventas/form_cancelaciones_v.php?id_venta="+id_venta+"&id_cuenta="+id_cuenta+"&id_alimento="+id_alimento+"&id_tipo_l="+id_tipo_l);
			}else{
				if(tipo_v==2)
				{
					var id_venta=$(this).data("id");
					var id_cuenta=$(this).data("id_cuenta");
					var id_tipo_l=$("#id_tipo_l").val();

					$("#container_modal_f").load("core/ventas/form_cancelaciones_c.php?id_venta="+id_venta+"&id_cuenta="+id_cuenta+"&id_tipo_l="+id_tipo_l);
				}else{
					if(tipo_v==3)
					{
						var id_venta=$(this).data("id");
						var id_cuenta=$(this).data("id_cuenta");
						var id_alimento=$(this).data("id_alimento");
						var id_tipo_l=$("#id_tipo_l").val();

						$("#container_modal_f").load("core/ventas/form_cancelaciones_b.php?id_venta="+id_venta+"&id_cuenta="+id_cuenta+"&id_alimento="+id_alimento+"&id_tipo_l="+id_tipo_l);
					}
				}
			}

	});
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
	$("#content_table").on("click","a.btn_modificar",function(){
			var tipo_v=$(this).data("id_tipo_v");

			if(tipo_v==1)
			{
				var id_venta=$(this).data("id");
				var id_cuenta=$(this).data("id_cuenta");
				var id_alimento=$(this).data("id_alimento");
				var id_tipo_l=$("#id_tipo_l").val();
				var id_locacion=$("#id_locacion").val();


				$("#container_modal_f").load("core/ventas/form_modificar_v.php?id_venta="+id_venta+"&id_cuenta="+id_cuenta+"&id_alimento="+id_alimento+"&id_tipo_l="+id_tipo_l+"&id_locacion="+id_locacion);
			}else{
				if(tipo_v==2)
				{
					var id_venta=$(this).data("id");
					var id_cuenta=$(this).data("id_cuenta");
					var id_tipo_l=$("#id_tipo_l").val();
					var id_locacion=$("#id_locacion").val();

					$("#container_modal_f").load("core/ventas/form_modificar_c_c.php?id_venta="+id_venta+"&id_cuenta="+id_cuenta+"&id_tipo_l="+id_tipo_l+"&id_locacion="+id_locacion);
				}else{
					if(tipo_v==3)
					{
						var id_venta=$(this).data("id");
						var id_cuenta=$(this).data("id_cuenta");
						var id_alimento=$(this).data("id_alimento");
						var id_tipo_l=$("#id_tipo_l").val();
						var id_locacion=$("#id_locacion").val();

						$("#container_modal_f").load("core/ventas/form_modificar_v_b.php?id_venta="+id_venta+"&id_cuenta="+id_cuenta+"&id_alimento="+id_alimento+"&id_tipo_l="+id_tipo_l+"&id_locacion="+id_locacion);

					}
				}
			}

	});
////////////////////////////////////////////////////////////////////////
});

<?php
	if(isset($_GET["id_locacion"]))
	{
?>
function get_all_v()
{
	$.post("core/ventas/controller_ventas.php",{action:"get_all_ven",id_locacion:<?php echo $_GET["id_locacion"];?>,id_ticket:<?php echo $_GET["id_ticket"];?>},
		function(res){
			var datos=JSON.parse(res);
			var cod_html="";
			for (var i=0;i<datos.length;i++)
			{
				var info=datos[i];
				cod_html+="<tr><td>"+info['descripcion']+"</td><td>"+info['precio']+"</td><td>"+info['cantidad']+"</td><td>"+info['subtotal']+"</td><td>"+info['cuentas']+"</td><td><a class='waves-effect btn-flat  btn_eliminar' data-id='"+info["id_venta"]+"' data-id_cuenta='"+info["id_cuenta"]+"' data-id_alimento='"+info["id_alimento"]+"' data-id_tipo_v='"+info["tipo_v"]+"' style='color: #ef5350'><span class='material-icons'>cancel</span></a></td><td><a class='waves-effect btn-flat  btn_modificar' data-id='"+info["id_venta"]+"' data-id_cuenta='"+info["id_cuenta"]+"' data-id_alimento='"+info["id_alimento"]+"' data-id_tipo_v='"+info["tipo_v"]+"' style='color: #1976d2'><span class='material-icons'>edit</span></a></td></tr>"
			}
			$("#content_table").html(cod_html);
		});
}

function get_all_tot()
{
	$.post("core/ventas/controller_ventas.php",{action:"cuenta",id_ticket:<?php echo $_GET["id_ticket"];?>},
		function(result)
		{
			var datos=JSON.parse(result);
			var cod="";
			datos=datos[0];
			cod="<h5><label style='color:black; font-size:1em;'>El total al momento es: "+datos[0]+"</lable></h5>";

			$("#tot").html(cod);
		});
}
<?php
	}
?>
</script>
<style type="text/css">
	input-field.select-dropdown
	{
		color: black;
		overflow-y: visible;
		border-radius: 3px;
		margin-top: 4em;
	}
	input-field.dropdown-content{
		color: black;
		overflow-y: visible;
		border-radius: 3px;
		margin-top: 4em;
	}
	#SEG-error{
		position: relative;
		color: red;
	}
	#s{
		position: relative;
	}
</style>
