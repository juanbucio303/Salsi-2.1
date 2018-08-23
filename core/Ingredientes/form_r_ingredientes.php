<div class="modal" id="form_restar"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
					Restar Ingrediente
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_ingredientes_r">

							<input type="hidden" value="RestarI" id="action" name="action" type="hidden">
							<!-- se especifica el valor del value para que ejecute el case correspondiente-->

							<?php
							if(isset($_GET["id_ingrediente"]))
								echo '<input value="'.$_GET["id_ingrediente"].'" id="id_ingrediente" name="id_ingrediente" type="hidden">';
							?>

							<div class="input-field">
								<label id="c" for="CAN">Cantidad</label>
								<input type="text" name="CAN" id="CAN" placeholder="Cantidad" class="form-control" required>
								<br>
							</div>
				</form>
				<div class="input-field">
					<label id="t">Total de ingrediente</label>
					<input type="text" id="TOT" name="TOT" style="border: none;">
					<br>
				</div>
			</div>
				<div class="modal-footer"> 
					<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar"> 
					<input  type="button" class="btn blue" id="VENDER" name="VENDER" value="Aceptar">
				</div >
		</div >  
</div >
<script type="text/javascript">
	$("#form_restar").modal();
	$("#form_restar").modal('open');
	$("#VENDER").click(function(){
		$("#form_ingredientes_r").submit();
	});

	<?php
	if(isset($_GET["id_ingrediente"]))
		{
?>
			$.post("core/Ingredientes/controller_ingredientes.php",{action:"get_one",id_ingrediente:<?php echo $_GET["id_ingrediente"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#TOT").val(dat["cantidad"]);
				
			});
<?php
		}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_ingredientes_r").validate({
		errorClass: "invalid",
		rules:{

			CAN:{required:true,number:true,min:1},
		},

		messages:{
			CAN:{
				required:"Es Necesario Ingresar una Cantidad",
				min:"No puede cancelar menos de un producto",
				number:"Solo se Permiten Numeros"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#Modal_confirm_modificar").modal('open');
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_modificar").modal("close");
				$.post("core/Ingredientes/controller_ingredientes.php",$("#form_ingredientes_r").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					M.toast({html:"<h5 style='color:#212121;'>"+info[0]+"</h5>", classes: 'rounded'});
					get_all();
			});
			$("#form_restar").modal("close");
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
				 Seguro que desea cancelar esta cantidad de alimentos	
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
	#CAN-error,#TOT-error{
		position: relative;
		color: red;
	}
	#c,#t{
		position: relative;
	}
</style>