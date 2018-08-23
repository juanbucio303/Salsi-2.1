<div class="modal" id="modal_proveedor">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Agregar Proveedor
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
					<form action="#!" method="post" id="form_proveedor">

								<input type="hidden" value="insert" id="action" name="action" type="hidden">
								<!-- se especifica el valor del value para que ejecute el case correspondiente-->

					<div class="input-field">
						<label for="DES" id="D">Nombre del Proveedor</label>
						<input type="Text" placeholder="Nombre del Proveedor" class="validate" name="DES" id="DES" required>
						<br>
					</div>

					<div class="input-field">
						<label for="TEL" id="T">Telefono</label>
						<input type="Text" placeholder="Telefono" class="validate" name="TEL" id="TEL" required>
						<br>
					</div>

					<div class="input-field">
						<label for="CON" id="C">Nombre de Persona de Contacto</label>
						<input type="Text" placeholder="Nombre Completo" class="validate" name="CON" id="CON" required>
						<br>
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
$("#modal_proveedor").modal();
$("#modal_proveedor").modal('open');
	$("#aceptar").click(function(){
		$("#form_proveedor").submit();
	});
	
	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_proveedor").validate({
		errorClass: "invalid",
		rules:{
			DES:{required:true,validar_form:true},
			TEL:{required:true,number:true,maxlength:10,minlength:10},
			CON:{required:true,validar_form:true},
		},

		messages:{
			DES:{
				required:"Es Necesario Ingresar un Nombre al proveedor",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
			TEL:{
				required:"Es Necesario Ingresar un telefono",
				number:"Favor de ingresar un numero telefonico",
				maxlength:"El numero no puede tener mas de 10 digitos",
				minlength:"El numero no puede tener menos de 10 digitos",
			},
			CON:{
				required:"Es Necesario Ingresar una persona de contacto",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
		},

		submitHandler:function(form){
			$.post("core/Proveedores/controller_proveedores.php",$("#form_proveedor").serialize()
				,function(){
					get_all();
					$("#modal_proveedor").modal("close");
				});
		}
	});	

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
	#DES-error,#TEL-error,#CON-error{
		position: relative;
		color: red;
	}
	#D,#T,#C{
		position: relative;
	}
</style>