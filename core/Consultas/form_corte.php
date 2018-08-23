		<div class="modal-content" id="MoBv" style="width: 100%; height: 80%;"> 
			<div class="modal-header">  
				<h4 class="modal-title" id="myModalLabel">
				Bitacora de Corte
				</h4> 
			</div >
			<div class="modal-body">
				<div class="panel panel-default">
					<div class="panel-body">
						<input type="text" id="busc" name="busc" class="datepicker"  placeholder="Buscar por Fecha" style="width: 60%;">
						<label for="busc">Buscar</label>
						<a class="waves-effect waves-light btn" id="rec" style="position: relative; left: 10%;"><i class="material-icons right">refresh</i>Recargar</a>
					</div>
					<div class="row">
						<div class="panel-body table-responsive">
							<table class="table responsive-table bordered">
							 	<tr>
							 		<th>Numero de Bitacora</th>
							 		<th>Fecha de Incio</th>
							 		<th>Fecha de corte</th>
							 		<th>Usuario</th>
							 		<th>Generar PDF</th>
							 	</tr>
							 	<tbody id="content_table"></tbody>	
							 </table>
						</div>
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
$(document).ready(function(){
	get_all_corte();
	$('.datepicker').datepicker({
				format:'yyyy-mm-dd'
			});	

			$("#content_table").on("click","a.btn_pdf", function(){	
				var id=$(this).data("id");
				var fi=$(this).data("fi");
				var fc=$(this).data("fc");

				var id_corte=JSON.stringify(id);
				var fecha_inicio=JSON.stringify(fi);
				var fecha_corte=JSON.stringify(fc);
				window.open("core/Consultas/Consulta_corte.php?id_corte="+id_corte+"&fecha_inicio="+fecha_inicio+"&fecha_corte="+fecha_corte);
			});

			$("#rec").click(function(event){
				get_all_corte();
			});
});

function get_all_corte()
		{
			$.post("core/Consultas/controller_consulta.php",{action:"get_all_Corte"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['id_bitacora']+"</td><td>"+info['fecha_inicio']+"</td><td>"+info['fecha_corte']+"</td><td>"+info['nombre']+"</td><td class='centrado'><a class='waves-effect btn-flat btn_pdf' data-id='"+info["id_bitacora"]+"' data-fi='"+info["fecha_inicio"]+"' data-fc='"+info["fecha_corte"]+"' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>print</span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_corte(consulta)
		{
			$.post("core/Consultas/controller_consulta.php",{action:"buscar_corte",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('change','#busc',function()
		{
				var da=$(this).val();
				if (da!="")
				{
					buscar_corte(da);
				}
				else
				{
					get_all_corte();
				}
		});

</script>