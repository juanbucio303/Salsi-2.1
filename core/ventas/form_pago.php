<div class="modal" id="modal_pago" style="width: 80%; height: 80%;">	
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Pagar Cuenta
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_pagos">

						<input type="hidden" value="PAGO_C" id="action" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_cuenta"]))
								echo '<input value="'.$_GET["id_cuenta"].'" id="id_cuenta" name="id_cuenta" type="hidden">';
						?>
						
						<?php
							if(isset($_GET["id_ticket"]))
								echo '<input value="'.$_GET["id_ticket"].'" id="id_ticket" name="id_ticket" type="hidden">';
						?>

						<?php
							if(isset($_GET["id_tipo_l"]))
								echo '<input value="'.$_GET["id_tipo_l"].'" id="id_tipo_l" name="id_tipo_l" type="hidden">';
						?>
				
					<div class="input-field">	
						<label for="DES" id="d">Descuento</label>
						<select value=""  class="validate" name="DES" id="DES" required>
						</select>
					</div>	
					<br>

					<div class="input-field">
						<label for="MP" id="m">Metodo de Pago</label>
						<select value=""  class="validate" name="MP" id="MP" required>
							 
						</select>
					</div>

					<br>
					<div class="input-field">
						<label for="CAN" id="c">Recibido</label>
						<input type="text" id="CAN" name="CAN" placeholder="Recibido" class="validate" required>
					</div>	
					<br>
					<div>
						<label for="EMP" id="e">Empleado que atendio</label>
						<select value=""  class="validate" name="EMP" id="EMP" required>
							 
						</select>
					</div>	
					<br>
					<div class="input-field">
						<label for="TOT" id="t">Total</label>
						<input type="text" disabled="disabled" id="TOT" name="TOT" class="validate">
					</div>

				</form>
			
			</div>

			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar"></input>
				<input  type="button" class="btn waves-effect waves-light blue" id="Pagar" value="Pagar">
				<input  type="button" class="btn waves-effect waves-light red" id="Imprimir" value="Imprimir">
			</div >
		</div > 
	
</div >
<aside id="content">
</aside>
<script type="text/javascript">
get_all_des();
get_all_mp();
get_all_emp();

$("#modal_pago").modal();
$("#modal_pago").modal('open');

$("#Pagar").click(function(){
	$("#form_pagos").submit();
});
$("#Imprimir").click(function(){
	var id_cuenta=$("#id_cuenta").val();
	var id_ticket=$("#id_ticket").val();
	var cu=JSON.stringify(id_cuenta);
	var tic=JSON.stringify(id_ticket);

	window.open("core/pdfulti/controller_corte_ticket.php?cu="+cu+"&tic="+tic);
});

<?php
	if(isset($_GET["id_cuenta"]))
		{
?>
			$.post("core/ventas/controller_ventas.php",{action:"get_all_cu",id_cuenta:<?php echo $_GET["id_cuenta"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#TOT").val(dat["subtotal"]);
				
			});
<?php
		}
?>	


	$("#form_pagos").validate({
		errorClass: "invalid",
		rules:{
			DES:{required:true},
			MP:{required:true},
			CAN:{required:true,number:true,min:0},
			EMP:{required:true},
		},

		messages:{
			DES:{
				required:"Es Necesario Seleccionar un Tipo de Descuento"
			},
			MP:{
				required:"Es Necesario Seleccionar un Metodo de Pago"
			},
			CAN:{
				required:"Es Necesario Ingresar una Cantidad de Pago",
				number:"Solo se Aceptan Caracteres Numericos",
				min:"No puede recibir menos de cero o cero"

				
			},
			EMP:{
				required:"Es Necesario Seleccionar un Empleado"
			}
		},

		submitHandler:function(form){
			$("#Modal_confirm_pagar").modal();
			$("#Modal_confirm_pagar").modal('open');
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_pagar").modal("close");
			$.post("core/ventas/controller_ventas.php",$("#form_pagos").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');
					get_all(<?php echo $_GET["id_tipo_l"];?>);
					get_all_cuenta();
				});	
			$("#modal_pago").modal("close");
			});
			
		}
	});


	function get_all_des(){
			$.post("core/Descuentos/controller_descuentos.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Cantidad de Descuento</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_descuento"]+"'>"+dat["monto"]+"</option>";
				}
				$("#DES").html(cod_html);
				$('select').material_select();
			});
	}


	function get_all_mp(){
			$.post("core/Metodos_pagos/controller_m_pagos.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona un Metodo de Pago</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_mp"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#MP").html(cod_html);
				$('select').material_select();
			});
	}


	function get_all_emp(){
			$.post("core/Empleados/controller_empleados.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona un Empleado</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_empleado"]+"'>"+dat["nombre"]+" "+dat["ap"]+" "+dat["am"]+"</option>";
				}
				$("#EMP").html(cod_html);
				$('select').material_select();
			});
	}

</script>
<aside class="modal" id="Modal_confirm_pagar"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				 Seguro que desea realizar la operacion	
			</div>
			<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar"></input>  
			<input  type="button" class="btn blue" id="btn_confirm_modificar" value="Aceptar">
		</div>
		</div > 
	</div > 
</aside>
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
	#d{
		position: relative;;
	}
	#m{
		position: relative;
	}
	#c{
		position: relative;
	}
	#e{
		position: relative;
	}
	#t{
		position: relative;
	}
	#CAN-error{
		position: relative;
		color: red;
	}
	#DES-error{
		position: relative;
		color: red;
	}
</style>
