	<div class="modal" id="modal_e">	
	<div class="modal-content"> 
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">
				Agregar Entrada
			</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
		</div >
				<div class="modal-body">
					<form action="#!" method="post" id="form_entradas">

								<input type="hidden" value="insert" id="action" name="action" type="hidden">
								<!-- se especifica el valor del value para que ejecute el case correspondiente-->


						<div class="input-field">
							<label for="Ing" style="position: relative;">Ingrediente</label>
							<select value=""  class="validate" name="Ing" id="Ing" required> 
							</select>
						</div>

						<div class="input-field">
							<label for="Pro" style="position: relative;">Proveedor</label>
							<select value=""  class="validate" name="Pro" id="Pro" required>	 
							</select>
						</div>

						<div class="input-field">
							<label for="Can" style="position: relative;"> Cantidad</label>
							<input type="Text" placeholder="Cantidad" class="form-control" name="Can" id="Can" required>
						</div>

						<div class="input-field">
							<label for="Fcc" style="position: relative;">Fecha de Caducidad</label>
							<input type="Text" placeholder="Fecha de caducidad" class="datepicker" name="Fcc" id="Fcc" required>
						</div>

					</form>
				</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"> 
				<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
			</div>
	</div > 
</div>	
<script type="text/javascript">
$('.datepicker').datepicker({
	format:'yyyy-mm-dd'
});	
get_all_i();
get_all_p();
$("#modal_e").modal();
$("#modal_e").modal('open');


$("#aceptar").click(function(){
		$("#form_entradas").submit();
		$("#container_modal").modal('close');
	});


	
	
	$("#form_entradas").validate({
		errorClass: "invalid",
		rules:{
			Ing:{required:true},
			Pro:{required:true},
			Can:{required:true,number:true,min:1},
			Fcc:{required:true},
			
		},

		messages:{
			Ing:{
				required:"Es Necesario Seleccionar una Categoria"
			},
			Pro:{
				required:"Es Necesario Seleccionar un Producto"
			},
			Can:{
				required:"Es Necesario Ingresar una Cantidad",
				min:"No puede Surtir  Menos de 1 unidad",
				number:"Es Necesario Ingresar caracteres numericos"
			},
			Fcc:{
				required:"Es Necesario Ingresar el Precio"
			},
			
		},

		submitHandler:function(form){
			$.post("core/Existencias/controller_existencias.php",$("#form_entradas").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var info=datos[0];
					M.toast({html:"<h5 style='color:#212121;'>"+info[0]+"</h5>", classes: 'rounded'});
					get_all();
					$("#modal_e").modal('close');
				});
		}
	});	

		function get_all_i(){
			$.post("core/Ingredientes/controller_ingredientes.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona el Ingrediente Principal</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_ingrediente"]+"'>"+dat["desi"]+"</option>";
				}
				$("#Ing").html(cod_html);
				$('select').formSelect();
			});
		}
		function get_all_p(){
			$.post("core/Proveedores/controller_proveedores.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona un Proveedor</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_proveedor"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#Pro").html(cod_html);
				$('select').formSelect();
			});
		}

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
	#Can-error,#Ing-error,#Pro-error,#Fcc-error{
		position: relative;
		color: red
	}
</style>