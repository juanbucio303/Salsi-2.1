<div class="modal" id="modal_t_l_u">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Modificar Tipo de Locacion
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_t_l_u">
						<input type="hidden" value="update" name="action" id="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_tipo_l"]))
								echo '<input value="'.$_GET["id_tipo_l"].'"id="id_tipo_l" name="id_tipo_l" type="hidden">';
						?>
					<div class="input-field">	
						<label for="TL" id="tl">Descripcion</label>
						<input type="text" name="TL" class="form-control" placeholder="Tipo de locacion" id="TL" >
					</div>	
				</form>			
			</div>
				<div class="modal-footer"> 
					<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"> 
					<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
				</div>
		</div >  
</div >
<script>
	$("#modal_t_l_u").modal();
	$("#modal_t_l_u").modal('open');
	$("#aceptar").click(function()
	{
		$("#form_t_l_u").submit();
	});

	<?php
		if(isset($_GET["id_tipo_l"]))
		{
	?>
		$.post("core/Tipos_locaciones/controller_t_l.php",{action:"get_one",id_tipo_l:
			<?php echo $_GET["id_tipo_l"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#TL").val(dat["descripcion"]);
	});
	<?php
		}
	?>		

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");
	$("#form_t_l_u").validate({
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
			$("#Modal_confirm_modificar_tl").modal();
			$("#Modal_confirm_modificar_tl").modal('open');
				$("#btn_confirm_modificar_tl").click(function(event){
					$("#Modal_confirm_modificar_tl").modal("close");
					$.post("core/Tipos_locaciones/controller_t_l.php", $('#form_t_l_u').serialize(), function(){
				get_all();
				});
					$("#modal_t_l_u").modal("close");
				});
		}
	});	
</script>
<div class="modal fade" id="Modal_confirm_modificar_tl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				 Seguro que desea modificar sus datos	
			</div>
			<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar">  
			<input  type="button" class="btn blue" id="btn_confirm_modificar_tl" value="Aceptar">

		</div > 
	</div > 
</div >
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