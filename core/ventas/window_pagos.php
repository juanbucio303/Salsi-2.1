<div class="modal" id="modal_p" style="width: 80%; height: 80%;">	
				<div class="modal-content" id="MoBcc"> 
					<div class="modal-header"> 
						<h4 class="modal-title" id="myModalLabel">
						Catalago de Pago
						</h4> 
					</div >
					<div class="modal-body">
						<div class="panel panel-default">
								
							<div class="panel">
								<table class="table responsive-table bordered">
								 	<tr>
								 		<th>Numero de Cuenta</th>
								 		<th>Subtotal</th>
								 		<th class='centrado'>Pagar</th>
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

						<input type="hidden" value="<?php echo isset($_GET["id_ticket"])?"call_p":"insert"; ?>" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_ticket"]))
								echo '<input value="'.$_GET["id_ticket"].'"id="id_ticket" name="id_ticket" type="hidden">';
						?>
						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>
						<?php
							if(isset($_GET["id_tipo_l"]))
								echo '<input value="'.$_GET["id_tipo_l"].'"id="id_tipo_l" name="id_tipo_l" type="hidden">';
						?>
					</div >
				</div > 

</div > 
<aside id="container_modal_f">
</aside>

<script type="text/javascript">
	$(document).ready(function(){

		get_all_cuenta();

		$("#modal_p").modal();	
		$("#modal_p").modal('open');

		$("#content_table").on("click","a.btn_pagar_c",function(){
			var id_cuenta=$(this).data("id_cuenta");
			var id_ticket=$(this).data("id_ticket");
			var id_tipo_l=$("#id_tipo_l").val();
						
			$("#container_modal_f").load("core/ventas/form_pago.php?id_cuenta="+id_cuenta+"&id_ticket="+id_ticket+"&id_tipo_l="+id_tipo_l);			
		});	

	});

	function get_all_cuenta()
	{
		$.post("core/ventas/controller_ventas.php",{action:"get_all_c",id_ticket:<?php echo $_GET["id_ticket"];?>}, 
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++)
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['descripcion']+"</td><td>"+info['subtotal']+"</td><td><a href='#!' class='btn btn_pagar_c transparent btn-flat' data-id_cuenta='"+info["id_cuenta"]+"' data-id_ticket='"+info["id_ticket"]+"'><span class='material-icons'>attach_money</span></a></td></tr>"
				}
				$("#content_table").html(cod_html);
			});
	}
</script>