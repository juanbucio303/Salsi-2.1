<div class="modal" id="modal_c_u">	
	<div class="modal-content"> 
		<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						Modificar Empleado"
					</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
		</div >
		<div class="modal-body">
			<form action="#!" method="post" id="form_c_a_u">
							<input type="hidden" value="update" name="action">
							<!-- se especifica el valor del value para que ejecute el case correspondiente-->
							<?php
								if(isset($_GET["id_categoria_a"]))
									echo '<input value="'.$_GET["id_categoria_a"].'"id="id_categoria_a" name="id_categoria_a" type="hidden">';
							?>
							<div class="input-field">
								<label for="CA" style="position: relative;">Categoria</label>	
								<input type="text" name="CA" class="validate"  id="CA" >
							</div>

							<div class="input-field">
					          <label for="Est" id="esti" style="position: relative;">Estado</label>
						        <select value="" class="validate" name="Est" id="Est" required>
						          <option value="1">Activo</option>
						          <option value="0">Desactivado</option>
						        </select>
							</div>

							<div class="input-field">
								<label for="TC" id="t_c" style="position: relative;">Tipo de Categoria</label>
								<select value=""  class="validate" name="TC" id="TC" required>
									<option value="1">Alimentos</option>
									<option value="2">Bebidas</option>	 
								</select>
								<br>
							</div>
							
			</form>
		</div>
		<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"> 
			<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
		</div >
	</div >
</div>	 
<script type="text/javascript">
$("#modal_c_u").modal();
$("#modal_c_u").modal('open');

	$("#aceptar").click(function(){
		$("#form_c_a_u").submit();
	});


<?php

	if(isset($_GET["id_categoria_a"]))
		{
?>
		$.post("core/Categorias/controller_categorias.php",{action:"get_one",id_categoria_a:<?php echo $_GET["id_categoria_a"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#CA").val(dat["descripcion"]);
				$("#Est").val(dat["estado"]);
				$("#TC").val(dat["tipo_c"]);
				$('select').formSelect();

	});
<?php
		}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_c_a_u").validate({
		errorClass: "invalid",
		rules:{
			CA:{required:true,validar_form:true},
			Est:{required:true},
		},

		messages:{
			CA:{
				required:"Es Necesario Escribir Una Categoria de Alimento"
			},
			Est:{
				required:"Es Necesario Seleccionar un Estado"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#Modal_confirm_modificar").modal('open');
			var length=$(".modal-overlay").length-1;
				$("#btn_confirm_modificar").click(function(event){
					$("#Modal_confirm_modificar").modal("close");
					$.post("core/Categorias/controller_categorias.php", $('#form_c_a_u').serialize(), function(){
				get_all();
				});
					$("#modal_c_u").modal("close");

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
      <input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"></input>   
      <input  type="button" class="btn blue" id="btn_confirm_modificar" value="Aceptar">
      </div>
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
	#CA-error{
		position: relative;
    	color: red
	}
  
</style>