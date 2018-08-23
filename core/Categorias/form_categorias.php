<div class="modal" id="modal_c">	
	<div class="modal-content"> 
		<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						Agregar Categoria de Alimento"
					</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
		</div >
		<div class="modal-body">
			<form action="#!" method="post" id="form_c_a">
							<input type="hidden" value="insert" name="action">
							<!-- se especifica el valor del value para que ejecute el case correspondiente-->
							
							<div class="input-field">
								<label for="CA" style="position: relative;">Categoria</label>	
								<input type="text" name="CA" class="form-control" placeholder="Categoria de Alimentos" id="CA" >
							</div>
							<div class="input-field">
								<label for="TC" id="t_c" style="position: relative;">Tipo de Categoria</label>
								<select value=""  class="validate" name="TC" id="TC" required>
									<option value="1">Alimentos</option>
									<option value="2">Bebidas</option>	 
								</select>
								<br>
							</div>
							
			</form>
		</div>
		<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar">  
			<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
		</div >
	</div > 
</div>	
<script>
$('select').formSelect();	
$("#modal_c").modal();
$("#modal_c").modal('open');

	$("#aceptar").click(function(){
		$("#form_c_a").submit();
	});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_c_a").validate({
		errorClass: "invalid",
		rules:{
			CA:{required:true,validar_form:true},
		},

		messages:{
			CA:{
				required:"Es Necesario Escribir Una Categoria de Alimento"
			},
		},

		submitHandler:function(form){
			$.post("core/Categorias/controller_categorias.php",$("#form_c_a").serialize()
				,function(){
					get_all();
					$("#modal_c").modal("close");
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
	#CA-error,#TC-error{
		position: relative;
		color: red
	}
	
</style>