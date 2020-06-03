<?php
#include("../sesion.php");
		$usuarios_sesion						="PHPSESSID";
		session_name($usuarios_sesion);
		session_start();
		session_cache_limiter('nocache,private');	

#echo $_SESSION["html"];
//============================================================+
// File name   : example_021.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 021 for TCPDF class
//               WriteHTML text flow
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF	
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML text flow.
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
#$html=$_RECUEST[""];
require_once('tcpdf_include.php');
#include('nucleo/tcpdf/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SolesGPS');
$pdf->SetTitle('TCPDF Example 021');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 021', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
/*
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
*/
// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 9);
#$nueva="ALGO";
// add a page
$pdf->AddPage();

// create some HTML content
$html = '<h1>Example of HTML text flow</h1>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. <em>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</em> <em>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</em><br /><br /><b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i><br /><br /><b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u>';
$html = '<h1>Example of HTML text flow</h1>Sed ut perspiciatis unde omnis iste natus error ';
$html = $_SESSION["html"];
$html ='

<table border="0" width="800" height="100%">
    <tr>
        <td colspan="3" align="center">
        	<div>
            
						<div id="base_denue" style="height:100%; width:100%;">
							<div id="div_denue" style="height:100%; overflow:hidden; width:100%; ">								
								
							<div style="height:35px; width:100%; " class="ui-widget-header">
								<table width="100%" height="100%">
									<tr>
										<td align="left" width="33%" style="padding-left:10px; padding-right:10px;"><b>Mostrando registros del 1 al 50 de 1053</b></td>
								
										<td></td>
										<td  width="30" align="center" ><font action="-" name="denue" class="page ui-icon ui-icon-carat-1-w"></font></td>
										<td width="50">
											<select type="report" name="sys_row" id="sys_row">
												<option value="20">20</option>
												<option value="50">50</option>
												<option value="100">100</option>
												<option value="200">200</option>
												<option value="500">500</option>
											</select>
										</td>
										<td width="30" align="center" ><font action="+" name="denue" class="page ui-icon ui-icon-carat-1-e"></font></td>
										<td></td>
								
										<td align="right" width="33%"  style="padding-left:10px; padding-right:10px;"><b>Mostrando la pagina 1 </b></td>
									</tr>
								</table>		
							</div>
                	
                			
											
								<table width="100%" style="background-color:#fff;">
										    <tr class="{class} ui-widget-header" style="height:40px;">
		        <td width="50" style="padding:8px ;">
		        </td>        
		        <td class="title">
					<div name="title_denue">
							<font class="sys_order" name="denue" sys_order="id" sys_torder="ASC">id</font>
					</div>
				</td>
		        <td class="title">
					<div name="title_denue">
							<font class="sys_order" name="denue" sys_order="empresa" sys_torder="ASC">empresa</font>
					</div>
				</td>
		        <td class="title">
					<div name="title_denue">
							<font class="sys_order" name="denue" sys_order="razon_social" sys_torder="ASC">razon_social</font>
					</div>
				</td>		    
		        <td class="title">
					<div name="title_denue">
							<font class="sys_order" name="denue" sys_order="actividad" sys_torder="ASC">actividad</font>
					</div>
				</td>		    
		        <td class="title">
					<div name="title_denue">
							<font class="sys_order" name="denue" sys_order="vialidad" sys_torder="ASC">vialidad</font>
					</div>
				</td>
		        <td class="title">
					<div name="title_denue">
							<font class="sys_order" name="denue" sys_order="exterior" sys_torder="ASC">exterior</font>
					</div>
				</td>
		        <td class="title">
					<div name="title_denue">
							<font class="sys_order" name="denue" sys_order="telefono" sys_torder="ASC">telefono</font>
					</div>
				</td>
		        <td class="title">
					<div name="title_denue">
							<font class="sys_order" name="denue" sys_order="mail" sys_torder="ASC">Mail</font>
					</div>
				</td>
		    </tr>     



								            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
