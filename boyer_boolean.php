<?php 
include 'boyermoore.php';

//$data = "' OR true;--";
$time_start = microtime(true); 
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
$lakh=10000;
while (1){
    $lakh--;
    if($lakh==0){
        break;
    }
for($x=0;$x<count($data);$x++){
for($i=0;$i<count($injPattern);$i++){
	$counter=0;
	if(BoyerMoore($injPattern[$i],$data[$x],101) > 0){
	if($i==0){
		$counter=0;
		for($j=0;$j<count($lOprt);$j++){
            
			if(BoyerMoore($lOprt[$j],$data[$x],101)){$counter++;}
		}
	}
	
	if($counter==0){$result=0;}

	if($i==2){
		$counter=0;
		for($k=0;$k<count($rOprt);$k++){
			if(BoyerMoore($rOprt[$k],$data[$x],101) >0){$counter++;}
		}
	}

	if($counter==0){$result=0;}
	//echo $injPattern[$i] . " found";break;
	if(($i+1) == count($injPattern)){$result=1;break;}

	//$input=end
	}else{$result=0;}
	
	}
	if($result==1){$result="Blocked";}else{$result="Passed";}
if($lakh==1){
echo " 

<tr>
  <td>$data[$x]</td>
  <td>$result</td>
  
</tr>
";}

}
}
echo " 

</table> ";
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
//echo "it is a ".$result;