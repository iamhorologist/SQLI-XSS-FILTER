<?php 
include 'kmpalgo.php';

//$data = "' OR true;--";
$data = array("Will this be Blocked","Definately a good text","' OR “ = “; #","' OR '1'='1'; #","' OR '3'! ='8' ;#","' OR 'a'<>'b' ;#","aa' OR '2 + 3' < = '7' ;#");
$result=0;
$injPattern = array("'","'","'","=","'","'","#");
$lOprt = array("or","||");
$rOprt = array('=','>','>=','<','<=','<>','!=');
echo " <link rel='stylesheet' href='style.css'> <table>
<tr>
  <th>Payload</th>
  <th>Result</th>
  
</tr>";
for($x=0;$x<count($data);$x++){
for($i=0;$i<count($injPattern);$i++){

	if(count(SearchString($data[$x],$injPattern[$i])) > 0){
	if($i==0){
		$counter=0;
		for($j=0;$j<count($lOprt);$j++){
			if(count(SearchString($data[$x],$lOprt[$j])) > 0 ){for($h=0;$h<count(SearchString($data[$x],$lOprt[$j]));$h++){echo SearchString($data[$x],$lOprt[$j])[$h];};$counter++;}
		}
	}
	
	if($counter==0){$result=0;}

	if($i==2){
		$counter=0;
		for($k=0;$k<count($rOprt);$k++){
			if(count(SearchString($data[$x],$rOprt[$k])) > 0 ){for($h=0;$h<count(SearchString($data[$x],$rOprt[$k]));$h++){echo SearchString($data[$x],$rOprt[$k])[$h];};$counter++;}
		}
	}

	if($counter==0){$result=0;}
	//echo $injPattern[$i] . " found";break;
	if(($i+1) == count($injPattern)){$result=1;break;}

	//$input=end
	}else{$result=0;}
	
	}
	if($result==1){$result="Blocked";}else{$result="Passed";}
echo " 

<tr>
  <td>$data[$x]</td>
  <td>$result</td>
  
</tr>
";

}
echo " 

</table> ";
//echo "it is a ".$result;