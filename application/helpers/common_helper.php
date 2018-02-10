<?php



/*



function array_to_object($array) {



    if(!is_array($array)) {



        return $array;



    }



    



    $object = new stdClass();



    if (is_array($array) && count($array) > 0) {



      foreach ($array as $name=>$value) {



         $name = strtolower(trim($name));



         if (!empty($name)) {



            $object->$name = array_to_object($value);



         }



      }



      return $object; 



    }



    else {



      return FALSE;



    }



}







*/











function array_to_object($d) {



	if (is_array($d)) {



		/*



		* Return array converted to object



		* Using __FUNCTION__ (Magic constant)



		* for recursive call



		*/



		return (object) array_map(__FUNCTION__, $d);



	}



	else {



		// Return object



		return $d;



	}



}











function object_to_array($object) {



    if( !is_object( $object ) && !is_array( $object ) ) {



        return $object;



    }



    if( is_object( $object ) ) {



        $object = (array) $object;



    }



    return array_map( 'object_to_array', $object );



}







function slugify($text){ 



	  // replace non letter or digits by -



	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);



	



	  // trim



	  $text = trim($text, '-');



	



	  // transliterate



	  //$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);



	



	  // lowercase



	  $text = strtolower($text);



	



	  // remove unwanted characters



	  $text = preg_replace('~[^-\w]+~', '', $text);



	



	  if (empty($text))



	  {



	    return 'n-a-'.rand(1,99999);



	  }



	  return $text;



}







function format_title($params){



	



}







function _echo(&$argument, $default="") {



   if(isset($argument)) {



       echo $argument;



   }else{



	   echo $default;



   }



}















/**



 * trims text to a space then adds ellipses if desired



 * @param string $input text to trim



 * @param int $length in characters to trim to



 * @param bool $ellipses if ellipses (...) are to be added



 * @param bool $strip_html if html tags are to be stripped



 * @return string 



 */



function trim_text($input, $length, $ellipses = true, $strip_html = true) {



    //strip tags, if desired



    if ($strip_html) {



        $input = strip_tags($input);



    }



  



    //no need to trim, already shorter than trim length



    if (strlen($input) <= $length) {



        return $input;



    }



  



    //find last space within length



    $last_space = strrpos(substr($input, 0, $length), ' ');



    $trimmed_text = substr($input, 0, $last_space);



  



    //add ellipses (...)



    if ($ellipses) {



        $trimmed_text .= '...';



    }



  



    return $trimmed_text;



}







function stateToAbbr($stateName){



	$stateLists = array('alabama' => 'al','alaska' => 'ak','arizona' => 'az','arkansas' => 'ar','california' => 'ca','colorado' => 'co','connecticut' => 'ct','delaware' => 'de','florida' => 'fl','georgia' => 'ga','hawaii' => 'hi','idaho' => 'id','illinois' => 'il','indiana' => 'in','iowa' => 'ia','kansas' => 'ks','kentucky' => 'ky','louisiana' => 'la','maine' => 'me','maryland' => 'md','massachusetts' => 'ma','michigan' => 'mi','minnesota' => 'mn','mississippi' => 'ms','missouri' => 'mo','montana' => 'mt','nebraska' => 'ne','nevada' => 'nv','new hampshire' => 'nh','new jersey' => 'nj','new mexico' => 'nm','new york' => 'ny','north carolina' => 'nc','north dakota' => 'nd','ohio' => 'oh','oklahoma' => 'ok','oregon' => 'or','pennsylvania' => 'pa','rhode island' => 'ri','south carolina' => 'sc','south dakota' => 'sd','tennessee' => 'tn','texas' => 'tx','utah' => 'ut','vermont' => 'vt','virginia' => 'va','washington' => 'wa','west virginia' => 'wv','wisconsin' => 'wi','wyoming' => 'wy','american samoa' => 'as','district of columbia' => 'dc','federated states of micronesia' => 'fm','guam' => 'gu','marshall islands' => 'mh','northern mariana islands' => 'mp','palau' => 'pw','puerto rico' => 'pr','virgin islands' => 'vi','armed forces americas' => 'aa','armed forces pacific' => 'ap');



	if(array_key_exists(strtolower($stateName),$stateLists)){



		return $stateLists[strtolower($stateName)];



	}else{



		return '';



	}



}







function str_to_csv($input, $delimiter = ',', $enclosure = '"', $escape = '\\', $eol = '\n') {



	if (is_string($input) && !empty($input)) {



		$output = array();



		$tmp    = preg_split("/".$eol."/",$input);



		if (is_array($tmp) && !empty($tmp)) {



			while (list($line_num, $line) = each($tmp)) {



				if (preg_match("/".$escape.$enclosure."/",$line)) {



					while ($strlen = strlen($line)) {



						$pos_delimiter       = strpos($line,$delimiter);



						$pos_enclosure_start = strpos($line,$enclosure);



						if (



							is_int($pos_delimiter) && is_int($pos_enclosure_start)



							&& ($pos_enclosure_start < $pos_delimiter)



							) {



							$enclosed_str = substr($line,1);



							$pos_enclosure_end = strpos($enclosed_str,$enclosure);



							$enclosed_str = substr($enclosed_str,0,$pos_enclosure_end);



							$output[$line_num][] = $enclosed_str;



							$offset = $pos_enclosure_end+3;



						} else {



							if (empty($pos_delimiter) && empty($pos_enclosure_start)) {



								$output[$line_num][] = substr($line,0);



								$offset = strlen($line);



							} else {



								$output[$line_num][] = substr($line,0,$pos_delimiter);



								$offset = (



											!empty($pos_enclosure_start)



											&& ($pos_enclosure_start < $pos_delimiter)



											)



											?$pos_enclosure_start



											:$pos_delimiter+1;



							}



						}



						$line = substr($line,$offset);



					}



				} else {



					$line = preg_split("/".$delimiter."/",$line);







					/*



					 * Validating against pesky extra line breaks creating false rows.



					 */



					if (is_array($line) && !empty($line[0])) {



						$output[$line_num] = $line;



					} 



				}



			}



			return $output;



		} else {



			return false;



		}



	} else {



		return false;



	}



}


function limit_character($string, $limit=100, $break=".", $pad="...") {
 // return with no change if string is shorter than $limit
 if(strlen($string) <= $limit) return $string;

 // is $break present between $limit and the end of the string?
 //if(false !== ($breakpoint = strpos($string, $break, $limit))) {
   //if($breakpoint < strlen($string) - 1) {
     $string = substr($string, 0, $limit) . $pad;
   //}
 //}

 return $string;
}


function limit_words($string, $word_limit=50, $pad="...")
{
   $words = explode(" ",$string);
   $count = count($words);

   if($count >= $word_limit) {
    $content = implode(" ",array_splice($words,0,$word_limit));
  $content = $content.$pad;
   } else {
    $content = implode(" ",  $words);
   }
   
   return strip_tags($content);
}