315748</td>
		        <td style="color:black;" >OFICINA DE SISTEMATIZACION</td>
		        <td style="color:black;" >SINTESIS COMERCIO INTERNACIONAL SISTEMATIZADO, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Autotransporte local de materiales para la construcci�n</td>		    
		        <td style="color:black;" >LICENCIADO MIGUEL DE LA MADRID HURTADO</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3143364115</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
315749</td>
		        <td style="color:black;" >TRANSPORTES JOSE GUAJARDO</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Otro autotransporte for�neo de carga general</td>		    
		        <td style="color:black;" >ESTEBAN GARC�A</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" ></td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
315765</td>
		        <td style="color:black;" >AUTOPARTES AMERICANAS</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de partes y refacciones nuevas para autom�viles, camionetas y camiones</td>		    
		        <td style="color:black;" >DE LOS MAESTROS</td>
		        <td style="color:black;" >393</td>
		        <td style="color:black;" >3123134870</td>
		        <td style="color:black;" >AUTOPARTES009@LIVE.COM.MX</td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
315874</td>
		        <td style="color:black;" >CONSTRUCCI�N DE TERRAZAS TODO TIPO</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Realizaci�n de trabajos de carpinter�a en el lugar de la construcci�n</td>		    
		        <td style="color:black;" >MONTHATLAN</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123203783</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
315882</td>
		        <td style="color:black;" >SERVICIOS DE MANTENIMIENTO A EMPRESAS, S.A. DE C.V.</td>
		        <td style="color:black;" >SERVICIOS DE MANTENIMIENTO A EMPRESAS S.A. DE., C.V.</td>		    
		        <td style="color:black;" >Trabajos de alba�iler�a</td>		    
		        <td style="color:black;" >REP�BLICA MEXICANA</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123230117</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316039</td>
		        <td style="color:black;" >GARANTIAS Y SERVICIOS DE COLIMA</td>
		        <td style="color:black;" >GARANTIAS Y SERVICIOS DE COLIMA, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Instalaciones de sistemas centrales de aire acondicionado y calefacci�n</td>		    
		        <td style="color:black;" >FELIPE SEVILLA DEL R�O</td>
		        <td style="color:black;" >92</td>
		        <td style="color:black;" >3123141414</td>
		        <td style="color:black;" >GARANTIASYSERVICIOS@HOTMAIL.COM</td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316090</td>
		        <td style="color:black;" >TALLER DE INSTALACIONES DE AIRES ACONDICIONADOS Y CALENTADORES</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Instalaciones de sistemas centrales de aire acondicionado y calefacci�n</td>		    
		        <td style="color:black;" >GUTI�RREZ N�JERA</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123121672</td>
		        <td style="color:black;" >K1INSTALA@HOTMAIL.COM</td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316262</td>
		        <td style="color:black;" >TRANSPORTES LEX</td>
		        <td style="color:black;" >TRANSPORTES LEX, S. DE R.L. DE C.V.</td>		    
		        <td style="color:black;" >Otro autotransporte for�neo de carga general</td>		    
		        <td style="color:black;" >MAR�A DEL REFUGIO MORALES</td>
		        <td style="color:black;" >584</td>
		        <td style="color:black;" >3123300987</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316467</td>
		        <td style="color:black;" >GDL COL SERVICIO EXPRESS</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Servicios de mensajer�a y paqueter�a for�nea</td>		    
		        <td style="color:black;" >LIBRAMIENTO GENERAL MARCELINO GARC�A BARRAG�N</td>
		        <td style="color:black;" >1420</td>
		        <td style="color:black;" >3123139580</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316484</td>
		        <td style="color:black;" >REFACCIONES Y SERVICIOS LOBOS DISEL</td>
		        <td style="color:black;" >LOBOS DIESEL REFACCIONES Y SERVICIOS, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Comercio al por mayor de partes y refacciones nuevas para autom�viles, camionetas y camiones</td>		    
		        <td style="color:black;" >LIBRAMIENTO GENERAL MARCELINO GARC�A BARRAG�N</td>
		        <td style="color:black;" >658</td>
		        <td style="color:black;" >312313810</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316597</td>
		        <td style="color:black;" >PROVEEDORA DE CARNES SAN MARCOS</td>
		        <td style="color:black;" >PROVEEDORA DE CARNES SAN MARCOS, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Comercio al por mayor de carnes rojas</td>		    
		        <td style="color:black;" >BUGAMBILIA</td>
		        <td style="color:black;" >1758</td>
		        <td style="color:black;" >3123071615</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316612</td>
		        <td style="color:black;" >PROYECTOS Y CONSTRUCCIONES ELECTROMECANICAS DE COLIMA, S.A. DE C.V.</td>
		        <td style="color:black;" >PROYECTOS Y CONSTRUCCIONES ELECTROMECANICAS DE COLIMA, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Instalaciones el�ctricas en construcciones</td>		    
		        <td style="color:black;" >B</td>
		        <td style="color:black;" >11</td>
		        <td style="color:black;" >3123080189</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316711</td>
		        <td style="color:black;" >GRUAS RODRIGUEZ</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Servicios de gr�a</td>		    
		        <td style="color:black;" >GABINO BARREDA</td>
		        <td style="color:black;" >467</td>
		        <td style="color:black;" >3123120799</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316718</td>
		        <td style="color:black;" >ELECTRICIDAD EN GENERAL</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Instalaciones el�ctricas en construcciones</td>		    
		        <td style="color:black;" >CONSTITUCI�N</td>
		        <td style="color:black;" >404</td>
		        <td style="color:black;" ></td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
