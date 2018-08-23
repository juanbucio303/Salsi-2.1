		<div class="modal-content" id="MoBcc"> 
			
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				Bitacoras de Complementos Cancelados
				</h4> 
			</div >
			<div class="modal-body">
				<div class="panel panel-default">
				<div class="panel-body">
				<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar">
				</div>
					<div class="panel-heading text-center">
						Bitacora de Complementos Cancelados
					</div>

					<div class="panel-body table-responsive">
							<table class="table">
							 	<tr>
							 		<th>Numero de venta</th>
							 		<th>Locacion</th>
							 		<th>Complemento</th>
							 		<th>Precio</th>
							 		<th>Cantidad</th>
							 		<th>Subtotal</th>
							 		<th>Fecha</th>
							 	</tr>
							 	<tbody id="content_table"></tbody>	
							 </table>
					</div>	
				</div>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar">  
			</div >
		</div > 
<script type="text/javascript">
$(".modal").modal();
$("#container_modal").modal('open');
get_all_Bcc();
function get_all_Bcc()
		{
			$.post("core/Consultas/controller_consulta.php",{action:"get_all_Bcc"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['id_complementoN']+"</td><td>"+info['id_locacion']+"</td><td>"+info['descripcion']+"</td><td>"+info['precio']+"</td><td>"+info['cantidad']+"</td><td>"+info['subtotal']+"</td><td>"+info['fecha']+"</td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_Bcc(consulta)
		{
			$.post("core/Consultas/controller_consulta.php",{action:"buscar_Bcc",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('keyup','#busc',function()
		{
				var da=$(this).val();
				if (da!="")
				{
					buscar_Bcc(da);
				}
				else
				{
					get_all_Bcc();
				}
		});
</script>