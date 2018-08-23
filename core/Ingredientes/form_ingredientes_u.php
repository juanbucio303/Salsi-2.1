<div class="modal" id="modal_ingrediente">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Modificar Ingrediente
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
					<form action="#!" method="post" id="form_ingrediente">

								<input type="hidden" value="update" id="action" name="action" type="hidden">
								<!-- se especifica el valor del value para que ejecute el case correspondiente-->

								<?php
								if(isset($_GET["id_ingrediente"]))
									echo '<input value="'.$_GET["id_ingrediente"].'"id="id_ingrediente" name="id_ingrediente" type="hidden">';
								?>

					<div class="input-field">
						<label for="DES" id="D">Nombre del Ingrediente</label>
						<input type="Text" placeholder="Nombre del Ingrediente" class="validate" name="DES" id="DES" required>
						<br>
					</div>

					<div class="input-field">
						<label for="ME" id="M">Unidad de Medida</label>
						<select value=""  class="validate" name="ME" id="ME" required>
							 
						</select>
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
get_all_m();	
$("#modal_ingrediente").modal();
$("#modal_ingrediente").modal('open');
	$("#aceptar").click(function(){
		$("#form_ingrediente").submit();
	});
	<?php
			if(isset($_GET["id_ingrediente"]))
				{
					?>
						$.post("core/Ingredientes/controller_ingredientes.php",{action:"get_one",id_ingrediente:<?php echo $_GET["id_ingrediente"]?>},function(res){
							var dat=JSON.parse(res);
							dat=dat[0];
							$("#DES").val(dat["Descripcion"]);
							$("#ME").val(dat["id_medida"]);
							$("#EST").val(dat["estado"]);
							$('select').formSelect();
					});
				<?php
			}
		?>
	
	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_ingrediente").validate({
		errorClass: "invalid",
		rules:{
			DES:{required:true,validar_form:true},
			ME:{required:true},
			EST:{required:true},
		},

		messages:{
			DES:{
				required:"Es Necesario Ingresar un Nombre al proveedor",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
			ME:{
				required:"Es Necesario Ingresar una persona de contacto"
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
			$.post("core/Ingredientes/controller_ingredientes.php",$("#form_ingrediente").serialize()
				,function(){
					get_all();
					$("#modal_ingrediente").modal("close");
				});
				$("#modal_proveedor").modal("close");
			});
		}
	});	

	function get_all_m(){
			$.post("core/Ingredientes/controller_ingredientes.php", {action:"get_m"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Unidad de Medida</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_medida"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#ME").html(cod_html);
				$('select').formSelect();
			});
		}

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
	#DES-error,#ME-error,#EST-error{
		position: relative;
		color: red;
	}
	#D,#M,#E{
		position: relative;
	}
</style>