316801</td>
		        <td style="color:black;" >MATERIAS PRIMAS ALCARAZ</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de abarrotes</td>		    
		        <td style="color:black;" >VALENT�N G�MEZ FAR�AS</td>
		        <td style="color:black;" >168</td>
		        <td style="color:black;" >3123135725</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
317018</td>
		        <td style="color:black;" >POTOSINOS EXPRESS PACK, S.A. DE C.V.</td>
		        <td style="color:black;" >POTOSINOS EXPRESS PACK, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Otro autotransporte for�neo de carga general</td>		    
		        <td style="color:black;" >CAMINO REAL DE COLIMA</td>
		        <td style="color:black;" >346</td>
		        <td style="color:black;" >3123303212</td>
		        <td style="color:black;" >GPADILLA@POTOSINOS.COM.MX</td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
317136</td>
		        <td style="color:black;" >REDPACK</td>
		        <td style="color:black;" >REDPACK SA DE CV</td>		    
		        <td style="color:black;" >Servicios de mensajer�a y paqueter�a for�nea</td>		    
		        <td style="color:black;" >SAN FERNANDO</td>
		        <td style="color:black;" >503</td>
		        <td style="color:black;" >3123146766</td>
		        <td style="color:black;" >CLQ@REDPACK.COM.MX</td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
317153</td>
		        <td style="color:black;" >ESTAFETA MEXICANA</td>
		        <td style="color:black;" >ESTAFETA MEXICANA, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Servicios de mensajer�a y paqueter�a for�nea</td>		    
		        <td style="color:black;" >SAN FERNANDO</td>
		        <td style="color:black;" >496</td>
		        <td style="color:black;" >3123141217</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
317264</td>
		        <td style="color:black;" >MENSAJER�A Y PAQUETERIA MANZANILLO EXPRESS</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Servicios de mensajer�a y paqueter�a for�nea</td>		    
		        <td style="color:black;" >COLIMA</td>
		        <td style="color:black;" >590</td>
		        <td style="color:black;" >3123135544</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
317270</td>
		        <td style="color:black;" >OCASA</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de huevo</td>		    
		        <td style="color:black;" >TECOM�N</td>
		        <td style="color:black;" >406</td>
		        <td style="color:black;" >3123126628</td>
		        <td style="color:black;" >OCASAVENTAS@HOTMAIL.COM</td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
