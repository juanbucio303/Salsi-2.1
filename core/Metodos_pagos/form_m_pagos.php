<div class="modal" id="modal_mp">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Agregar Metodo de Pago
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >

			<div class="modal-body">

				<form action="#!" method="post" id="form_mp">
						<input type="hidden" value="insert" id="action" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
					
					<div class="input-field">
						<label for="MP" id="m">Metodo de Pago</label>
						<input type="text" name="MP" class="validate" placeholder="Metodo de Pago" id="MP" required>
					</div>	
				</form>			
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar">
				<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
			</div > 
		</div >  
</div >
<script type="text/javascript">
	$("#modal_mp").modal();
	$("#modal_mp").modal('open');
	$("#aceptar").click(function(){
		$("#form_mp").submit();
	});


	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");
	$("#form_mp").validate({
		errorClass: "invalid",
		rules:{
			MP:{required:true,validar_form:true},
		},

		messages:{
			MP:{
				required:"Es Necesario Ingresar el Metodo de Pago"
			},
		},

		submitHandler:function(form){
			$.post("core/Metodos_pagos/controller_m_pagos.php",$("#form_mp").serialize()
				,function(){
					get_all();
					$("#modal_mp").modal("close");
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
	#MP-error{
		position: relative;
		color: red;
	}
	#m{
		position: relative;
	}
</style>