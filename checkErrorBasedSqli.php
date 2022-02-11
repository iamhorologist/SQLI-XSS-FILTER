<?php 
include 'kmpalgo.php';

$data = array("Will this be Blocked","Definately a good text","convert( int, (select * from users LIMIT 1))","convert( int, ”aaaa”)","round((select username from users), 3)");
$result=0;
$counter=0;
$injPattern = array("'",")");
$sqlFn=array("convert(","avg(","round(","sum(","max(","min(");
echo " <link rel='stylesheet' href='style.css'> <table>
<tr>
  <th>Payload</th>
  <th>Result</th>
  
</tr>";
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
echo " 

<tr>
  <td>$data[$k]</td>
  <td>$result</td>
  
</tr>
";

}
echo " 

</table> ";