317322</td>
		        <td style="color:black;" >PAQUETERIA Y MENSAJER�A DPT EXPRESS</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Servicios de mensajer�a y paqueter�a for�nea</td>		    
		        <td style="color:black;" >GONZALO DE SANDOVAL</td>
		        <td style="color:black;" >1200</td>
		        <td style="color:black;" >3123078050</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
317409</td>
		        <td style="color:black;" >MATERIALES HERRAMIENTAS DE LLANTAS</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Otros servicios de almacenamiento general sin instalaciones especializadas</td>		    
		        <td style="color:black;" >NI�OS H�ROES DE CHAPULTEPEC</td>
		        <td style="color:black;" >1365</td>
		        <td style="color:black;" ></td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318469</td>
		        <td style="color:black;" >REFRIAIRE DE COLIMA</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Instalaciones de sistemas centrales de aire acondicionado y calefacci�n</td>		    
		        <td style="color:black;" >FRANCISCO I. MADERO</td>
		        <td style="color:black;" >478</td>
		        <td style="color:black;" >31231212</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318569</td>
		        <td style="color:black;" >COMPA��A TERMINAL DE MANZANILLO, S.A. DE C.V.</td>
		        <td style="color:black;" >COMPA��A TERMINAL DE MANZANILLO, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Servicios de carga y descarga para el transporte por agua</td>		    
		        <td style="color:black;" >TENIENTE AZUETA</td>
		        <td style="color:black;" >12</td>
		        <td style="color:black;" >3143325818</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318637</td>
		        <td style="color:black;" >CARPINTER�A RESIDENCIAL DE COLIMA</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Realizaci�n de trabajos de carpinter�a en el lugar de la construcci�n</td>		    
		        <td style="color:black;" >COLIMA</td>
		        <td style="color:black;" >362</td>
		        <td style="color:black;" >3123124902</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318658</td>
		        <td style="color:black;" >SERVICIOS DE TRANSPORTE URBANO Y SUBURBANO DE PASAJEROS</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Transporte colectivo urbano y suburbano de pasajeros en autobuses de ruta fija</td>		    
		        <td style="color:black;" >NI�OS H�ROES DE CHAPULTEPEC</td>
		        <td style="color:black;" >1229</td>
		        <td style="color:black;" >3121361183</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318678</td>
		        <td style="color:black;" >ADMINISTRACI�N PORTUARIA INTEGRAL DE MANZANILLO, S.A. DE C.V.</td>
		        <td style="color:black;" >ADMINISTRACI�N PORTUARIA INTEGRAL DE MANZANILLO, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Administraci�n de puertos y muelles</td>		    
		        <td style="color:black;" >TENIENTE AZUETA</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3143311400</td>
		        <td style="color:black;" >GADMON@PUERTOMANZANILLO.COM.MX</td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318748</td>
		        <td style="color:black;" >SEMILLAS Y CEREALES SOSA</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de abarrotes</td>		    
		        <td style="color:black;" >JIM�NEZ</td>
		        <td style="color:black;" >152</td>
		        <td style="color:black;" >3121654013</td>
		        <td style="color:black;" >JERARDOSOSA@OUTLOOK.COM</td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318786</td>
		        <td style="color:black;" >REFACCIONARIA LA BIELA DE COLIMA</td>
		        <td style="color:black;" >REFACCIONARIA LA BIELA DE COLIMA, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Comercio al por mayor de partes y refacciones nuevas para autom�viles, camionetas y camiones</td>		    
		        <td style="color:black;" >REY COLIMAN</td>
		        <td style="color:black;" >275</td>
		        <td style="color:black;" >3123309193</td>
		        <td style="color:black;" >LA_BIELA_COL.@HOTMAIL.COM</td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318795</td>
		        <td style="color:black;" >DEPOSITO EL OASIS</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de cerveza</td>		    
		        <td style="color:black;" >REY COLIMAN</td>
		        <td style="color:black;" >298</td>
		        <td style="color:black;" >3123120364</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318842</td>
		        <td style="color:black;" >PAQUETRIA Y MENSAJER�A FLECHA AMARILLA</td>
		        <td style="color:black;" >SERVICIOS DE PAQUETERIA Y ENVIOS FLECHA AMARILLA, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Transporte colectivo for�neo de pasajeros de ruta fija</td>		    
		        <td style="color:black;" >LERDO DE TEJADA</td>
		        <td style="color:black;" >449</td>
		        <td style="color:black;" >3123121260</td>
		        <td style="color:black;" >PACCOLIFA@PRODIGY.NET.MX</td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
