<?php 
	if($badges){
		foreach($badges as $badge) {
			if(isset($badge['name'])){
				echo $badge['name'];
			}
			if(isset($badge['title'])){
				echo ($badge['title']=='no title included')?'':"\t".$badge['title'];
			}
			if(isset($badge['license'])){
				echo ($badge['license']=='')?'':"\t".$badge['license'];
			}
			if(isset($badge['service_year'])){
				echo "\t".$badge['service_year']." years";	
			}
			echo "\r\n";
 		}
	}
?>