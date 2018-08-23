<div class="modal" id="modal_proveedor">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Modificar Proveedor
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
					<form action="#!" method="post" id="form_proveedor">

								<input type="hidden" value="update" id="action" name="action" type="hidden">
								<!-- se especifica el valor del value para que ejecute el case correspondiente-->
								<?php
								if(isset($_GET["id_proveedor"]))
									echo '<input value="'.$_GET["id_proveedor"].'"id="id_proveedor" name="id_proveedor" type="hidden">';
								?>

					<div class="input-field">
						<label for="DES" id="D">Nombre del Proveedor</label>
						<input type="Text" placeholder="Nombre del Proveedor" class="validate" name="DES" id="DES" required>
						<br>
					</div>

					<div class="input-field">
						<label for="TEL" id="T">Telefono</label>
						<input type="Text" placeholder="Telefono" class="validate" name="TEL" id="TEL" required>
						<br>
					</div>

					<div class="input-field">
						<label for="CON" id="C">Nombre de Persona de Contacto</label>
						<input type="Text" placeholder="Nombre Completo" class="validate" name="CON" id="CON" required>
						<br>
					</div>

					<div class="input-field">
						<label for="EST" id="E">Estado</label>
						<select value=""  class="validate" name="EST" id="EST" required>
							 <option value="1">Activo</option>
      	          			 <option value="0">Desactivado</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
				<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
			</div >
		</div >  
</div >
<script type="text/javascript">
$('select').formSelect();	
$("#modal_proveedor").modal();
$("#modal_proveedor").modal('open');
	$("#aceptar").click(function(){
		$("#form_proveedor").submit();
	});

		<?php
			if(isset($_GET["id_proveedor"]))
				{
					?>
						$.post("core/Proveedores/controller_proveedores.php",{action:"get_one",id_proveedor:<?php echo $_GET["id_proveedor"]?>},function(res){
							var dat=JSON.parse(res);
							dat=dat[0];
							$("#DES").val(dat["descripcion"]);
							$("#TEL").val(dat["telefono"]);
							$("#CON").val(dat["contacto"]);
							$("#EST").val(dat["estado"]);
							$('select').formSelect();
					});
				<?php
			}
		?>

	
	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_proveedor").validate({
		errorClass: "invalid",
		rules:{
			DES:{required:true,validar_form:true},
			TEL:{required:true,number:true,maxlength:10,minlength:10},
			CON:{required:true,validar_form:true},
			EST:{required:true},
		},

		messages:{
			DES:{
				required:"Es Necesario Ingresar un Nombre al proveedor",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
			TEL:{
				required:"Es Necesario Ingresar un telefono",
				number:"Favor de ingresar un numero telefonico",
				maxlength:"El numero no puede tener mas de 10 digitos",
				minlength:"El numero no puede tener menos de 10 digitos",
			},
			CON:{
				required:"Es Necesario Ingresar una persona de contacto",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
			EST:{
				required:"Es Necesario seleccionar un valor",
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#Modal_confirm_modificar").modal('open');
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_modificar").modal("close");
			$.post("core/Proveedores/controller_proveedores.php",$("#form_proveedor").serialize()
				,function(){
					get_all();
				});
				$("#modal_proveedor").modal("close");
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
				 Seguro que desea modificar el registro	
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
	#DES-error,#TEL-error,#CON-error,#EST-error{
		position: relative;
		color: red;
	}
	#D,#T,#C,#E{
		position: relative;
	}
</style>