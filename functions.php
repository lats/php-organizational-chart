<?php
function tree($dat, $node) {
	if (is_array($dat)){
		foreach($dat as $e){
			if($e[2] == $node[0]){
				$node[$e[1]] = tree($dat, $e);
			}
		}
		return $node; 
	}
}
function removeRecursive($haystack,$needle){
    if(is_array($haystack)) {
        unset($haystack[$needle]);
        foreach ($haystack as $key=>$value) {
            $haystack[$key] = removeRecursive($value,$needle);
        }
    }
    return $haystack;
}
function convert($string){
	for ($i = 0; $i < strlen($string);$i++){
		$ascii += ord($string[$i]);
	}
	return ($ascii);
}
function fixArrayKey(&$arr)
{
    $arr = array_combine(
        array_map(
            function ($str) {
                return str_replace(" ", "", $str);
            },
            array_keys($arr)
        ),
        array_values($arr)
    );

    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            fixArrayKey($arr[$key]);
        }
    }
}
