<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Terbilang Helper
 *
 * @package	CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author	Achyar Anshorie
 */

if ( ! function_exists('number_to_words'))
{
	function number_to_words($number)
	{
		$before_comma = trim(to_word($number));
		$after_comma = trim(comma($number));
		if($after_comma == ''){
		    return ucwords($results = $before_comma.' Rupiah');
		} else {
		    return ucwords($results = $before_comma.' Koma '.$after_comma.' Rupiah');
		}
	}

	function to_word($number)
	{
		$words = "";
		$arr_number = array(
		"",
		"Satu",
		"Dua",
		"Tiga",
		"Empat",
		"Lima",
		"Enam",
		"Tujuh",
		"Delapan",
		"Sembilan",
		"Sepuluh",
		"Sebelas");

		if($number<12)
		{
			$words = " ".$arr_number[$number];
		}
		else if($number<20)
		{
			$words = to_word($number-10)." Belas";
		}
		else if($number<100)
		{
			$words = to_word($number/10)." Puluh ".to_word($number%10);
		}
		else if($number<200)
		{
			$words = "Seratus ".to_word($number-100);
		}
		else if($number<1000)
		{
			$words = to_word($number/100)." Ratus ".to_word($number%100);
		}
		else if($number<2000)
		{
			$words = "Seribu ".to_word($number-1000);
		}
		else if($number<1000000)
		{
			$words = to_word($number/1000)." Ribu ".to_word($number%1000);
		}
		else if($number<1000000000)
		{
			$words = to_word($number/1000000)." Juta ".to_word($number%1000000);
		}
		else
		{
			$words = "undefined";
		}
		return $words;
	}

	function comma($number)
	{
		$after_comma = stristr($number,',');
		$arr_number = array(
		"Nol",
		"Satu",
		"Dua",
		"Tiga",
		"Empat",
		"Lima",
		"Enam",
		"Tujuh",
		"Delapan",
		"Sembilan");

		$results = "";
		$length = strlen($after_comma);
		$i = 1;
		while($i<$length)
		{
			$get = substr($after_comma,$i,1);
			$results .= " ".$arr_number[$get];
			$i++;
		}
		return $results;
	}
}
