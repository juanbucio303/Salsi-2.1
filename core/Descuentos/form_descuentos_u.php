<div class="modal" id="modal_descuentos_u">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Modificar Descuento
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_descuentos_u">
						<input type="hidden" value="update" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_descuento"]))
								echo '<input value="'.$_GET["id_descuento"].'"id="id_descuento" name="id_descuento" type="hidden">';
						?>
					<div class="input-field">	
						<label for="Porce" id="p">Porcentaje</label>
						<input type="text" name="Porce" class="validate" placeholder="Porcentaje" id="Porce" >
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
	$("#modal_descuentos_u").modal();
	$("#modal_descuentos_u").modal('open');

	$("#aceptar").click(function()
	{
		$("#form_descuentos_u").submit();	
	});

	<?php
	if(isset($_GET["id_descuento"]))
		{
?>
		$.post("core/Descuentos/controller_descuentos.php",{action:"get_one",id_descuento:
			<?php echo $_GET["id_descuento"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#Porce").val(dat["monto"]);
	});
<?php
		}
?>	

	$("#form_descuentos_u").validate({
		errorClass: "invalid",
		rules:{
			Porce:{required:true,number:true,max:100,min:0,maxlength:2},
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
			$("#Modal_confirm_modificar_d").modal();
			$("#Modal_confirm_modificar_d").modal('open');
				$("#btn_confirm_modificar_d").click(function(event){
					$("#Modal_confirm_modificar_d").modal("close");
					$.post("core/Descuentos/controller_descuentos.php", $('#form_descuentos_u').serialize(), function(){
				get_all();
				});
				$('#modal_descuentos_u').modal("close");
				});
		}
	});	
</script>
<div class="modal fade" id="Modal_confirm_modificar_d" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn blue" id="btn_confirm_modificar_d" value="Aceptar">

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
	#Porce-error{
		position: relative;
		color: red;
	}
	#p{
		position: relative;
	}
</style>