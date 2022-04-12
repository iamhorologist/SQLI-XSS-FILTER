<?php 
include 'boyermoore.php';

$time_start = microtime(true); 
$data = array("Will this be Blocked","Definately a good text","a‘ OR username LIKE ‘S%’;#","‘ OR password LIKE ‘%2%’;#","‘ OR username LIKE ‘%e’;#");
$result=0;
$counter=0;
$injPattern = array("'","like","'","%","'","#");
$sqlFn=array("or","||");
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
for($k=0;$k<count($data);$k++){
   // echo $data[$k];
for($i=0;$i<count($injPattern);$i++){
    if(BoyerMoore($injPattern[$i],$data[$k],101) > 0){
        
        if($i==0){
            $counter=0;
            //echo $injPattern[i] . " with " .$data[$k];
		    for($j=0;$j<count($sqlFn);$j++){
			if(BoyerMoore($sqlFn[$j],$data[$k],101) > 0 ){echo $lOprt[$j]."\n";$counter++;}
		}
        }

        if($counter==0){$result=0;}

        if(($i+1) == count($injPattern)){$result=1;break;}
    
    }else{$result=0;}
}
if($result==1){$result="Blocked";}else{$result="Passed";}
if($lakh==1){
echo " 

<tr>
 <td>$data[$k]</td>
  <td>$result</td>
  
</tr>
";}
}
}
echo " 

</table> ";
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);