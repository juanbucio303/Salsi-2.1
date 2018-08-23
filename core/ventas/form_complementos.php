<div class="modal" id="modal_f_complementos">
	<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">
				Agregar Venta
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div>

			<div class="modal-body">
				<form action="#!" method="post" id="form_ventas_c">

						<input type="hidden" value="AGREGARC" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>
						<div class="row">
							<div class="col 6">
								<div class="input-field">
									<label for="DES" id="d">Descripcion</label>
									<input type="text" name="DES" id="DES" placeholder="Descripcion de producto" class="validate" required>
									<br>
								</div>
						  </div>
							<div class="col 6">
								<div class="input-field">
									<label for="PRE" id="p">Precio</label>
									<input type="number" name="PRE" id="PRE" placeholder="Precio" class="validate" required min="1" max="1000">
									<br>
								</div>
						  </div>
						</div>

						<div class="row">
							<div class="col 6">
								<div class="input-field">
									<label for="CAN" id="c">Cantidad</label>
									<input type="number" name="CAN" id="CAN" placeholder="Cantidad" class="validate" required min="1" max="1000">
									<br>
								</div>
							</div>
							<div class="col 6">
								<div class="input-field">
									<label for="Cu" id="cuen">Cuenta</label>
									<select value=""  class="validate" name="Cu" id="Cu" required>

									</select>
									<br>
								</div>

							</div>
						</div>


				</form>
			</div>
				<div class="modal-footer">
					<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
					<input  type="button" class="btn blue" id="VENDER" name="VENDER" value="Aceptar">
				</div >
	</div >
</div >
<script type="text/javascript">
	var id_locacion=$("#id_locacion").val();
	get_all_cu(id_locacion);

	$("#modal_f_complementos").modal();
	$("#modal_f_complementos").modal('open');

	$("#VENDER").click(function(){
		$("#form_ventas_c").submit();
	});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_ventas_c").validate({
		errorClass: "invalid",
		rules:{
			DES:{required:true,validar_form:true},
			PRE:{required:true,number:true},
			CAN:{required:true,number:true,max:99,min:1,maxlength:2},
			Cu:{required:true},
		},

		messages:{
			DES:{
				required:"Es Necesario Ingresar un Descripcion",
				validar_form:"No se permiten caracteres especiales"
			},
			PRE:{
				required:"Es Necesario Ingresar solo Numeros",
				number:"Solo se Permiten Numeros"
			},
			CAN:{
				required:"Es Necesario Ingresar una Cantidad",
				max:"No puede vender mas de 99 prodcutos",
				min:"No puede vender menos de un producto",
				maxlength:"Esta excediento la cantidad permitida para vender",
				number:"Solo se Permiten Numeros"
			},
			Cu:{
				required:"Es Necesario Selecionar una Cuenta"
			},
		},

		submitHandler:function(form){
			$.post("core/ventas/controller_ventas.php",$("#form_ventas_c").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');
					get_all_v();
					get_all_tot();
					$("#modal_f_complementos").modal("close");
				});
		}
	});

	function get_all_cu(id_locacion){
			$.post("core/ventas/controller_ventas.php", {action:"get_all_cuenta",id_locacion:id_locacion}, function(res){
				var datos=JSON.parse(res);
				var cod_html="";

				if (datos.length!=1) {
					cod_html="<option disabled='true' selected>Selecciona una Cuenta</option>";
					for (var i=0; i<datos.length;i++)
					{
						dat=datos[i];
						cod_html+="<option value='"+dat["id_cuenta"]+"'>"+dat["descripcion"]+"</option>";
					}
				}else {
					dat=datos[0];
					 cod_html="<option selected value='"+dat["id_cuenta"]+"'>"+dat["descripcion"]+"</option>";

				}
				$("#Cu").html(cod_html);
				$('select').material_select();
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
	#DES-error,#PRE-error,#CAN-error,#Cuen-error{
		position: relative;
		color: red;
	}
	#d,#p,#c,#cuen{
		position: relative;
	}
</style>
