<?php

if (!function_exists('ISO8601ToSeconds')) {
    function ISO8601ToSeconds($ISO8601){
        $interval = new \DateInterval($ISO8601);

        return ($interval->d * 24 * 60 * 60) +
            ($interval->h * 60 * 60) +
            ($interval->i * 60) +
            $interval->s;
    }
}

if (!function_exists('secondsToTime')) {
    function secondsToTime($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        $result = $dtF->diff($dtT)->format('%a days, %h:%i:%s');
        $exp = explode(', ', $result);
        $time = explode(':', $exp[1]);
        return $exp[0].", ".(($time[0]<10)?"0".$time[0]:$time[0]).":".(($time[1]<10)?"0".$time[1]:$time[1]).":".(($time[2]<10)?"0".$time[2]:$time[2]);
    }
}

if(!function_exists('stripAccents')) {
    function stripAccents($stripAccents){
        return sanitizeString( preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $stripAccents ) ) );
    }
}

if(!function_exists('sanitizeString')) {
    function sanitizeString($string) {
        // matriz de entrada
        $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
        // matriz de saída
        $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C',' ','_','_','_','','','','2','','_','','','','','','','','','','','','','' );
        // devolver a string
        return str_replace($what, $by, $string);
    }
}

if(!function_exists('find_most_used_words')) {
    function find_most_used_words($words, $start=4, $qts=4, $ignore=true) {
        $teste = array_count_values(str_word_count(strtolower($words), 1, "óéíúçáã"));
        arsort($teste);
        $cont=0;
        $wordsList=array();
        foreach ($teste as $key => $value) {
            if($ignore && strlen($key) > $start && $key!="https" && $key!="http") {
                $wordsList[$cont]['word'] = $key;
                $wordsList[$cont]['qts'] = $value;
                if($cont==$qts) break;
                $cont++;
            } elseif(!$ignore && strlen($key)>0 && $key!="https" && $key!="http") {
                $wordsList[$cont]['word'] = $key;
                $wordsList[$cont]['qts'] = $value;
                if($cont==$qts) break;
                $cont++;
            }
        }
        return $wordsList;
    }
}