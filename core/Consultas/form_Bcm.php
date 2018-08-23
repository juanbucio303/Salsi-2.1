		<div class="modal-content" id="MoBcm" style="width: 80%;> 
			<div class="modal-header">  
				<h4 class="modal-title" id="myModalLabel">
				Bitacora de Complementos Modificados
				</h4> 
			</div >
			<div class="modal-body">
				<div class="panel panel-default">
				<div class="panel-body">
				<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar">
				</div>
					<div class="panel-heading text-center">
						Bitacora de Complementos Modificados
					</div>

					<div class="panel-body table-responsive">
							<table class="table">
							 	<tr>
							 		<th>Numero de Venta Extra</th>
							 		<th>Descripcion Nueva</th>
							 		<th>Antigua Descripcion</th>
							 		<th>Nuevo Precio</th>
							 		<th>Antiguo Precio</th>
							 		<th>Nueva Cantidad</th>
							 		<th>Antigua Cantidad</th>
							 		<th>Nuevo Subtotal</th>
							 		<th>Antiguo Subtotal</th>
							 		<th>Fecha</th>
							 	</tr>
							 	<tbody id="content_table"></tbody>	
							 </table>
					</div>	
				</div>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"></input>z  
			</div >
		</div > 
	</div > 
</div >
<script type="text/javascript">
$(".modal").modal();
$("#container_modal").modal('open');
get_all_Bcm();
function get_all_Bcm()
		{
			$.post("core/Consultas/controller_consulta.php",{action:"get_all_Bcm"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['id_complementoN']+"</td><td>"+info['descripcionN']+"</td><td>"+info['descripcionO']+"</td><td>"+info['precioN']+"</td><td>"+info['precioO']+"</td><td>"+info['cantidadN']+"</td><td>"+info["cantidadO"]+"</td><td>"+info["subtotalN"]+"</td><td>"+info["subtotalO"]+"</td><td>"+info["fecha"]+"</td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_Bcm(consulta)
		{
			$.post("core/Consultas/controller_consulta.php",{action:"buscar_Bcm",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('keyup','#busc',function()
		{
				var da=$(this).val();
				if (da!="")
				{
					buscar_Bcm(da);
				}
				else
				{
					get_all_Bcm();
				}
		});
</script>