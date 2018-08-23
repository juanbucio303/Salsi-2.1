<div class="modal" id="modal_can" style="width: 80%; height: 80%;">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Liberar entrada
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_liberar">

						<input type="hidden" value="LiberarEC" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_entrada"]))
								echo '<input value="'.$_GET["id_entrada"].'" id="id_entrada" name="id_entrada" type="hidden">';
						?>
					<div class="input-field">
						<label for="Can" id="c">Cantidad</label>
						<input type="text" name="Can" id="Can" placeholder="Cantidad de Productos" class="form-control" required>
					</div>
				</form>
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
				<input  type="button" class="btn blue" id="Modificar"  value="Aceptar">
			</div >
		</div > 
</div >
<script type="text/javascript">

	$("#modal_can").modal();
	$("#modal_can").modal('open');

	$("#Modificar").click(function(){
		$("#form_liberar").submit();
	});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[1-9]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_liberar").validate({
		errorClass: "invalid",
		rules:{
			Can:{required:true,number:true},
		},

		messages:{
			Can:{
				required:"Es Necesario Ingresar una Cantidad",
				number:"Solo se Permiten Numeros"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#Modal_confirm_modificar").modal('open');
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_modificar").modal("close");
			$.post("core/Existencias/controller_existencias.php",$("#form_liberar").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var info=datos[0];
					M.toast({html:"<h5 style='color:#212121;'>"+info[0]+"</h5>", classes: 'rounded'});
					
				});	
			$("#modal_can").modal("close");
			});
			
		}
	});
	

</script>
<div class="modal fade" id="Modal_confirm_modificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				 Seguro que desea liberar la entrada	
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar"> 
				<input  type="button" class="btn blue" id="btn_confirm_modificar" value="Aceptar">

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
	#Can-error{
		position: relative;
		color: red;
	}
	#c{
		position: relative;
	}
</style>