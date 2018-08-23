<div class="fixed-action-btn">
	<a href="#" class="btn-floating btn-large waves-effect waves-light red button-collapse tooltipped" data-position='top' data-delay='50' data-tooltip='Alertas de Ingredientes' data-activates="slide-out" id="alerta2"><i class="material-icons">warning</i></a>
</div>

<div id="slide-out" class="side-nav">
	<h5>Alertas de ingredientes perecederos o existencias casi agotadas</h5>
   <table>
   		<thead>
   			<tr>
   				<th>Ingrediente</th>
   				<th>Cantidad</th>
               <th>Agregar</th>
   			</tr>
   		</thead>
   		<tbody id="content_table_b">
   			
   		</tbody>
   </table>
</div>
<aside id="con">

</aside>

<script type="text/javascript">
	 $(document).ready(function(){
       $(".button-collapse").sideNav();
       $('.tooltipped').tooltip({delay: 50});

        $("#content_table_b").on("click","a.btn_agregar",function(){
             var id_ingrediente=$(this).data("id");
            $("#con").load("core/Existencias/form_existencias_b2.php?id_ingrediente="+id_ingrediente);
         });
    });

    function get_all_i()
      {
        $.post("core/Ingredientes/controller_ingredientes.php",{action:"get_all"},
         function(res)
         {
            var datos=JSON.parse(res);
            var cod_html="";
            for (var i=0;i<datos.length;i++) 
            {
               var info=datos[i];
               if(info["estado_c"]==1){
                  clase="caducado1";
               }else{
                  if(info["estado_c"]==2){
                  clase="caducado2";
                  }else{
                     if(info["estado_c"]==3){
                        clase="caducado3";
                     }else{
                        if(info["estado_c"]==4){
                           clase="caducado4";
                        }else{
                           if(info["estado_c"]==5){
                              clase="caducado5";
                           }
                        }
                     }
                  }
               }
               if(info["id_medida"]==1){
                  if(info["cantidad"]<=3000){
                     clas="caducado4";
                  }else{
                     if(info["cantidad"]<=1000){
                        clas="caducado5";
                     }else{
                        clas="caducado1";
                     }
                  }
               }else{
                  if(info["id_medida"]==2){
                     if(info["cantidad"]<=30){
                        clas="caducado4";
                     }else{
                        if(info["cantidad"]<=10){
                           clas="caducado5";
                        }else{
                           clas="caducado1";
                        }

                     }
                  }else{
                     if(info["id_medida"]==3){
                        if(info["cantidad"]<=3000){
                           clas="caducado4";
                        }else{
                           if(info["cantidad"]<=1000){
                              clas="caducado5";
                           }else{
                              clas="caducado1";
                           }
                        }
                     }
                  }
               }     
               cod_html+="<tr><td class='"+clase+"'>"+info['desi']+"</td> <td class='"+clas+"'>"+info['cantidad']+"  "+info['desm']+"</td> <td class='centrado'><a class='waves-effect btn-flat btn_agregar' data-id='"+info["id_ingrediente"]+"' style='color: #4caf50'><span class='material-icons'  style='margin-top: 0.2em'>add</span></a></td></tr>";
               //se insertan los datos a la tabla
            }
            $("#content_table_b").html(cod_html);
         });
      }
</script>