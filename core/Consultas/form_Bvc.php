		<div class="modal-content" id="MoBc" style="width: 80%;> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				Bitacora de Ventas Canceladas
				</h4> 
			</div >
			<div class="modal-body">
				<div class="panel panel-default">
				<div class="panel-body">
				<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar">
				</div>
					<div class="panel-heading text-center">
						Bitacora de Ventas Canceladas
					</div>

					<div class="panel-body table-responsive">
							<table class="table">
							 	<tr>
							 		<th>Numero de venta</th>
							 		<th>Cantidad Cancelada</th>
							 		<th>Alimento Cancelado</th>
							 		<th>Subtotal Cancelado</th>
							 		<th>Locacion</th>
							 		<th>Fecha</th>
							 	</tr>
							 	<tbody id="content_table"></tbody>	
							 </table>
					</div>	
				</div>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"></input>  
			</div >
		</div > 
	</div > 
</div >
<script type="text/javascript">
$(".modal").modal();
$("#container_modal").modal('open');
get_all_Bvc();
function get_all_Bvc()
		{
			$.post("core/Consultas/controller_consulta.php",{action:"get_all_Bvc"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['id_ventaN']+"</td><td>"+info['cantidadN']+"</td><td>"+info['id_alimentoN']+"</td><td>"+info['subtotalN']+"</td><td>"+info['id_locacionN']+"</td><td>"+info['fecha']+"</td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_Bvc(consulta)
		{
			$.post("core/Consultas/controller_consulta.php",{action:"buscar_Bvc",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('keyup','#busc',function()
		{
				var da=$(this).val();
				if (da!="")
				{
					buscar_Bvc(da);
				}
				else
				{
					get_all_Bvc();
				}
		});
</script>
