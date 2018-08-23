<div class="modal fade" id="modal_alimentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				Corte de Caja
				</h4> 
			</div >
			<div class="modal-body">
				<div class="input-append date">
					<label for="Fecha_i">De</label>
				    <input size="45" type="text" value="" placeholder="Fecha de Inicio" readonly id="Fecha_i" class="intf">
				    <!--<span class="add-on"><i class="icon-th"></i></span>-->
					<label for="Fecha_f" id="lf">Hasta</label>
				    <input size="45" type="text" value="" placeholder="Fecha final" readonly id="Fecha_f" class="intf">
				</div>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input> 
			<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar">
			</div >
		</div > 
	</div > 
</div >
<script type="text/javascript">
$("#modal_alimentos").modal();

    $("#Fecha_i").datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        language:'es',
        pickerPosition: "bottom-left"
    });
     $("#Fecha_f").datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        language:'es',
        pickerPosition: "bottom-left"
    });
</script>