318944</td>
		        <td style="color:black;" >BODEGA DE PLATANOS SIN NOMBRE</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de frutas y verduras frescas</td>		    
		        <td style="color:black;" >N��EZ BUENROSTRO</td>
		        <td style="color:black;" >221</td>
		        <td style="color:black;" ></td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319108</td>
		        <td style="color:black;" >AIRE ACONDICIONADO IGLU</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Instalaciones de sistemas centrales de aire acondicionado y calefacci�n</td>		    
		        <td style="color:black;" >FRANCISCO I. MADERO</td>
		        <td style="color:black;" >718</td>
		        <td style="color:black;" >3123120259</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319271</td>
		        <td style="color:black;" >AUTOBUSES ESTRELLA BLANCA</td>
		        <td style="color:black;" >ESTRELLA BLANCA SA DE CV</td>		    
		        <td style="color:black;" >Transporte colectivo for�neo de pasajeros de ruta fija</td>		    
		        <td style="color:black;" >NINGUNO</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123128499</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319272</td>
		        <td style="color:black;" >ODM EXPRESS</td>
		        <td style="color:black;" >OMNICARGA SA DE CV</td>		    
		        <td style="color:black;" >Servicios de mensajer�a y paqueter�a local</td>		    
		        <td style="color:black;" >NINGUNO</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123078048</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319273</td>
		        <td style="color:black;" >OMNIBUS DE M�XICO</td>
		        <td style="color:black;" >SERVICIOS ADMINISTRATIVOS OMNIBUS DE MEXICO, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Transporte colectivo for�neo de pasajeros de ruta fija</td>		    
		        <td style="color:black;" >NINGUNO</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123121630</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319274</td>
		        <td style="color:black;" >LA LINEA PLUS</td>
		        <td style="color:black;" >AUTOTRANSPORTE DEL SUR DE JALISCO, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Transporte colectivo for�neo de pasajeros de ruta fija</td>		    
		        <td style="color:black;" >NINGUNO</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123120508</td>
		        <td style="color:black;" >CESTANCIA@GHU.MX</td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319275</td>
		        <td style="color:black;" >GRUPO FLECHA AMARILLA</td>
		        <td style="color:black;" >AUTOBUSES LA ALTE�A, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Transporte colectivo for�neo de pasajeros de ruta fija</td>		    
		        <td style="color:black;" >NINGUNO</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123121135</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319276</td>
		        <td style="color:black;" >ETN</td>
		        <td style="color:black;" >ETN TURISTAR LUJO, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Transporte colectivo for�neo de pasajeros de ruta fija</td>		    
		        <td style="color:black;" >NINGUNO</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >31125899</td>
		        <td style="color:black;" >COLIMA@ETN.COM.MX</td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319347</td>
		        <td style="color:black;" >BA�OS DE CENTRAL DE AUTOBUSES</td>
		        <td style="color:black;" >CENTRAL DE AUTOBUSES DE COLIMA, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Servicios de administraci�n de centrales camioneras</td>		    
		        <td style="color:black;" >NINGUNO</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" ></td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319357</td>
		        <td style="color:black;" >HARINERA DE MINSA SIN NOMBRE</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de dulces y materias primas para reposter�a</td>		    
		        <td style="color:black;" >SONORA</td>
		        <td style="color:black;" >1453</td>
		        <td style="color:black;" >3123131530</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319538</td>
		        <td style="color:black;" >GR�AS RODR�GUEZ</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Servicios de gr�a</td>		    
		        <td style="color:black;" >SIERRA MADRE OCCIDENTAL</td>
		        <td style="color:black;" >77</td>
		        <td style="color:black;" >3123120799</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319542</td>
		        <td style="color:black;" >SERVICIOS DE GRUAS RAF</td>
		        <td style="color:black;" >SERVICIOS DE GRUAS RAF, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Servicios de gr�a</td>		    
		        <td style="color:black;" >CAZADORES</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123120784</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319795</td>
		        <td style="color:black;" >IMPACTO ELECTRIFICACIONES S.A. DE C.V. IESA</td>
		        <td style="color:black;" >IMPACTO ELECTRIFICACIONES, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Instalaciones el�ctricas en construcciones</td>		    
		        <td style="color:black;" >16 DE SEPTIEMBRE</td>
		        <td style="color:black;" >267</td>
		        <td style="color:black;" >3123149858</td>
		        <td style="color:black;" >IMPACTOELECTRIFICACIONES@YAHOO.COM.MX</td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
