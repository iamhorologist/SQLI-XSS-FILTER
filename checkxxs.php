<?php 
include 'kmpalgo.php';


$data = array("Will this be Blocked","Definately a good text","<script> alert(&#34; XSS &#34;)</script>","<script>alert('1');</script>");

$result=0;
$injPattern = array("<script>","'","</script>");
echo " <link rel='stylesheet' href='style.css'> <table>
<tr>
  <th>Payload</th>
  <th>Result</th>
  
</tr>";
for($k=0;$k<count($data);$k++){
for($i=0;$i<count($injPattern);$i++){
    //echo "res is " . $result;
    //echo $data[$k] . "init <br>";
    if(count(SearchString($data[$k],$injPattern[$i])) > 0 ){
        
        if(($i+1) == count($injPattern)){echo $injPattern[$i];$result=1;}

    }else{$result=0;
        //echo "in it\n";
    }
    //echo "comparing  " . $data[$k] . " " . $injPattern[$i] . "  " . $injPattern[$i] . "\n";
}
$xxs=htmlspecialchars($data[$k], ENT_QUOTES, 'UTF-8');
if($result==1){$result="Blocked";}else{$result="Passed";}
echo " 

<tr>
  <td>" . htmlspecialchars($data[$k], ENT_QUOTES, 'UTF-8') ."</td>
  <td>$result</td>
  
</tr>
";

}
echo " 

</table> ";