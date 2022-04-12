<?php
include 'kmpalgo.php';

$time_start = microtime(true); 
$data = array("Will this be Blocked","Definately a good text","' UNION select * from users; #","' UNION select cardNo, pin from customer; #");
$injPattern = array("'","union","select","from","#");
$result=0;
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
for($i=0;$i<count($injPattern);$i++){
	//echo "my i is $i";
	if(count(SearchString($data[$k],$injPattern[$i]))  > 0){
		//echo "$injPattern[$i] mathched";
		if(($i+1) == count($injPattern)){$result = 1;}

	}else{$result =0;break;}
	
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