<?php
include 'kmpalgo.php';


$data = "' or '1'='1'; #";
$injPattern = array("'","union","select","from","#");
$result=0;

for($i=0;$i<count($injPattern);$i++){
	//echo "my i is $i";
	if(count(SearchString($data,$injPattern[$i]))  > 0){
		echo "$injPattern[$i] mathched";
		if(($i+1) == count($injPattern)){$result = 1;}

	}else{$result =0;break;}
	
}

echo "$result";
?>
