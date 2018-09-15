<?php session_start();
if(!isset($_SESSION['id_usuario']))
	header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/mate.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="fonts/icons/material-icons.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.material.min.css">

	<script type="text/javascript" src="js/jquer.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/datepicker-es.js"></script>
	<script type="text/javascript" src="js/mate.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<title>Ventas</title>
	<script type="text/javascript">
		$(document).ready(function()
		{


			get_all_ali();
			get_num_ali();
			$("#pago").hide();
			get_all_tot();
			$("#alerta2").on("click",function(){
				get_all_i();
			});
			get_tl();
			$("#cont_nav_tabs").on("click", "li a",function()
			{
				var id=$(this).data("id");
				get_all(id);
			});
//////////////////////////////////////Cierre de dia/////////////////////////////////////////////
		$("#cont_info_nav_tabs").on("click","#button_corte",function()
		{
				$("#container_modal").load("core/ventas/form_corte.php");
			});
//////////////////////ventas////////////////////////////
		$("#cont_info_nav_tabs").on("click",".btn_informacion",function()
		{
			var id_locacion=$(this).data("id");
			// alert(id_locacion);
			$("#add_ventas").attr("data-id_locacion",id_locacion);
		});

		$("#add_ventas").on("click",function()
		{
			var id_locacion=$(this).data("id_locacion");
			// alert(id_locacion);
			// $("#add_ventas").attr("data-id_locacion",id_locacion);
			$("#container_modal_f").load("core/ventas/form_ventas.php?id_locacion="+id_locacion);
		});

		$("#cont_info_nav_tabs").on("click","div.btn_informacion",function()
		{
			var id_locacion=$(this).data("id");
			var id_tipo_l=$(this).data("id_tipo_l");
			var id_ticket=$(this).data("id_ticket");
			var estado = $(this).data("estado");
			$("#tot").html("Total: "+0);
			$("#id_cuenta").val(id_ticket);

			get_all_tot(id_ticket,id_locacion,id_tipo_l);
			if(estado==1){// comprobacion del estado de la reservacion
				reservar(id_locacion,id_tipo_l);
				get_all_v(id_locacion,id_ticket);
			}else{
				get_all_v(id_locacion,id_ticket);

			}
				// $("#container_modal").load("core/ventas/window_venta.php?id_locacion="+id_locacion+"&id_tipo_l="+id_tipo_l+"&id_ticket="+id_ticket);
			// }else
			// $("#container_modal").load("core/ventas/window_venta.php?id_locacion="+id_locacion+"&id_tipo_l="+id_tipo_l+"&id_ticket="+id_ticket);
		});

		function get_all_v(id,id_t)
		{
			$.post("core/ventas/controller_ventas.php",{action:"get_all_ven",id_locacion:id,id_ticket:id_t},
				function(res){
					var datos=JSON.parse(res);
					var cod_html="";
					for (var i=0;i<datos.length;i++)
					{
						var info=datos[i];
						// cod_html+="<tr><td>"+info['descripcion']+"</td><td>"+info['precio']+"</td><td>"+info['cantidad']+"</td><td>"+info['subtotal']+"</td><td>"+info['cuentas']+"</td><td><a class='waves-effect btn-flat  btn_eliminar' data-id='"+info["id_venta"]+"' data-id_cuenta='"+info["id_cuenta"]+"' data-id_alimento='"+info["id_alimento"]+"' data-id_tipo_v='"+info["tipo_v"]+"' style='color: #ef5350'><span class='material-icons'>cancel</span></a></td><td><a class='waves-effect btn-flat  btn_modificar' data-id='"+info["id_venta"]+"' data-id_cuenta='"+info["id_cuenta"]+"' data-id_alimento='"+info["id_alimento"]+"' data-id_tipo_v='"+info["tipo_v"]+"' style='color: #1976d2'><span class='material-icons'>edit</span></a></td></tr>"
						cod_html+="<tr><td>"+info['descripcion']+"</td><td>"+info['cantidad']+"</td><td>"+info['subtotal']+"</td><td><a class='waves-effect btn-flat  btn_eliminar' data-id='"+info["id_venta"]+"' data-id_cuenta='"+info["id_cuenta"]+"' data-id_alimento='"+info["id_alimento"]+"' data-id_tipo_v='"+info["tipo_v"]+"' style='color: #ef5350'><span class='material-icons'>cancel</span></a> <a class='waves-effect btn-flat  btn_modificar' data-id='"+info["id_venta"]+"' data-id_cuenta='"+info["id_cuenta"]+"' data-id_alimento='"+info["id_alimento"]+"' data-id_tipo_v='"+info["tipo_v"]+"' style='color: #1976d2'><span class='material-icons'>edit</span></a> </td><td></td></tr>"
					}
					$("#content_table").html(cod_html);
				});
		}
		function get_all_tot(id_tic,id_locacion,id_tipo_l)
		{
			$.post("core/ventas/controller_ventas.php",{action:"cuenta",id_ticket:id_tic},
				function(result)
				{
					var datos=JSON.parse(result);
					var cod="";
					datos=datos[0];
					cod="Total: "+datos[0];

					$("#tot").html(cod);
					$("#totC").val(datos[0]);
					// alert(id_locacion+" "+id_tic);
					$("#pagar").attr("data-id_tipo_l",id_locacion);
					$("#pagar").attr("data-id",id_tipo_l);
				});
		}


//////////////////////////////Pagar locaciones//////////////////////////////////////////
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_pagar",function()
			{
				var id_tipo_l=$(this).data("id_tipo_l");
				var id_ticket=$(this).data("id_ticket");
				var id_locacion=$(this).data("id");
				$("#container_modal").load("core/ventas/window_pagos.php?id_ticket="+id_ticket+"&id_tipo_l="+id_tipo_l+"&id_locacion="+id_locacion);
			});


			// function pagar(id_ticket,id_locacion,id_tipo_l){
			// 	var id_tipo_l=id_tipo_l;
			// 	var id_ticket=id_ticket;
			// 	var id_locacion=id_locacion;
			// 	alert(id_tipo);
			// 	$("#pago").show();
			// 	$("#cuenta").hide();			// $("#container_modal").load("core/ventas/window_pagos.php?id_ticket="+id_ticket+"&id_tipo_l="+id_tipo_l+"&id_locacion="+id_locacion);
			// 	$("#id_cuenta").val(id_ticket);
			// }
			$("#pagar").on("click",function(){
				$("#pago").show();
				$("#cuenta").hide();
			});
			$("#Cancelar").on("click",function(){
				var id_tipo_l=$(this).data("id_tipo_l");
				var id_ticket=$(this).data("id_ticket");
				var id_locacion=$(this).data("id");
				get_all_tot(id_ticket,id_locacion,id_tipo_l);
				$("#pago").hide();
				$("#cuenta").show();
			});
/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////Reservar///////////////////////////////////////////
			// $("#cont_info_nav_tabs").on("click","div div div div a.btn_reservar",function()
			// {
			//
			// 	$("#btn_confirm_deleteL").data("id",$(this).data("id"));
			// 	$("#btn_confirm_deleteL").data("id_tipo_l",$(this).data("id_tipo_l"));
			//
			// 	$("#Modal_confirm_deleteL").modal();
			// 	$("#Modal_confirm_deleteL").modal("open");
			// });
			//
			// $("#btn_confirm_deleteL").click(function(event)
			// {
			// 	var id_locacion=$(this).data("id");
			// 	var id=$(this).data("id_tipo_l");
			// 	$.post("core/ventas/controller_ventas.php",{action:'reserva',id_locacion:id_locacion},
			// 		function(res){
			// 			var datos=JSON.parse(res);
			// 			var info=datos[0];
			// 			Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');
			// 			get_all(id);
			// 			$("#Modal_confirm_deleteL").modal("close");
			// 		});
			// });
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////MODIFICAR LOCACION////////////////////////////////////
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_modificar",function()
			{
				var id_locacion=$(this).data("id");
				var id_tipo_l=$(this).data("id_tipo_l");
				$("#container_modal").load("core/Locaciones/form_locaciones_u.php?id_locacion="+id_locacion+"&id_tipo_l="+id_tipo_l);
			});
		});
