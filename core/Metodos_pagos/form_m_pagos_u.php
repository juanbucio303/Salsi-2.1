<div class="modal" id="modal_mp_u"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Modificar Metodos de Pago
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >

			<div class="modal-body">

				<form action="#!" method="post" id="form_mp_u">
						<input type="hidden" value="update" id="action" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_mp"]))
								echo '<input value="'.$_GET["id_mp"].'"id="id_mp" name="id_mp" type="hidden">';
						?>
						
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
	$("#modal_mp_u").modal();
	$("#modal_mp_u").modal('open');
	$("#aceptar").click(function(){
		$("#form_mp_u").submit();
	});

	<?php
	if(isset($_GET["id_mp"]))
		{
?>
		$.post("core/Metodos_pagos/controller_m_pagos.php",{action:"get_one",id_mp:
			<?php echo $_GET["id_mp"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#MP").val(dat["descripcion"]);
	});
<?php
		}
?>	


	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_mp_u").validate({
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
			$("#Modal_confirm_modificar_Me").modal();
			$("#Modal_confirm_modificar_Me").modal('open');
				$("#btn_confirm_modificar_Me").click(function(event){
					$("#Modal_confirm_modificar_Me").modal("close");
					$.post("core/Metodos_pagos/controller_m_pagos.php", $('#form_mp_u').serialize(), function(){
				get_all();
				});
					$("#modal_mp_u").modal("close");
				});
		}
	});	
</script>
<div class="modal fade" id="Modal_confirm_modificar_Me" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn blue" id="btn_confirm_modificar_Me" value="Aceptar">
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
	#MP-error{
		position: relative;
		color: red;
	}
	#m{
		position: relative;
	}
</style>