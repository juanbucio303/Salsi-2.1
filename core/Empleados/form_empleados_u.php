<div class="modal" id="modal_empleado_u" style="width: 55%; height: 55%;">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Modificar Empleado
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_empleado_u">
						<input type="hidden" value="update" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_empleado"]))
								echo '<input value="'.$_GET["id_empleado"].'"id="id_empleado" name="id_empleado" type="hidden">';
						?>
					<div class="input-field">	
						<label for="nombre" id="n">Nombre</label>
						<input type="text" name="nombre" class="validate" placeholder="Nombre" id="nombre" required>
						<br>
					</div>	

					<div class="input-field">
						<label for="apellido_paterno" id="ap">Apellido Paterno</label>
						<input type="text" name="apellido_paterno" class="validate" placeholder="Apellido Paterno" id="apellido_paterno" required>
						<br>
					</div>	

					<div class="input-field">
						<label for="apellido_materno" id="am">Apellido Materno</label>
						<input type="text" name="apellido_materno" class="validate" placeholder="Apellido Materno" id="apellido_materno" required>
						<br>
					</div>	

					<div class="input-field">
						<label for="telefono" id="t">Telefono</label>
						<input type="text" name="telefono" class="validate" placeholder="telefono" id="telefono" required>
					</div>	
				</form>			
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar">
				<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
			</div>
		</div >  
</div >
<script type="text/javascript">
	$("#modal_empleado_u").modal();
	$("#modal_empleado_u").modal('open');
	$("#aceptar").click(function(){
		$("#form_empleado_u").submit();	
	});

<?php
	if(isset($_GET["id_empleado"]))
		{
			?>
				$.post("core/Empleados/controller_empleados.php",{action:"get_one",id_empleado:<?php echo $_GET["id_empleado"]?>},function(res){
						var dat=JSON.parse(res);
						dat=dat[0];
						$("#nombre").val(dat["nombre"]);
						$("#apellido_paterno").val(dat["ap"]);
						$("#apellido_materno").val(dat["am"]);
						$("#telefono").val(dat["telefono"]);

				});
			<?php
		}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_empleado_u").validate({
		errorClass: "invalid",
		rules:{
			nombre:{required:true,validar_form:true},
			apellido_paterno:{required:true,validar_form:true},
			apellido_materno:{required:true,validar_form:true},
			telefono:{required:true,maxlength:10,minlength:10,number:true},
		},

		messages:{
			nombre:{
				required:"Es Necesario Escribir un nombre"
			},
			apellido_paterno:{
				required:"Es Necesario Escribir un Apellido Paterno"
			},
			apellido_materno:{
				required:"Es Necesario Escribir un Apellido Materno"
			},
			telefono:{
				required:"Es Necesario Escribir un Numero de Telefono",
				maxlength:"El numero no puede tener mas de 10 digitos",
				minlength:"El numero no puede tener menos de 10 digitos",
				number:"Favor de ingresar un numero telefonico",
			},

		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar_e").modal();
			$("#Modal_confirm_modificar_e").modal('open');
				$("#btn_confirm_modificar_e").click(function(event){
					$("#Modal_confirm_modificar_e").modal("close");
					$.post("core/Empleados/controller_empleados.php", $('#form_empleado_u').serialize(), function(){
				get_all();
				});
				$('#modal_empleado_u').modal("close");
				});
		}
	});		
</script>
<div class="modal fade" id="Modal_confirm_modificar_e" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn blue" id="btn_confirm_modificar_e" value="Aceptar">

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
	#nombre-error,#apellido_paterno-error,#apellido_materno-error,#telefono-error{
		position: relative;
		color: red;
	}
	#n,#ap,#am,#t{
		position: relative;
	}
</style>