///////////////////////////////////////////////////////////////////////////////////////
		function get_all(id_tipo_l)
		{
			$.post("core/ventas/controller_ventas.php",{action:"get_all","id_tipo_l":id_tipo_l},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++)
				{
					var info=datos[i];
					if(info["estado"]==1){
							clase="green";
						}
						else{
								clase="red";
							}
							cod_html+='<div class="row cursor" > <div class="col s6 m12 " ><div class="card '+clase+' darken-1 "><div class="card-content white-text btn_informacion" data-id="'+info["id_locacion"]+'" data-id_tipo_l="'+info["id_tipo_l"]+'" data-id_ticket="'+info["id_ticket"]+'" data-estado="'+info["estado"]+'" ><span class="">Numero de locacion:'+info["numero"]+'</span><p>Tipo de locacion:'+info["descripcion"]+'</p></div><div class="card-action"><div class="row"><div class="col s12 m6"><div class="col s12 m6"></div></div></div></div></div></div>'
							// '<div class="col s12 m12 btn_informacion cursor" data-id="'+info["id_locacion"]+'" data-id_tipo_l="'+info["id_tipo_l"]+'" data-id_ticket="'+info["id_ticket"]+'" data-estado="'+info["estado"]+'"><div class="card '+clase+' darken-1"><div class="card-content white-text"><span class="card-title">Numero de locacion:'+info["numero"]+'</span><p>Tipo de locacion:'+info["descripcion"]+'</p></div><div class="card-action"><div class="row"><div class="col s12 m6"><a href="#!" class="btn btn_pagar transparent btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Informacion de Cuentas" data-id="'+info["id_locacion"]+'" data-id_tipo_l="'+info["id_tipo_l"]+'" data-id_ticket="'+info["id_ticket"]+'"><span class="material-icons">attach_money</span></a></div><div class="col s12 m6"><a href="#"><span class="material-icons">add</span></a></div></div></div></div><div>';
					    // cod_html+="<center><div id='div_loc' class='col s12 btn_informacion cursor' data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"' data-id_ticket='"+info["id_ticket"]+"' data-estado='"+info["estado"]+"'><div class='"+clase+"'><br/><label id='lbl_locacion' class='cursor'>Numero de locación: "+info["numero"]+"<br>Locacion: "+info["descripcion"]+"<center></label><div id='btn_div'><a href='#!' class='btn btn_pagar transparent btn-flat tooltipped' data-position='top' data-delay='50' data-tooltip='Informacion de Cuentas' data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"' data-id_ticket='"+info["id_ticket"]+"'><span class='material-icons'>attach_money</span></a> </div></div></center></div></center>";
				}
				$("#content_tab"+id_tipo_l).html(cod_html);
				$('.tooltipped').tooltip({delay: 50});
			});
		}
