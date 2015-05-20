<?php
    function PHPtoOrgChart(array $arr, $title='') {
        echo '<table>' . "\n";
        $size=count($arr);
        if($title!='') {
			$nospace = str_replace(' ', '',$title);
		   //head

            echo "\t" . '<tr>' . "\n\t";
            echo '<td colspan="'.($size*2).'">' . "\n";
            echo '<div id="'. $nospace .'" class="charttext" style="">'.$title.'</div>' . "\n";
            echo '</td>' . "\n";
            echo '</tr>' . "\n";
            //head line

			if ($size >= 1) { 
				echo '<tr>' . "\n\t";
				echo '<td colspan="'.($size*2).'">' . "\n";
				echo '<table><tr><th class="right width-50"></th><th class="width-50"></th></tr></table>' . "\n";
				echo '</td>' . "\n";
				echo '</tr>' . "\n";
			}
			
            //line
            if($size>=2){

            $tdWidth=((100)/(($size)*2));

            echo '<tr>' . "\n\t";
            echo '<th class="right" width="'.$tdWidth.'%"></th>' . "\n";
                echo '<th class="top" width="'.$tdWidth.'%"></th>' . "\n";
                for($j=1; $j<$size-1; $j++) {
                    echo '<th class="right top" width="'.$tdWidth.'%"></th>' . "\n";
                    echo '<th class=" top" width="'.$tdWidth.'%"></th>' . "\n";
                }
                echo '<th class="right top" width="'.$tdWidth.'%"></th>' . "\n";
            echo '<th width="'.$tdWidth.'%"></th>' . "\n";
            echo '</tr>' . "\n";
            }
       	}
        //
        echo '<tr>' . "\n\t";
        foreach($arr as $key=>$value) {
            echo '<td colspan="2">' . "\n";
            if(is_array($value)) {
				PHPtoOrgChart($value,$key);
            } else {
                echo '<div class="charttext">'.$value.'</div>' . "\n";
            }
            echo '</td>' . "\n";
        }
        echo '</tr>' . "\n";
        //
        echo '</table>' . "\n";
    }
