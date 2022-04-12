<?php 
include 'kmpalgo.php';

$time_start = microtime(true); 
$data = array("Will this be Blocked","Definately a good text","‘ ; drop table users ; #","‘ ; delete * from customer ; #","; insert into users values (‘Bala’, ‘1234’) ; #","‘ ; update table users set username = ‘Bala’, password =’123’ ; #");
$result=0;
$counter=0;
$injPattern = array("'",";",";","#");
$sqlFn=array("delete","drop","insert","truncate","update","select","alter");
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
    if(count(SearchString($data[$k],$injPattern[$i])) > 0){
        
        if($i==0){
            $counter=0;
            //echo $injPattern[i] . " with " .$data[$k];
		    for($j=0;$j<count($sqlFn);$j++){
			if(count(SearchString($data[$k],$sqlFn[$j])) > 0 ){echo $lOprt[$j]."\n";for($h=0;$h<count(SearchString($data[$k],$lOprt[$j]));$h++){echo SearchString($data[$k],$lOprt[$j])[$h];};$counter++;}
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