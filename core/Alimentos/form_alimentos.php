<div class="modal" id="modal_a" style="width: 80%; height: 80%;">
	<div class="modal-content"> 
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">
			Agregar Alimento
			</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
		</div >
		<div class="modal-body">
		<form action="#!" method="post" id="form_alimentos">

					<input type="hidden" value="insert" id="action" name="action" type="hidden">
					<!-- se especifica el valor del value para que ejecute el case correspondiente-->

			<div class="input-field">
				<label for="Des" id="d">Descripcion</label>
				<input type="text" placeholder="Descripcion" class="validate" name="Des" id="Des" required>
			</div>
			<div class="input-field">
				<label for="Pre" id="p">Precio</label>
				<input type="text" placeholder="Precio" class="validate" name="Pre" id="Pre" required>
			</div>
			<div class="input-field">
				<label for="Cat" id="cati">Categoria</label>
				<select value=""  class="validate" name="Cat" id="Cat" required>
				</select>
			</div>
			<div class="input-field">
				<label for="TA" id="tipa">Tipo de Alimento</label>
				<select value=""  class="validate" name="TA" id="TA" required>
					<option value="1">Fuera de control</option>
					<option value="2">Dentro de control</option>
				</select>
			</div>
			<div class="input-field">
				<label for="Ing" id="in">Ingrediente Principal</label>
				<select value=""  class="validate" name="Ing" id="Ing" required>
				</select>
			</div>

			<div class="input-field">
				<label for="Canp" id="ca">Cantidad de Ingrediente Necesaia para Preparar</label>
				<input type="text" placeholder="Cantidad de Ingrediente Necesaia para Preparar" class="validate" name="Canp" id="Canp" required>
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

get_all_cat();
get_all_i();
$("#modal_a").modal();
$("#modal_a").modal('open');


	$("#aceptar").click(function(){
		$("#form_alimentos").submit();
		alert(tipo_a);
	});
	
	$("#add_categoria").click(function()
		{	
			$("#container_modal2").load("core/Categorias/form_categorias.php");
		});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_alimentos").validate({
		errorClass: "invalid",
		rules:{
			Des:{required:true,validar_form:true},
			Pre:{required:true,number:true,min:1},
			Cat:{required:true},
			TA:{required:true},
			Ing:{required:true},
			Canp:{required:true,number:true,min:0},
		},

		messages:{
			Des:{
				required:"Es Necesario Ingresar el Nombre del Alimento",
				validar_form:"No se Permite Ingresar Caracteres Especiales"
			},
			Pre:{
				required:"Es Necesario Ingresar el Precio",
				number:"Es Necesario Ingresar caracteres numericos",
				min:"El precio de un Alimento no puede ser 0"
			},
			Cat:{
				required:"Es Necesario Seleccionar una Categoria"
			},
			TA:{
				required:"Es Necesario Seleccionar un Tipo de Alimento"
			},
			Ing:{
				required:"Es Necesario Seleccionar un Ingrediente"
			},
			Canp:{
				required:"Es Necesario Ingresar una cantidad Necesaria para ",
				number:"Es Necesario Ingresar caracteres numericos",
				min:"La cantidad de preparacion no puede ser menor a  0"
			},
		},

		submitHandler:function(form){
			$.post("core/Alimentos/controller_alimentos.php",$("#form_alimentos").serialize()
				,function(){
					get_all();
					$("#modal_a").modal('close');
				});
		}
	});	



	function get_all_cat(){
			$.post("core/Categorias/controller_categorias.php", {action:"get_all_alac"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Categoria de Alimentos</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_categoria_a"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#Cat").html(cod_html);
				$('select').formSelect();
			});
		}
	function get_all_i(){
			$.post("core/Ingredientes/controller_ingredientes.php", {action:"get_all_i_a"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona el Ingrediente Principal</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_ingrediente"]+"'>"+dat["desi"]+"</option>";
				}
				$("#Ing").html(cod_html);
				$('select').formSelect();
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
	#Des-error{
		position: relative;
		color: red
	}
	#Pre-error,#TA-error,#Canp-error,#Ing-error{
		position: relative;
		color: red
	}
	#cati,#d,#p,#tipa,#ca,#in{
		position: relative;
	}
</style>
