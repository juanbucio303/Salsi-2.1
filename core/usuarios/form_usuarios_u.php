<div class="modal" id="modal_usuarios_u"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Modificar Usuario
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_usuarios_u">

							<input type="hidden" value="update" id="action" name="action">
							<!-- se especifica el valor del value para que ejecute el case correspondiente-->

							<?php
								if(isset($_GET["id_usuario"]))
									echo '<input value="'.$_GET["id_usuario"].'"id="id_usuario" name="id_usuario" type="hidden">';
							?>

					<div class="input-field">
						<label for="NU" id="n">Nombre de Usuario</label>
						<input type="Text" placeholder="Nombre de Usuario" class="validate" name="NU" id="NU" required>
						<br>
					</div>

					<div class="input-field">
						<label for="Con" id="c">Contraseña</label>
						<input type="Text" placeholder="Contraseña" class="validate" name="Con" id="Con" required>
						<br>
					</div>

					<div class="input-field">
						<label for="RO" id="r">Tipo de Usuario</label>
						<select value=""  class="validate" name="RO" id="RO" required>
							 
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
</div >
<script type="text/javascript">
get_all_ro();
$("#modal_usuarios_u").modal();
$("#modal_usuarios_u").modal('open');
	$("#aceptar").click(function(){
		$("#form_usuarios_u").submit();
	});
	
	<?php
	if(isset($_GET["id_usuario"]))
		{
			?>
				$.post("core/usuarios/controller_usuarios.php",{action:"get_one",id_usuario:<?php echo $_GET["id_usuario"]?>},function(res){
					var dat=JSON.parse(res);
					dat=dat[0];
					$("#NU").val(dat["nombre"]);
					$("#Con").val(dat["contraseña"]);
					$("#RO").val(dat["id_role"]);
					$('select').formSelect();
			});
		<?php
	}
?>	



	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_usuarios_u").validate({
		errorClass: "invalid",
		rules:{
			NU:{required:true,validar_form:true},
			Con:{required:true,validar_form:true},
			RO:{required:true},
		},

		messages:{
			NU:{
				required:"Es Necesario Ingresar un Nombre de Usuario",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
			Con:{
				required:"Es Necesario Ingresar una Contraseña",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
			RO:{
				required:"Es Necesario Seleccionar un Tipo de Usuario"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#Modal_confirm_modificar").modal('open');
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_modificar").modal("close");
				$.post("core/usuarios/controller_usuarios.php",$("#form_usuarios_u").
					serialize(),function(){
					get_all();
					});
					$("#modal_usuarios_u").modal("close");
				});
		}
	});	




	function get_all_ro(){
			$.post("core/role/controller_role.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Tipo de Usuario</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_role"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#RO").html(cod_html);
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
				 Seguro que desea modificar sus datos	
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
	#NU-error,#Con-error,#RO-error{
		position: relative;
		color: red;
	}
	#n,#c,#r{
		position: relative;
	}
</style>