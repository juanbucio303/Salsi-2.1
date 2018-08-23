<div class="modal" id="modal_f" > 
	<div class="modal-content">
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Realizar Corte
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div>
			<div class="modal-body">
				<form action="#!" method="post" id="form_corte">

						<input type="hidden" value="CORTE" id="action" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>		
					<div class="input-field">
						<label for="Can">Cantidad Inicial</label>
						<input type="text" name="Can" id="Can" placeholder="Cantidad Inicial" class="validate" required>
						<br>
					</div>
				</form>
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
				<input type="button" class="btn blue" data-dismiss="modal" id="Corte" name="Corte" value="Registrar"> 
			</div >
	</div>		
</div >
<script type="text/javascript">
	$("#modal_f").modal();
	$("#modal_f").modal('open');
	$("#Corte").click(function()
	{
		$("#form_corte").submit();	
	});

	$("#form_corte").validate({
		errorClass: "invalid",
		rules:{
			Can:{required:true,number:true,min:0},
		},

		messages:{
			Can:{
				required:"Es Necesario Escribir una Cantidad Inicial",
				number:"Por favor de Escribir caracteres Numericos",
				min:"No puede iniciar con una cantidad menor a 0"

			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar_Ca").modal();
			$("#Modal_confirm_modificar_Ca").modal('open');
				$("#btn_confirm_modificar_Ca").click(function(event){
					$("#Modal_confirm_modificar_Ca").modal("close");
					$.post("core/ventas/controller_ventas.php", $('#form_corte').serialize(), function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					
					Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');				});
					$("#modal_f").modal("close");
				});
		}
	});	
</script>
<div class="modal fade" id="Modal_confirm_modificar_Ca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				 Seguro que desea realizar el corte	
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
				<input  type="button" class="btn blue" id="btn_confirm_modificar_Ca" value="Aceptar">
			</div > 
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
</style>
