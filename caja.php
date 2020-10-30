<?php
session_start();
//print_r($_SESSION);
?>
  <style>
  .ui-tooltip, .arrow:after {
    background: black;
    border: 2px solid white;
  }
  .ui-tooltip {
    padding: 10px 20px;
    color: white;
    border-radius: 20px;
    font: bold 14px "Helvetica Neue", Sans-Serif;
    text-transform: uppercase;
    box-shadow: 0 0 7px black;
  }
  .arrow {
    width: 70px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    left: 50%;
    margin-left: -35px;
    bottom: -16px;
  }
  .arrow.top {
    top: -16px;
    bottom: auto;
  }
  .arrow.left {
    left: 20%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
  .arrow.top:after {
    bottom: -20px;
    top: auto;
  }
  </style>
<script src="js/caja.js"></script>
<table align="center" width="100%" border="0" id="tbl_buscar_producto">
  <tr>
      <td align="left" width="260" >
      	<input class="text_box" id="txt_cj_codigo" type="text" autocomplete="off" placeholder="Codigo del Articulo" onkeypress="key_buscar_producto(event,this)" style="width:250px;" required>
      </td>
      <td align="left" width="260">
      	<input class="text_box" id="txt_cj_nombre" type="text" placeholder="Nombre del Articulo" style="width:250px;" required>
      </td> 
      <td width="50">
          <select name="select_cantidad_caja" id="select_cantidad_caja">
          <?php
              for($x=1;$x<=100; $x++){
                  echo "<option value='".$x."'>".$x."</option>";
              }
          ?> 
          </select>
      </td>      
      <td><div id="ajax_items_alert" style="position:relative; height:25px; top:-3px;"></div></td>     
  </tr>
</table>
<div id="ajax_items_add"></div>
<div id="caja_totales">
	<div id="" style="position: relative; width:75%; height:70px; display:table; float:left; background-color: #191919">
    	<table border="0" width="100%">
        	<tr>
                <td width="30">
                    <input type="text" name="f_inicial" id="f_inicial" size="7" maxlength="140" style="height:24px; margin-left:0; display:none;" />
                </td>    
                <td width="30">
                    <input type="text" name="f_final" id="f_final" size="7" maxlength="140" style="height:24px; margin-left:0; display:none;" />
                </td>            
            	<td width="70">
                	
                	<div class="button_azul" id="btn_ventas_realizadas" style="width:70px; font-size:12px">
                    	<div style="padding-top:20px; width:70px;">Ventas</div>
                	</div>
                   
                </td>
            	<td width="70">
                	<div class="button_azul" id="btn_pagos_realizados" style="width:70px; font-size:12px">
                    	<div style="padding-top:20px; width:70px;">Pagos</div>
                	</div> 
                </td> 
            	<td width="70"> 
                	<div class="button_azul" id="btn_maayoreo" style="width:70px; font-size:12px">
                    	<div style="padding-top:20px; width:70px;">Mayoreo</div>
                	</div> 
                </td>    
            	<td width="70"> 
                	<div class="button_azul hide" id="btn_dvlcion" style="width:70px; font-size:12px">
                    	<div style="padding-top:20px; width:70px;">Dvlcion</div>
                	</div>                 

                </td>                               
                <td width="30%"></td>               
                <td><div class="button_otros" id="btn_generico"><div style="padding-top:6px;">Otros<br /> <span class="font_14">(F4)</span></div></div></td>
                <td><div class="button_cobrar" id="btn_caja_pago"><div style="padding-top:6px;">Retiros<br /> <span class="font_14">(F3)</span></div></div></td>
                <td><div class="button_caja" id="btn_caja_cobrar"><div style="padding-top:6px;">Cobrar<br /> <span class="font_14">(F2)</span></div></div></td>
            </tr>
        </table>
    </div>
    <div id="" style="position:relative; width:25%; float:left;background-color: #333">
        <table border="1" width="100%" height="70" cellpadding="0" cellspacing="0">
        <tr>
            <td width="50%"  align="right">Subtotal: </td><td id="subTotal" align="right"></td>
        </tr>
        <tr>
            <td width="50%"  align="right">IVA: </td><td id="iva" align="right"></td>
        </tr>
        <tr>
            <td width="50%"  align="right">Total: </td><td id="total" align="right"></td>
        </tr>                
        </table>
        <input type="hidden" id="txt_total"  />
    </div>    
</div>
<div id="dialog_detalles" style="width:450px; display:none">
    <div id="popup_contenido" style="position: relative; overflow-y: auto; height: 40px; font-size:24px"></div>
    
    <div id="tarjetas" style="position:relative; width:100%;">
    	<div style="position:relative; float:left; width:103px; height:100px; ">
        	<img src="images/pago_tarjeta.png" width="70" height="60" style="position:relative; float:right;" />
        </div>
       <!-- *************************** ICONOS DE TARJETAS *************************** -->
        <div style="position:relative; float:left; width:300px; height:50px; margin-left:10px;">
        	<div class="card hover_line hand" card="master_card" img="images/t_master_card.png" style="position: absolute; float:left; width:57px;">
        		<img src="images/t_master_card.png" style="position:relative; margin:2px 0 0 2px;"/>
            </div>
        	<div class="card hover_line hand" card="visa" img="images/t_visa.png" style="position: absolute; float:left; width:57px; margin-left:70px;">
        		<img src="images/t_visa.png" style="position:relative; margin:2px 0 0 2px;"/>
            </div>
        	<div class="card hover_line hand" card="paypal" img="images/t_paypal.png" style="position: absolute; float:left; width:57px; margin-left:140px;">
        		<img src="images/t_paypal.png" style="position:relative; margin:2px 0 0 2px;"/>
            </div>                            
        </div>
        <!-- *************************** CAJA # TRANSACCION *************************** -->
        <div style="position: absolute; width:320px; margin:40px 0 0 115px; display:none" id="cont_aprobacion_card" class="font_18">
       		Numero de Aprobacion <span ><img id="icon_card" src="" width="30" height="22" /></span>:
            <input  type="text" id="txt_aprobacion_card" tabindex="1" size="26" />
        </div>
    </div>

    <div id="popup_cambio" style="position: relative; overflow-y: auto; height: 85px; width:435px; ">
        <div id="btnPDF" align="center" style="position:relative; cursor:pointer; width:100px;float:left; ">
            <img src="images/ticket.JPG" /><strong>Ticket</strong>
        </div>
        <div style="position:relative; float:left; width:335px; ">
    	<table class='font_22 negritas' width="100%" border="0">
        <tr>
    		<td align="right" width="70%">Recibe:</td><td align="right">
            	<input type="text" id="recibe" tabindex="2" onkeyup="key_cobrar(event,this)" size="7" align="right"/>
            </td> 
       </tr>
        <tr>
    		<td align="right" width="70%">Cambio:</td><td align="right"><span id="cambio_cliente" style="font-weight:bold;" class="t_naranja_fuerte font_22"></span></td>
        </tr>       
       </table>  
       </div>   
    </div>
    <table class='font_22 negritas' width="100%">
    <tr>
    	<td align="right" width="70%">Total:</td>
        <td class="t_verde_fuerte font_22" id="td_total_cobrar" align="right"></td>
    </tr>
    </table>
</div>      
<div id="dialog_salida_dinero" style="width:650px; display:none">
	<table width="99%" border="0">
        <tr>
            <td>Seleccione un concepto: </td>
            <td align="right">
				<select id="opt_concepto">
                        <option value="retiro" selected="selected">Retiro</option>
                        <option value="ingreso">Ingreso</option>
                </select>             
            </td>
        </tr>
        <tr>
            <td>Cantidad:</td><td align="right"> <input type="text" id="txt_catidad_retiro" class="text_box" /></td>
        </tr>               
        <tr>
            <td colspan="2"><span class="txt_small_1">Motivo:</span></td>
        </tr>  
        <tr>
            <td colspan="2" align="right">
            	<textarea id="txt_comentario_retiro" class="text_area" rows="4" cols="45"></textarea>                  
            </td>
        </tr>             
        <tr>
            <td><div id="txt_motivo_err" style="height:20px;"></div></td>
        </tr>
    </table>    
</div>          
<div id="dialog_ventas_usr" style="width:650px;display:none">
	<div id="ajax_ventas_usr" style="height:380px; overflow-y: auto;"></div>
</div>
<div id="dialog_pagos_usr" style="width:650px;display:none">
	<div id="ajax_pagos_usr" style="height:380px; "></div>
</div>
<div id="ticket_html" style="position:absolute; width:200px; height:auto;"></div>
<!-- *************************** DEVOLUCION DE PRODUCTO *************************** -->
<div id="dialog_dvlcion" style="width:80%;display:none">
    <div class="lst_prod"></div>
    <br>
    <table border=0>
        <tr class="hide">
            <td width="90">Fecha:</td>
            <td width="30">
                <input type="text" name="f_devo" id="f_devo" size="7" maxlength="140" style="height:24px; margin-left:0; display:none;" />
            </td>              
        </tr>
        <tr class="hide">
            <td width="90">Codigo:</td>
            <td align=""> 
                <input type="text" value="hojaCartaColor" id="txt_codigo_dvlcion" onkeypress="key_buscar_producto(event,this)" class="text_box" size="20" />
            </td>  
        </tr>
        <tr >
            <td ><span class="txt_small_1">Motivo:</span><br />(<span id="numtxt_comentario_dvlcion"> 0 </span>/ 1500 )</td>
            <td align="right">
                <textarea id="txt_comentario_dvlcion" class="text_area" rows="4" cols="45" onkeypress="return limita(1500,'txt_comentario_dvlcion', event)"></textarea>                  
            </td>
        </tr>         
    </table>     
    <div id="ajax_dvlcion" style="height:30px; font-size:14px; "></div>
    <div id="ajax_dvlcion_err" style="height:30px; font-size:14px; "></div>
     
</div>
<!-- *************************** PRODUCTO GENERICO *************************** -->
<div id="dialog_generico" style="width:650px;display:none">
    <table>
        <tr>
            <td width="90">Nombre:</td><td align=""> <input type="text" id="txt_nombre_generico" class="text_box" size="50" maxlength="50" /></td>
        </tr>

        <tr> 
        <td width="90">Precio:</td><td align=""> <input type="text" id="txt_costo_generico" class="text_box" size="20" maxlength="8" /></td>
        </tr>  
        <tr> 
        <td width="90">Ganancia:</td><td align=""> <input type="text" id="txt_ganancia_generico" class="text_box" size="20" maxlength="8" /></td>
        </tr>                 
    </table>     
    <div id="ajax_generico" style="height:30px; font-size:14px; "></div>
    <div id="ajax_generico_err" style="height:30px; font-size:14px; "></div>
    <input type="hidden" id="txt_id_prod"  />
</div>
