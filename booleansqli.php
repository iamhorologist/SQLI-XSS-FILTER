<?php 
include 'kmpalgo.php';

$data = "' OR true;--";
$result=0;
$injPattern = array("'","'","'","=","'","'","#");
$lOprt = array("or","||");
$rOprt = array('=','>','>=','<','<=','<>','!=');

for($i=0;$i<count($injPattern);$i++){

	if(count(SearchString($data,$injPattern[$i])) > 0){
	if($i==0){
		$counter=0;
		for($j=0;$j<count($lOprt);$j++){
			if(count(SearchString($data,$lOprt[$j])) > 0 ){echo "in loprt";echo $lOprt[$j]."\n";for($h=0;$h<count(SearchString($data,$lOprt[$j]));$h++){echo SearchString($data,$lOprt[$j])[$h];};$counter++;}
		}
	}
	
	if($counter==0){$result=0;}

	if($i==2){
		$counter=0;
		for($k=0;$k<count($rOprt);$k++){
			if(count(SearchString($data,$rOprt[$k])) > 0 ){echo "in roprt";echo $rOprt[$k]."\n";for($h=0;$h<count(SearchString($data,$rOprt[$k]));$h++){echo SearchString($data,$rOprt[$k])[$h];};$counter++;}
		}
	}

	if($counter==0){$result=0;}

	if(($i+1) == count($injPattern)){echo $injPattern[$i];$result=1;}

	//$input=end
	}else{$result=0;}
	
	}
echo "it is a ".$result;
?>
