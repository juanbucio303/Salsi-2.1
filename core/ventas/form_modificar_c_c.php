<div class="modal" id="form_comple_c" style="width: 80%; height: 80%;"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Modificar Venta
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_modificar_c_u">

							<input type="hidden" value="modificar_com" id="action" name="action">
							<!-- se especifica el valor del value para que ejecute el case correspondiente-->

							<?php
							if(isset($_GET["id_venta"]))
								echo '<input value="'.$_GET["id_venta"].'"id="id_venta" name="id_venta" type="hidden">';
							?>

							<?php
								if(isset($_GET["id_cuenta"]))
									echo '<input value="'.$_GET["id_cuenta"].'"id="id_cuenta" name="id_cuenta" type="hidden">';
							?>
							<?php
								if(isset($_GET["id_locacion"]))
									echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
							?>
							<?php
							if(isset($_GET["id_tipo_l"]))
							echo '<input value="'.$_GET["id_tipo_l"].'"id="id_tipo_l" name="id_tipo_l" type="hidden">';
							?>
							<div class="input-field">
								<label for="Cu" id="cuen">Seleccione la nueva cuenta</label>
								<select value=""  class="validate" name="Cu" id="Cu" required>
									 
								</select>
								<br>
							</div>
				</form>
			</div>
				<div class="modal-footer"> 
					<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"> 
					<input  type="button" class="btn blue" id="VENDER" name="VENDER" value="Aceptar">
				</div >
		</div >  
</div >
<script type="text/javascript">
	var id_locacion=$("#id_locacion").val();
	get_all_cu(id_locacion);

	$("#form_comple_c").modal();
	$("#form_comple_c").modal('open');
	$("#VENDER").click(function(){
		$("#form_modificar_c_u").submit();

	});

	<?php
	if(isset($_GET["id_cuenta"]))
		{
?>
			$.post("core/ventas/controller_ventas.php",{action:"get_one_cuenta",id_cuenta:<?php echo $_GET["id_cuenta"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#Cu").val(dat["id_cuenta"]);
				$('select').material_select();
			});
<?php
		}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_modificar_c_u").validate({
		errorClass: "invalid",
		rules:{

			Cu:{required:true},
		},

		messages:{
			Cu:{
				required:"Es Necesario Seleccionar una cuenta"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#Modal_confirm_modificar").modal('open');
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_modificar").modal("close");
				$.post("core/ventas/controller_ventas.php",$("#form_modificar_c_u").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');
					get_all_v();
					get_all_tot();	
					get_all(<?php echo $_GET["id_tipo_l"];?>);

			});
			$("#form_comple_c").modal("close");
			$("#Modal_confirm_admi").modal('close');
			$("#modal_w").modal('close');
		});
	}
});

function get_all_cu(id_locacion){
			$.post("core/ventas/controller_ventas.php", {action:"get_all_cuenta",id_locacion:id_locacion}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Cuenta</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_cuenta"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#Cu").html(cod_html);
				$('select').material_select();
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
				 Seguro que desea realizar los cambios	
			</div>
			<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar">  
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
	#Cuen-error{
		position: relative;
		color: red;
	}
	#cuen{
		position: relative;
	}
</style>