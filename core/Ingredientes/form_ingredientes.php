<div class="modal" id="modal_ingrediente">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Agregar Ingrediente
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
					<form action="#!" method="post" id="form_ingrediente">

								<input type="hidden" value="insert" id="action" name="action" type="hidden">
								<!-- se especifica el valor del value para que ejecute el case correspondiente-->

					<div class="input-field">
						<label for="DES" id="D">Nombre del Ingrediente</label>
						<input type="Text" placeholder="Nombre del Ingrediente" class="validate" name="DES" id="DES" required>
						<br>
					</div>

					<div class="input-field">
						<label for="ME" id="M">Unidad de Medida</label>
						<select value=""  class="validate" name="ME" id="ME" required>
							 
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
				<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
			</div >
		</div >  
</div >
<script type="text/javascript">
get_all_m();	
$("#modal_ingrediente").modal();
$("#modal_ingrediente").modal('open');
	$("#aceptar").click(function(){
		$("#form_ingrediente").submit();
	});
	
	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_ingrediente").validate({
		errorClass: "invalid",
		rules:{
			DES:{required:true,validar_form:true},
			ME:{required:true},
		},

		messages:{
			DES:{
				required:"Es Necesario Ingresar un Nombre al proveedor",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
			ME:{
				required:"Es Necesario Ingresar una persona de contacto"
			},
		},

		submitHandler:function(form){
			$.post("core/Ingredientes/controller_ingredientes.php",$("#form_ingrediente").serialize()
				,function(){
					get_all();
					$("#modal_ingrediente").modal("close");
				});
		}
	});	

	function get_all_m(){
			$.post("core/Ingredientes/controller_ingredientes.php", {action:"get_m"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Unidad de Medida</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_medida"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#ME").html(cod_html);
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
	#DES-error,#ME-error{
		position: relative;
		color: red;
	}
	#D,#M{
		position: relative;
	}
</style>