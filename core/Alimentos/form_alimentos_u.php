<div class="modal" id="modal_a_u" style="width: 80%; height: 80%;">      
      <div class="modal-content"> 
      	<div class="modal-header">
      		<h4 class="modal-title" id="myModalLabel">
      	   Modificar Alimento
         </h4> <!-- se especifica el titulo del modal para diferenciarlos-->
      	</div >
      	<div class="modal-body">
        	<form action="#!" method="post" id="form_alimentos_u">

        				<input type="hidden" value="update_a" id="action" name="action" type="hidden">
        				<!-- se especifica el valor del value para que ejecute el case correspondiente-->

        				<?php
        					if(isset($_GET["id_producto"]))
        						echo '<input value="'.$_GET["id_producto"].'"id="id_producto" name="id_producto" type="hidden">';
        				?>


        		<div class="input-field">
              <label for="Des" id="desi">Descripcion</label>
        			<input type="text"  class="validate" name="Des" id="Des" required>
        		</div>
        		<div class="input-field">
              <label for="Pre" id="p">Precio</label>
        			<input type="text"  class="validate" name="Pre" id="Pre" required>
        		</div>
        		<div class="input-field">
              <label for="Cat" id="cati">Categoria</label>
        			<select value=""  class="validate" name="Cat" id="Cat" required>
        			</select>
        		</div>
        		<div class="input-field">
                  <label for="Est" id="esti">Estado</label>
        	        <select value="" class="validate" name="Est" id="Est" required>
        	          <option value="1">Activo</option>
        	          <option value="0">Desactivado</option>
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
        	<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">  
        	<input  type="button" class="btn blue" id="aceptar" value="Aceptar">
      	</div >
      </div > 
</div>      
<script type="text/javascript">
get_all_cat();
get_all_i();
$("#modal_a_u").modal();
$("#modal_a_u").modal('open');

	$("#aceptar").click(function(){
		$("#form_alimentos_u").submit();
	});

	$("#cancelar").click(function(){
		$("#container_modal").modal('close');
	});
	
  $("#canci").click(function(){
    $("#Modal_confirm_modificar").modal('close')
  });
	 <?php


  if(isset($_GET["id_producto"]))
    {
      ?>
        $.post("core/Alimentos/controller_alimentos.php",{action:"get_one_a",id_producto:<?php echo $_GET["id_producto"]?>},function(res){
          var dat=JSON.parse(res);
          dat=dat[0];
          $("#Des").val(dat["Descripcion"]);
          $("#Pre").val(dat["Precio"]);
          $("#Cat").val(dat["id_categoria_a"]);
          $("#Est").val(dat["estado"]);
          $("#TA").val(dat["id_tipo_de_a"]);
          $("#Ing").val(dat["id_ingrediente"]);
          $("#Canp").val(dat["cantidad_p"]);
          $('select').formSelect();

      });
    <?php
  }
?>  

  jQuery.validator.addMethod("validar_form", function(value, element) {
   return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
  }, "Porfavor de Ingresar solo letras");
  
  $("#form_alimentos_u").validate({
    errorClass: "invalid",
    rules:{
      Des:{required:true,validar_form:true},
      Pre:{required:true,number:true,min:1},
      Cat:{required:true},
      Est:{required:true},
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
      Est:{
        required:"Es Necesario Seleccionar un Estado"
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
        $("#Modal_confirm_modificar").modal();
        $("#Modal_confirm_modificar").modal('open');
        var length=$(".modal-overlay").length-1;
        $("#btn_confirm_modificar").click(function(event){
          $("#Modal_confirm_modificar").modal("close");
          $.post("core/Alimentos/controller_alimentos.php", $('#form_alimentos_u').serialize(), function(){
        get_all();
        });
        $('#modal_a_u').modal("close");
        });
    }
  }); 

  function get_all_cat(){
      $.post("core/Categorias/controller_categorias.php", {action:"get_all_a"}, function(res){
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
      <input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar"></input>   
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
  #Des-error{
    position: relative;
    color: red
  }
  #Pre-error,#TA-error,#Canp-error,#Ing-error,#Est-error{
    position: relative;
    color: red
  }
  #cati,#desi,#p,#tipa,#ca,#in,#esti{
    position: relative;
</style>