/////////////////////////////////////////////////////////////////////////////////////////////
		function get_tl()
		{
			$.post("core/Tipos_locaciones/controller_t_l.php",{action:"get_all"},
				function(res)
				{
					var datos=JSON.parse(res);
					var cod_title="";
					var cod_cont="";
					for (var i=0;i<datos.length;i++)
					{
						var info=datos[i];
						cod_title+="<li class='tab col s3'><a data-id='"+info["id_tipo_l"]+"' href='#target"+info["id_tipo_l"]+"'>"+info["descripcion"]+"</a><li>";
						cod_cont+="<div id='target"+info["id_tipo_l"]+"'class='col s12 card-panel grey lighten-2' style='padding: 1em;'><div><a class='waves-effect waves-teal btn green tooltipped ' data-position='top' data-delay='50' data-tooltip='Cierre de Caja' id='button_corte' style='width: 2em;height: 2em;padding: 0.2em;float: right;'><span class='material-icons'>assignment</span></a><div><h5>Sección de "+info["descripcion"]+"</h5></div><div id='content_tab"+info["id_tipo_l"]+"'></div></div></div>";
						//el contenido del tipo de locación se pasó a la accion cuadno se haga clic en uno de los tabs
						$("#cont_info_nav_tabs").html(cod_cont);
					}
					$("#cont_nav_tabs").html(cod_title);
					//$('cont_nav_tabs.tabs.a:first').tabs('select_tab', 'show');
					/*Forma de inicializar el tab especifcando el contenedor y el primer hijo que sea a , con palabra select_tab y show*/
					get_all($('#cont_nav_tabs.tabs a:first').data("id"));
					/*Get all especificando que cargara la primera a con su respectivo data(id)*/
				   $('ul.tabs').tabs();
				   $('.tooltipped').tooltip({delay: 50});
				});
		}
