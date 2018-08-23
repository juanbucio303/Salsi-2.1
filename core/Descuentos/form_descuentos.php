<div class="modal" id="modal_descuentos">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Agregar Descuento
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_descuentos">
						<input type="hidden" value="insert" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
					<div class="input-field">	
						<label for="Porce" id="p">Porcentaje</label>
						<input type="text" name="Porce" class="validate" placeholder="Porcentaje" id="Porce" >
					</div>	
				</form>			
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar">
				<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
		</div > 
	</div > 
</div >
<script>
	$("#modal_descuentos").modal();
	$("#modal_descuentos").modal('open');

	$("#aceptar").click(function()
	{
		$("#form_descuentos").submit();	
	});

	
	$("#form_descuentos").validate({
		errorClass: "invalid",
		rules:{
			Porce:{required:true,number:true,max:100,min:1,maxlength:2},
		},

		messages:{
			Porce:{
				required:"Es Necesario Ingresar un Porcentaje de Descuento",
				number:"Es Necesario que sea un valor numerico",
				max:"No puede Registrar un % mayor a 100",
				min:"No puede Registrar un % menor a 0",
				maxlength:"Esta excediendo el Porcentaje de Parametro permitido"
			},
		},

		submitHandler:function(form){
			$.post("core/Descuentos/controller_descuentos.php",$("#form_descuentos").serialize()
				,function(){
					get_all();
					$("#modal_descuentos").modal("close");
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
	#Porce-error{
		position: relative;
		color: red;
	}
	#p{
		position: relative;
	}
</style>