319967</td>
		        <td style="color:black;" >AUTOBUSES NUEVO HORIZONTE, S.A. DE C.V.</td>
		        <td style="color:black;" >AUTOBUSES NUEVO HORIZONTE, S.A. DE C.V.</td>		    
		        <td style="color:black;" >Transporte colectivo urbano y suburbano de pasajeros en autobuses de ruta fija</td>		    
		        <td style="color:black;" >AVENIDA BENITO JU�REZ</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" >3123122717</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
320227</td>
		        <td style="color:black;" >GRUAS EL MEZQUITE</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Servicios de gr�a</td>		    
		        <td style="color:black;" >JULI�N CARRILLO</td>
		        <td style="color:black;" >528</td>
		        <td style="color:black;" >3123306040</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
320416</td>
		        <td style="color:black;" >CENTRAL CEBOLLERA MORENO</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de frutas y verduras frescas</td>		    
		        <td style="color:black;" >REFORMA</td>
		        <td style="color:black;" >186</td>
		        <td style="color:black;" ></td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
320428</td>
		        <td style="color:black;" >CARNICER�A SAN CARLOS</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de carnes rojas</td>		    
		        <td style="color:black;" >MEDELL�N</td>
		        <td style="color:black;" >219</td>
		        <td style="color:black;" >3123142867</td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=odd>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
320431</td>
		        <td style="color:black;" >BODEGA LA GUADALUPANA</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de frutas y verduras frescas</td>		    
		        <td style="color:black;" >GALEANA</td>
		        <td style="color:black;" >3</td>
		        <td style="color:black;" ></td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

            
		    <tr  class=even>
		        <td width="50">
                    
		        </td>
		        <td style="color:black;" >
320432</td>
		        <td style="color:black;" >BODEGA DE ABARROTES CECY</td>
		        <td style="color:black;" ></td>		    
		        <td style="color:black;" >Comercio al por mayor de abarrotes</td>		    
		        <td style="color:black;" >MANUEL ABASOLO</td>
		        <td style="color:black;" >0</td>
		        <td style="color:black;" ></td>
		        <td style="color:black;" ></td>    
		    </tr>    
            

							
								</table>

								<input name="sys_order_denue" id="sys_order_denue" type="hidden" value="">		
								<input name="sys_torder_denue" id="sys_torder_denue" type="hidden" value="">
								<input name="sys_page_denue" id="sys_page_denue" type="hidden" value="1">
								<input name="sys_row_denue" id="sys_row_denue" type="hidden" value="50">
							</div>
						</div>		
						<script>						
							$(".page").click(function(){
								var action      	=$(this).attr("action");						    
								var sys_page    	=$("#sys_page_denue").val();
								if(action=="-")   sys_page--;
								else                sys_page++;
						
								$("#sys_page_denue").val(sys_page);
								$("form").submit(); 
							});				
							$(".title").resizable({
								handles: "e"
							});
						</script>							
					             
            </div>
        </td>        
    </tr>
</table>
			
';
#$html = $_SESSION["html"];							
// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_021.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
