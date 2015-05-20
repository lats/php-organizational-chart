<?php
function create_list( $arr ){
	foreach ($arr as $key=>$v) {
		$html .= '<div id="' .$v['id'].'" class="skill">'.$v['name']."</div>\n";
		if (array_key_exists('children', $v)) {
			$html .= '<div id="items" class="skill">';
			$html .= create_list($v['children']);
			$html .= "</div>\n";
		}
		else{}
	}
	return $html;
}
