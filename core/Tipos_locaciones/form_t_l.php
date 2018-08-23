<div class="modal" id="modal_t_l">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Agregar Tipo de Locacion
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
				<div class="modal-body">
					<form action="#!" method="post" id="form_t_l">
							<input type="hidden" value="insert" name="action" id="action">
							<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<div class="input-field">	
							<label for="TL" id="tl">Descripcion</label>
							<input type="text" name="TL" class="form-control" placeholder="Tipo de locacion" id="TL" >
						</div>	
					</form>			
				</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"></input> 
				<input  type="button" class="btn blue" id="aceptar_tl" value="Aceptar">

			</div > 
		</div > 
</div >
<script>
	$("#modal_t_l").modal();
	$("#modal_t_l").modal('open');
	$("#aceptar_tl").click(function()
	{
		$("#form_t_l").submit();
	});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_t_l").validate({
		errorClass: "invalid",
		rules:{
			TL:{required:true,validar_form:true},
		},

		messages:{
			TL:{
				required:"Es Necesario Ingresar un Tipo de Locacion"
			},
		},

		submitHandler:function(form){
			$.post("core/Tipos_locaciones/controller_t_l.php",$("#form_t_l").serialize()
				,function(){
					get_all();
					$("#modal_t_l").modal("close");
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
	#TL-error{
		position: relative;
		color: red;
	}
	#tl{
		position: relative;
	}
</style>