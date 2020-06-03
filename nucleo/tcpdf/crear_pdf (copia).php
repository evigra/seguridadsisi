<?php
#	include("../sesion.php");
	$usuarios_sesion						="PHPSESSID";
	session_name($usuarios_sesion);
	session_start();
	session_cache_limiter('nocache,private');	

	
	
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
	if(@file_exists("tcpdf_include.php")) 			require_once('tcpdf_include.php');
	if(@file_exists("../tcpdf_include.php")) 		require_once('../tcpdf_include.php');
	if(@file_exists("../../tcpdf_include.php")) 	require_once('../../tcpdf_include.php');
	if(@file_exists("../../../tcpdf_include.php")) 	require_once('../../../tcpdf_include.php');
	
#include('nucleo/tcpdf/tcpdf_include.php');

// create new PDF document
	$pdf = new TCPDF(
		$_SESSION["pdf"]["PDF_PAGE_ORIENTATION"], 
		$_SESSION["pdf"]["PDF_UNIT"], 
		$_SESSION["pdf"]["PDF_PAGE_FORMAT"], 
		true, 'UTF-8', false
	);
	

// set document information
/*
echo "<pre>";
print_r($_SESSION);
echo "/<pre>";
*/
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('CEO ISC Eduardo Vizcaino Granados');
	$pdf->SetTitle($_SESSION["pdf"]["title"]);
	#$pdf->SetTitle('algo');
	#$pdf->SetSubject($_SESSION["pdf"]["subject"]);
	#$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	
// set default header data
	#$pdf->writeHTML("LALO ES CABRON", true, 0, true, 0);
	
	#$pdf->endTemplate();
	#$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 021', PDF_HEADER_STRING);
	#$pdf->SetHeaderData(PDF_HEADER_LOGO, $_SESSION["pdf"]["PDF_HEADER_LOGO_WIDTH"], $_SESSION["pdf"]["title"], $_SESSION["pdf"]["subject"]);
	
	#$template								=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS_HOR");
	

	
// set header and footer fonts
	#$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	#$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
#	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
	#$pdf->SetHeaderMargin(15);   #MARGEN SUPERIOR

		
	
	#$_SESSION["pdf"]["PDF_MARGIN_TOP"]=
	
	#$_SESSION["pdf"]["HEADER"]["height"]
	if(isset($_SESSION["pdf"]["HEADER"]))
		$pdf->SetMargins(PDF_MARGIN_LEFT, $_SESSION["pdf"]["PDF_MARGIN_TOP"], PDF_MARGIN_RIGHT);
	#$pdf->SetMargins(PDF_MARGIN_LEFT, 31, PDF_MARGIN_RIGHT);
	
	if(isset($_SESSION["pdf"]["PAGE"]))
		$pdf->SetFooterMargin($_SESSION["pdf"]["PAGE"]);

// set auto page breaks
	#$pdf->SetAutoPageBreak(TRUE, 10);

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
#echo $_SESSION["html"];
	$html = $_SESSION["pdf"]["template"];
	#echo $_SESSION["pdf"]["template"];
	unset($_SESSION["pdf"]["template"]);
	#$html = "LALO";
#echo $html;
// output the HTML content
	$pdf->writeHTML($html, true, 0, true, 0);
#echo $html;
// reset pointer to the last page
	$pdf->lastPage();

	if(!isset($_SESSION["pdf"]["save_name"]))	$_SESSION["pdf"]["save_name"]=$_SESSION["pdf"]["title"];

//Close and output PDF document
	$pdf->Output($_SESSION["pdf"]["save_name"], 'I');

//============================================================+
// END OF FILE
//============================================================+
