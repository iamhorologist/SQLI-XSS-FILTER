<?php
include 'kmpalgo.php';


$data = array("Will this be Blocked","Definately a good text","' UNION select * from users; #","' UNION select cardNo, pin from customer; #");
$injPattern = array("'","union","select","from","#");
$result=0;
echo " <link rel='stylesheet' href='style.css'> <table>
<tr>
  <th>Payload</th>
  <th>Result</th>
  
</tr>";
for($k=0;$k<count($data);$k++){
for($i=0;$i<count($injPattern);$i++){
	//echo "my i is $i";
	if(count(SearchString($data[$k],$injPattern[$i]))  > 0){
		//echo "$injPattern[$i] mathched";
		if(($i+1) == count($injPattern)){$result = 1;}

	}else{$result =0;break;}
	
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