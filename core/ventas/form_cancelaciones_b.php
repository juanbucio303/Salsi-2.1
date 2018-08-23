<div class="modal" id="modal_can">
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Cancelar Bebidas
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_ventas_u">

						<input type="hidden" value="cancelar_b" id="action" name="action">
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
							if(isset($_GET["id_alimento"]))
								echo '<input value="'.$_GET["id_alimento"].'"id="id_alimento" name="id_alimento" type="hidden">';
						?>
						<?php
						if(isset($_GET["id_tipo_l"]))
						echo '<input value="'.$_GET["id_tipo_l"].'"id="id_tipo_l" name="id_tipo_l" type="hidden">';
						?>
					<div class="input-field">
						<label for="Can" id="c">Cantidad a cancelar</label>
						<input type="text" name="Can" id="Can" placeholder="Cantidad deseada a cancelar" class="form-control" required>
					</div>
				</form>
				<label>Total vendido</label>
				<input type="text" name="CA" id="CA" disabled="disabled" style="border-style: none;">
			</div>
			<div class="modal-footer"> 
				<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar">
				<input  type="button" class="btn blue" id="Modificar"  value="Aceptar">
			</div >
		</div > 
</div >
<script type="text/javascript">

	$("#modal_can").modal();
	$("#modal_can").modal('open');

	$("#Modificar").click(function(){
		$("#form_ventas_u").submit();
	});


<?php
	if(isset($_GET["id_venta"]))
		{
?>
			$.post("core/ventas/controller_ventas.php",{action:"get_one_b",id_venta:<?php echo $_GET["id_venta"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#CA").val(dat["cantidad"]);					
				
			});
<?php
		}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[1-9]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_ventas_u").validate({
		errorClass: "invalid",
		rules:{
			Can:{required:true,number:true,max:99,min:1,maxlength:2},
		},

		messages:{
			Can:{
				required:"Es Necesario Ingresar una Cantidad",
				max:"No puede cancelar mas de 99 prodcutos",
				min:"No puede cancelar menos de un producto",
				maxlength:"Esta excediento la cantidad permitida para cencelar",
				number:"Solo se Permiten Numeros"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#Modal_confirm_modificar").modal('open');
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_modificar").modal("close");
			$.post("core/ventas/controller_ventas.php",$("#form_ventas_u").serialize()
				,function(res){
					var datos=JSON.parse(res);
					
					var info=datos[0];
					Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');
					get_all_v();
					get_all_tot();
					get_all(<?php echo $_GET["id_tipo_l"];?>);
					
				});	
			$("#modal_can").modal("close");
			$("#Modal_confirm_admi").modal('close');
			$("#modal_w").modal('close');
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
				 Seguro que desea cancelar esa cantidad de productos	
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
	#Can-error{
		position: relative;
		color: red;
	}
	#c{
		position: relative;
	}
</style>