///////////////////////////////////////////Se crea funcion reservar locacion///////////////////////////////////////////////////
		function reservar(id_locacion,id_tipo_l)
			{
				var id_locacion=id_locacion;
				var id=id_tipo_l;
				$.post("core/ventas/controller_ventas.php",{action:'reserva',id_locacion:id_locacion},
					function(res){
						var datos=JSON.parse(res);
						var info=datos[0];
						Materialize.toast("<h5 style='color:#212121;'>"+info[0]+"</h5>",2500,'rounded');
						get_all(id);
						// $("#Modal_confirm_deleteL").modal("close");
					});
			}
		function get_all_ali(){
			$.post("core/Alimentos/controller_alimentos.php",{action:"get_all"},function(res){
				var datos=JSON.parse(res);
				var html="";//"<li disabled='true' selected>Seleciona un producto</li>";
				for(var i=0;i<datos.length;i++)
				{
					dato=datos[i];
					html+='<tr><td><p id="id_valor" value="'+dato["pro"]+'">'+dato["descripcion"]+'</p></td><td><p value="'+dato["pro"]+'">'+dato["categoria"]+'</p></td><td><input id="prod" type="number"/></td></tr>';
					// html+="<a value='"+dato["pro"]+"'>"+dato["descripcion"]+"</a><br>";
				}
				// $("#menu").html(html);

				$("#insert_dat").html(html);
				var table = $('#example').DataTable(
					{

						  "dom": '<"top"fp>rt<"bottom"><"clear">'
					}
				);
				$('#prod').change( function() {
					var data = table.$('input, select').val();
					
					return false;
			} );
				 // $('#example').DataTable({
				 //
				 // });
				// $('select').material_select();
			});
		}
		function get_num_ali(){
			$.post("core/Alimentos/controller_alimentos.php",{action:"count_cat"},function(res){
				var datos=JSON.parse(res);
				// console.log(datos);
				var html="";//"<li disabled='true' selected>Seleciona un producto</li>";
				for(var i=1;i<datos+1;i++)
				{
					html+='<li class="waves-effect"><a href="#!"></a></li>';
				}
				// $(".pagination").html(html);
				// $('select').material_select();
			});
		}
	</script>
