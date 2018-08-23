<div class="modal" id="modal_locaciones"> 
	<div class="modal-content"> 
		<div class="modal-header"> 
			<h4 class="modal-title" id="myModalLabel">
				Agregar Locaciones
			</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
		</div >
		<div class="modal-body">
			<form action="#!" method="post" id="form_locaciones">
					<input type="hidden" name="action" id="action" value="insert">
					<!-- se especifica el valor del value para que ejecute el case correspondiente-->
					
					<div class="input-field">
						<label for="NL">Numero de Locación</label>
						<input type="text" name="NL" class="form-control" id="NL" class="validate">
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
						<select name="TL" id="TL" required>
						<label for="TL">Descripcion</label>
						</select>
					</div>
					<?php
						}
					?>	
			</form>			
		</div>
		<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"></input>
				<input  type="button" class="btn waves-effect waves-teal blue" id="aceptar" value="Aceptar">
		</div>
	</div > 
</div >
<script>
	get_all_TL();
	$("#modal_locaciones").modal();
	$("#modal_locaciones").modal("open");
	$('select').formSelect();
	$("#aceptar").click(function()
	{
		$("#form_locaciones").submit();	
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
		});
	<?php
		}
	?>

	$("#form_locaciones").validate({
		errorClass: "invalid",
		rules:{
			NL:{required:true,number:true},
			TL:{required:true},
		},

		messages:{
			NL:{
				required:"Es Necesario Ingresar un Numero de Locacion",
				number:"Solo se pueden caracteres numericos"
			},
			TL:{
				required:"Es Necesario Ingresar un Tipo de Locacion"
			},
		},

		submitHandler:function(form){
			$.post("core/Locaciones/controller_locaciones.php",$("#form_locaciones").serialize()
				,function(){
					get_all(<?php echo $_GET["id_tipo_l"];?>);
					$("#modal_locaciones").modal("close");
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

			});
		}
</script>
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
</style>
