	<div class="modal" id="modal_f_ventas" >
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel">
				Agregar Venta
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
				<div class="modal-body">
					<form action="#!" method="post" id="form_ventas">
						<input type="hidden" value="AGREGARV" id="action" name="action" type="hidden">
						<input type="hidden" value="" id="valor-cat" name="Cat">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>
						<div class="row">
				      <div class="col s6">
								<div class="input-field">
									<label for="Cat" id="c">Categoria de Alimento</label>
									<input  list="Datalist" id="cambia">
									<datalist id="Datalist">

									</datalist>
									<!-- <select value=""  class="validate" name="Cat" id="Cat" required>
								</select> -->
								<br>
							</div>
						</div>
				      <div class="col s6">
								<div class="input-field">
									<label for="Ali" id="a">Producto</label>
									<select value=""  class="validate" name="Ali" id="Ali" required>

									</select>
									<br>
								</div>
							</div>
				    </div>
						<div class="row">
						  <div class="col s6">
								<div class="input-field">
									<label for="Cu" id="cuen">Cuenta</label>
									<select value=""  class="validate" name="Cu" id="Cu" required>

									</select>
									<br>
								</div>
						  </div>
							<div class="col s6">
								<div class="input-field">
									<label for="Can" id="ca">Cantidad</label>

									<input type="number" name="Can" id="Can" placeholder="Cantidad de Productos" class="validate" min="1" max="99" required>
								</div>
						  </div>
						</div>
							<!-- <div class="input-field">
								<label for="Cat" id="c">Categoria de Alimento</label>
								<select value=""  class="validate" name="Cat" id="Cat" required>

								</select>
								<br>
							</div>

							<div class="input-field">
								<label for="Ali" id="a">Producto</label>
								<select value=""  class="validate" name="Ali" id="Ali" required>

								</select>
								<br>
							</div>

							<div class="input-field">
								<label for="Cu" id="cuen">Cuenta</label>
								<select value=""  class="validate" name="Cu" id="Cu" required>

								</select>
								<br>
							</div>

							<div class="input-field">
								<label for="Can" id="ca">Cantidad</label>
								<input type="text" name="Can" id="Can" placeholder="Cantidad de Productos" class="validate" required>
							</div> -->

					</form>
				</div>
				<div class="modal-footer">
					<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar"></input>
					<input  type="button" class="btn blue" id="Vender" name="Vender" value="Aceptar">
				</div >
		</div >
	</div >
<script type="text/javascript">
var id_locacion=$("#id_locacion").val();
get_all_cat();
get_all_cu(id_locacion);
// $("#Cat").change(function(){
// 	var id_categoria_a=$(this).val();
// 	get_all_ali(id_categoria_a);
// });
$("#cambia").change(function(){
	var id_categoria_a=$(this).val();
	// var cate = $(this).data().id;

	// alert(id_categoria_a);
	$("#valor-cat").attr("value",id_categoria_a);
	// alert(id_categoria_a);
	get_all_ali(id_categoria_a);
});


	$("#modal_f_ventas").modal();
	$("#modal_f_ventas").modal('open');
	$("#Vender").click(function(){
		$("#form_ventas").submit();
	});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[1-9]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_ventas").validate({
		errorClass: "invalid",
		rules:{
			Cat:{required:true},
			Ali:{required:true},
			Can:{required:true,number:true,max:99,min:1,maxlength:2},
			Cu:{required:true},
		},

		messages:{
			Cat:{
				required:"Es Necesario Seleccionar una Categoria"
			},
			Ali:{
				required:"Es Necesario Seleccionar un Producto"
			},
			Can:{
				required:"Es Necesario Ingresar una Cantidad",
				max:"No puede vender mas de 99 prodcutos",
				min:"No puede vender menos de un producto",
				maxlength:"Esta excediento la cantidad permitida para vender",
				number:"Solo se aceptan caracteres numericos"

			},
			Cu:{
				required:"Es Necesario Seleccionar una cuenta"
			},
		},

		submitHandler:function(form){
			$.post("core/ventas/controller_ventas.php",$("#form_ventas").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');
					get_all_v();
					get_all_tot();
					$("#modal_f_ventas").modal("close");
				});
		}
	});

	function get_all_ali(id_categoria_a){
		$.post("core/Alimentos/controller_alimentos.php",{action:"get_all_nom",descripcion:id_categoria_a},function(res){
			var datos=JSON.parse(res);
			var html="<option disabled='true' selected>Seleciona un producto</option>";
			for(var i=0;i<datos.length;i++)
			{
				dato=datos[i];
				html+="<option value='"+dato["id_alimento"]+"'>"+dato["Descripcion"]+"</option>";
			}
			$("#Ali").html(html);
			$('select').material_select();
		});
	}

	function get_all_cat(){
			$.post("core/Categorias/controller_categorias.php", {action:"get_all_a"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Categoria de Alimentos</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option data-id='"+dat["id_categoria_a"]+"' value='"+dat["descripcion"]+"'>";
					// cod_html+="<option value='"+dat["id_categoria_a"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#Cat").html(cod_html);
				$("#Datalist").html(cod_html);
				$('select').material_select();
			});
		}

	function get_all_cu(id_locacion){
			$.post("core/ventas/controller_ventas.php", {action:"get_all_cuenta",id_locacion:id_locacion}, function(res){
				var datos=JSON.parse(res);
				 var cod_html="";//<option disabled='true' selected>Selecciona una Cuenta</option>";
				 if(datos.length!=1){
					 var cod_html="<option disabled='true' selected>Selecciona una Cuenta</option>";

					 for (var i=0; i<datos.length;i++)
					 {
						 dat=datos[i];
						 cod_html+="<option value='"+dat["id_cuenta"]+"'>"+dat["descripcion"]+"</option>";
					 }
				 }
					else{
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
	#Cat-error,#Can-error,#Ali-error,#Cuen-error{
		position: relative;
		color: red;
	}
	#c,#a,#ca,#cuen{
		position: relative;
	}
</style>