</head>
<body>
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<div style="background-color: #5C5757;" class="align-center">
		<?php
			require_once("menu_v.php");
		?>
	</div>


		<div class="row">
			<div class="col s12  card-panel">
				<ul id="cont_nav_tabs" class="tabs">

				</ul>
			</div>
  		<div class="row" >
        <div class="col s5 ">

          <div class="" id="menu">
						<table id="example" class="display mdl-data-table" style="width:100%">
					        <thead>
					            <tr>
												<th>Producto</th>
					              <th>Categoria</th>
												<th>Seleccionar</th>

					            </tr>
					        </thead>
					        <tbody id="insert_dat">

									</tbody>
								</table>
          </div>
        </div>
				<div class="col s4" id="pago">
					<form action="#!" method="post" id="form_pagos">
					<input type="hidden" value="PAGO_C" id="action" name="action">
					<input value="" id="id_cuenta" name="id" type="hidden">
						<div class="input-field">
							<label for="DES" id="d"></label>
							<select value=""  class="validate" name="DES" id="DES" required>
							</select>
						</div>
						<br>
						<div class="input-field">
							<label for="MP" id="m"></label>
							<select value=""  class="validate" name="MP" id="MP" required>

							</select>
						</div>

						<br>
						<div class="input-field">
							<label for="CAN" id="c"></label>
							<input type="text" id="CAN" name="CAN" placeholder="Recibido" class="validate" required>
						</div>
						<br>
						<div>
							<label for="EMP" id="e"></label>
							<select value=""  class="validate" name="EMP" id="EMP" required>

							</select>
						</div>
						<br>
						<div class="input-field">
							<label for="TOT" id="t"></label>
							<input type="text" disabled="disabled" id="totC" name="TOT" class="validate">
						</div>

					</form>
					<input  type="button" class="btn waves-effect waves-light blue" id="PagarV" value="Pagar">
					<input  type="button" class="btn waves-effect waves-light red" id="Cancelar" value="Cancelar">

				</div>
        <div class="col s4" id="cuenta">

						<!-- <img src="./img/ticket.png" alt=""> -->
						<table class="table responsive-table bordered highlight centered">
							<tr>
								<th>Producto</th>
								<th>Cantidad</th>
								<th>Subtotal</th>
								<th class="centrado">Cancelaciones</th>
								<th class="centrado">Editar Cuenta</th>
							</tr>
							<tbody id="content_table"></tbody>
						 </table>
            <div class="row">
              <div class="col s6 cursor">
								<div class="card-panel teal">
					        <span class="white-text">
										Fuera Menu
										<a href="#!" id="add_ventas"><span class="material-icons">add</span></a>
					        </span>
							  </div>
              </div>
              <div class="col s6 cursor" id="pagar">
							  <div class="card-panel teal">
					        <span class="white-text" id="tot">
										Total: 0
					        </span>
							  </div>
              </div>
            </div>
        </div>
        <div class="col s3 m3 " id='cont_info_nav_tabs'>

        </div>
  		</div>
  		<?php
  			require_once("boton2.php");
  		?>
    </div>


	<aside id="container_modal" >

	</aside>

<div class="modal" id="Modal_confirm_deleteL">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">
			</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
		</div >
		<div class="modal-body">
			 ¿Seguro que desea reservar la locacion?
		</div>
		<div class="modal-footer">
		<input type="button" class="waves-effect waves-light btn modal-action modal-close red" data-dismiss="modal" value="Cerrar">
		<input  type="button" class="btn waves-effect waves-teal blue" id="btn_confirm_deleteL" value="Aceptar">
		</div >
	</div >
</div >
<div class="" id="container_modal_f">

</div>

</body>
</html>                                                                         
<script type="text/javascript">
	get_all_des();
	get_all_mp();
	get_all_emp();
	$("#PagarV").click(function(){
	$("#form_pagos").submit();
	});
	$("#PagarV").click(function(){
		$.post("core/ventas/controller_ventas.php",$("#form_pagos").serialize(),function(res){
			var datos=JSON.parse(res);
			var cod="";
			var info=datos;
			Materialize.toast({html: '"'+info[0]+'"', classes: 'rounded'});

			$("#cont_nav_tabs").on("click", "li a",function()
			{
				var id=$(this).data("id");
				get_all(id);
			});
		});
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
		// $("#Pagar").click(function(){
		// 	$("#form_pagos").submit();
		// });
	}
</script>
