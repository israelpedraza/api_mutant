<?php
/**
 *
 * @package	GUARUMO GENERAL HELPER
 * @author	GUARUMO
 * @copyright	Copyright (c) GUARUMO 2016  
 */
defined('BASEPATH') OR exit('No direct script access allowed');


// ------------------------------------------------------------------------

if ( ! function_exists('formato_dinero'))
{
	/**
	 * FORMATO DINERO
	 *
	 * FORMATEA UN ENTERO COMO DINERO Y LA RETORNA
	 *
	 * @param	mixed	El valor a formatear
	 * @param	string	El tipo de separador para filtrar
	 * @param	string	El tipo de union para pegar
	 * @return	string
	 */
	function formato_dinero($valor = 0,$separador='.', $union=',')
	{	
		$valor = trim($valor);
		if(empty($valor)) $valor= 0;
		if(!is_numeric($valor)) $valor = intval($valor);
		$valor = explode($separador, $valor);
		$valor[0] = number_format($valor[0]);
		$valor = implode($union, $valor);

		return $valor;		
	}
	
}

	/**
	 * FORMATO FECHA
	 *
	 * FORMATEA UNA FECHA NUMERAL A FORMATO TEXTUAL
	 *
	 * @param	mixed	La fecha	 
	 * @return	string 	Si se especifica $merge = TRUE
	 * @return	array 	Si no se especifica $merge o $merge = FALSE
	 */

if(! function_exists('formato_fecha'))
{
	function formato_fecha($date, $merge = FALSE){
		$date = explode('-', $date);

		$year = $date[0];
		$nmonth = $date[1];
		$month = $date[1];
		$short = "";
		$day = $date[2];

		if($month == '01'){$month = "Enero";	$short = "Ene";}
		if($month == '02'){$month = "Febrero";	$short = "Feb";}
		if($month == '03'){$month = "Marzo";	$short = "Mar";}
		if($month == '04'){$month = "Abril";	$short = "Abr";}
		if($month == '05'){$month = "Mayo";		$short = "May";}
		if($month == '06'){$month = "Junio";	$short = "Jun";}
		if($month == '07'){$month = "Julio";	$short = "Jul";}
		if($month == '08'){$month = "Agosto";	$short = "Ago";}
		if($month == '09'){$month = "Septiembre";$short = "Sep";}
		if($month == '10'){$month = "Octubre";	$short = "Oct";}
		if($month == '11'){$month = "Noviembre";$short = "Nov";}
		if($month == '12'){$month = "Diciembre";$short = "Dic";}

		if($merge)return $day." de ".$month." de ".$year;
		return array('ano'=>$year,'nmes'=>$nmonth,'mes'=>$month,'smes'=>$short,'dia'=>$day);
	}
}


if(! function_exists('formato_timestamp'))
{
	function formato_timestamp($date, $merge = FALSE, $format = 'j-M-y h.i.s.u A'){

		$date = DateTime::createFromFormat($format,$date);
		$hour = $date->format('H:i:s');
		$date = $date->format('Y-m-d');		
		if(!$hour)$hour = "";

		$date = explode('-', $date);

		$year = $date[0];
		$nmonth = $date[1];
		$month = $date[1];
		$short = "";
		$day = $date[2];


		if($month == '01'){$month = "Enero";	$short = "Ene";}
		if($month == '02'){$month = "Febrero";	$short = "Feb";}
		if($month == '03'){$month = "Marzo";	$short = "Mar";}
		if($month == '04'){$month = "Abril";	$short = "Abr";}
		if($month == '05'){$month = "Mayo";		$short = "May";}
		if($month == '06'){$month = "Junio";	$short = "Jun";}
		if($month == '07'){$month = "Julio";	$short = "Jul";}
		if($month == '08'){$month = "Agosto";	$short = "Ago";}
		if($month == '09'){$month = "Septiembre";$short = "Sep";}
		if($month == '10'){$month = "Octubre";	$short = "Oct";}
		if($month == '11'){$month = "Noviembre";$short = "Nov";}
		if($month == '12'){$month = "Diciembre";$short = "Dic";}

		$data = array(
			'ano'=>$year,
			'nmes'=>$nmonth,
			'mes'=>$month,
			'smes'=>$short,
			'dia'=>$day
		);

		if($hour)$data["hora"] = $hour;

		if($merge)return $day." de ".$month." de ".$year." ".$hour;
		return $data;
	}
}


if(! function_exists('remove_accent')){

	function remove_accent($str){
		$a = array('??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??');
  		$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
 		return str_replace($a, $b, $str); 
	}
}
	
if(! function_exists('post_slug')){

	function post_slug($str)
	{
	  return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'),
	  array('', '-', ''), remove_accent($str)));
	} 
}

if(! function_exists('validar_fecha')){

	function validar_fecha($date, $format = 'Y-m-d'){
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
}
	
