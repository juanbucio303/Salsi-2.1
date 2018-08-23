<div class="modal" id="modal_locaciones_u"> 
	<div class="modal-content"> 
		<div class="modal-header"> 
			<h4 class="modal-title" id="myModalLabel">
				Modificar Locacion
			</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
		</div >
		<div class="modal-body">
			<form action="#!" method="post" id="form_locaciones_u">
					<input type="hidden" name="action" value="update">
					<!-- se especifica el valor del value para que ejecute el case correspondiente-->
					<?php
						if(isset($_GET["id_locacion"]))
							echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
					?>
					
					<div class="input-field">
						<label for="NL" id="N">Numero de Locacion</label>
						<input type="text" name="NL" id="NL" class="validate">
					</div>
					
					<?php
						if(!isset($_GET["id_locacion"]))
						{
					?>
					<input type="hidden" name="tipo_l" value="<?php echo $_GET["id_tipo_l"]?>" id="tipo_l">
					<?php
						}else
						{
					?>

					<div class="input-field">
						<select name="TL" id="TL" required></select>
						<label for="TL">Descripcion</label>
					</div>
					<div>
						<select name="EST" id="EST" required>
							<option value="1">Activo</option>
							<option value="0">Fuera de Servicio</option>
						</select>
						<label for="EST">ESTADO</label>
					</div>
					
					<?php
						}
					?>	
			</form>			
		</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"></input>
				<input  type="button" class="btn waves-effect waves-teal blue"  id="aceptar" value="Aceptar">
			</div>
	</div > 
</div >
<script>
	get_all_TL();
	$("#modal_locaciones_u").modal();
	$("#modal_locaciones_u").modal("open");
	$('select').formSelect();
	$("#aceptar").click(function()
	{
		$("#form_locaciones_u").submit();	
	});

	<?php
		if(isset($_GET["id_locacion"]))
		{
	?>
		$.post("core/Locaciones/controller_locaciones.php",{action:"get_one",id_locacion:
			<?php echo $_GET["id_locacion"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#NL").val(dat["numero"]);
				$("#TL").val(dat["id_tipo_l"]);
				$("#EST").val(dat["estado"]);
				$('select').formSelect();
		});
	<?php
		}
	?>

	$("#form_locaciones_u").validate({
		errorClass: "invalid",
		rules:{
			NL:{required:true,number:true},
			TL:{required:true},
			EST:{required:true},
		},

		messages:{
			NL:{
				required:"Es Necesario Ingresar un Numero de Locacion",
				number:"Solo se pueden caracteres numericos"
			},
			TL:{
				required:"Es Necesario Ingresar un Tipo de Locacion"
			},
			EST:{
				required:"Por favor seleccione un estado"
			},
		},

		submitHandler: function(form){
				$("#Modal_confirm_modificar_u").modal();
				$("#Modal_confirm_modificar_u").modal("open");
				$("#btn_confirm_modificar_u").click(function(event){
					$("#Modal_confirm_modificar_u").modal("close");
					$.post("core/Locaciones/controller_locaciones.php", $('#form_locaciones_u').serialize(), function(){
					get_all(<?php echo $_GET["id_tipo_l"];?>);
				});
			$('#modal_locaciones_u').modal("close");
		});
	}
});		

	function get_all_TL(){
			$.post("core/Tipos_locaciones/controller_t_l.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona un Tipo de Locacion</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_tipo_l"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#TL").html(cod_html);
				$('select').formSelect();
			});
		}
</script>
<div class="modal fade" id="Modal_confirm_modificar_u"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div>
			<div class="modal-body">
				 <h6>¿Guardar cambios?</h6>	
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"></input> 
				<input  type="button" class="btn waves-effect waves-teal blue" id="btn_confirm_modificar_u" value="Aceptar">
			</div>
		</div>
</div>
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
	#NL-error{
		position: relative;
		color: red
	}
	#N{
		position: relative;
	}
</style>