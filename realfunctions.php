<?php
include 'kmpalgo.php';
include 'boyermoore.php';
function unionSQI($realdata)
{


    //$data = $realdata;
    $data = array($realdata);
    $injPattern = array("'", "union", "select", "from", "#");
    $result = 0;
    for ($k = 0; $k < count($data); $k++) {
        for ($i = 0; $i < count($injPattern); $i++) {
            //echo "my i is $i";
            if (BoyerMoore($injPattern[$i], $data[$k], 101) > 0) {
                //echo "$injPattern[$i] mathched";
                if (($i + 1) == count($injPattern)) {
                    $result = 1;
                }
            } else {
                $result = 0;
                //return $result;
            }
        }
    }
    return $result;
}

function booleanSQI($realdata)
{

    //$data = "' OR true;--";
    $data = array($realdata);
    $result = 0;
    $injPattern = array("'", "'", "'", "=", "'", "'", "#");
    $lOprt = array("or", "||");
    $rOprt = array('=', '>', '>=', '<', '<=', '<>', '!=');
    for ($x = 0; $x < count($data); $x++) {
        for ($i = 0; $i < count($injPattern); $i++) {
            $counter = 0;
            if (BoyerMoore($injPattern[$i], $data[$x], 101) > 0) {
                if ($i == 0) {
                    $counter = 0;
                    for ($j = 0; $j < count($lOprt); $j++) {

                        if (BoyerMoore($lOprt[$j], $data[$x], 101)) {
                            $counter++;
                        }
                    }
                }
                if ($counter == 0) {
                    $result = 0;
                }
                if ($i == 2) {
                    $counter = 0;
                    for ($k = 0; $k < count($rOprt); $k++) {
                        if (BoyerMoore($rOprt[$k], $data[$x], 101) > 0) {
                            $counter++;
                        }
                    }
                }
                if ($counter == 0) {
                    $result = 0;
                }
                //echo $injPattern[$i] . " found";break;
                if (($i + 1) == count($injPattern)) {
                    $result = 1;
                    break;
                }
                //$input=end
            } else {
                $result = 0;
            }
        }
    }
    return $result;
}
function batchedSQI($realdata)
{



    $time_start = microtime(true);
    $data = array($realdata);
    $result = 0;
    $counter = 0;
    $injPattern = array("'", ";", ";", "#");
    $sqlFn = array("delete", "drop", "insert", "truncate", "update", "select", "alter");
    for ($k = 0; $k < count($data); $k++) {
        // echo $data[$k];
        for ($i = 0; $i < count($injPattern); $i++) {
            if ((BoyerMoore($injPattern[$i], $data[$k], 101)) > 0) {

                if ($i == 0) {
                    $counter = 0;
                    //echo $injPattern[i] . " with " .$data[$k];
                    for ($j = 0; $j < count($sqlFn); $j++) {
                        if ((BoyerMoore($sqlFn[$j], $data[$k], 101)) > 0) {
                            //echo $lOprt[$j] . "\n";
                            $counter++;
                        }
                    }
                }

                if ($counter == 0) {
                    $result = 0;
                }

                if (($i + 1) == count($injPattern)) {
                    $result = 1;
                    break;
                }
            } else {
                $result = 0;
            }
        }
    }
    return $result;
}

function likeSQI($realdata)
{


    $data = array($realdata);
    $result = 0;
    $counter = 0;
    $injPattern = array("'", "like", "'", "%", "'", "#");
    $sqlFn = array("or", "||");
    for ($k = 0; $k < count($data); $k++) {
        // echo $data[$k];
        for ($i = 0; $i < count($injPattern); $i++) {
            if (BoyerMoore($injPattern[$i], $data[$k], 101) > 0) {

                if ($i == 0) {
                    $counter = 0;
                    //echo $injPattern[i] . " with " .$data[$k];
                    for ($j = 0; $j < count($sqlFn); $j++) {
                        if (BoyerMoore($sqlFn[$j], $data[$k], 101) > 0) {
                            // echo $lOprt[$j] . "\n";
                            $counter++;
                        }
                    }
                }
                if ($counter == 0) {
                    $result = 0;
                }

                if (($i + 1) == count($injPattern)) {
                    $result = 1;
                    break;
                }
            } else {
                $result = 0;
            }
        }
    }

    return $result;
}

function checkXSS($realdata)
{

    $data = array($realdata);
    $result = 0;
    $injPattern = array("<script>", "'", "</script>");
    for ($k = 0; $k < count($data); $k++) {
        for ($i = 0; $i < count($injPattern); $i++) {
            //echo "res is " . $result;
            //echo $data[$k] . "init <br>";
            if (BoyerMoore($injPattern[$i], $data[$k], 101) > 0) {

                if (($i + 1) == count($injPattern)) {
                    echo $injPattern[$i];
                    $result = 1;
                }
            } else {
                $result = 0;
                //echo "in it\n";
            }
            //echo "comparing  " . $data[$k] . " " . $injPattern[$i] . "  " . $injPattern[$i] . "\n";
        }
        $xxs = htmlspecialchars($data[$k], ENT_QUOTES, 'UTF-8');
    }
    return $result;
}

function errorbasedSQI($realdata)
{


    $time_start = microtime(true);
    $data = array($realdata);
    $result = 0;
    $counter = 0;
    $injPattern = array("'", ")");
    $sqlFn = array("convert(", "avg(", "round(", "sum(", "max(", "min(");


    for ($k = 0; $k < count($data); $k++) {
        // echo $data[$k];
        for ($i = 0; $i < count($injPattern); $i++) {
            if (BoyerMoore($injPattern[$i], $data[$k], 101) > 0) {

                if ($i == 0) {
                    $counter = 0;
                    //echo $injPattern[i] . " with " .$data[$k];
                    for ($j = 0; $j < count($sqlFn); $j++) {
                        // if (count(SearchString($data[$k], $sqlFn[$j])) > 0) {
                        if (BoyerMoore($sqlFn[$j], $data[$k], 101) > 0) {
                            //echo $lOprt[$j] . "\n";

                            $counter++;
                        }
                    }
                }

                if ($counter == 0) {
                    $result = 0;
                }

                if (($i + 1) == count($injPattern)) {
                    $result = 1;
                    break;
                }
            } else {
                $result = 0;
            }
        }
    }
    return $result;
}

function filterme($data)
{
    if (errorbasedSQI($data) == 1 || checkXSS($data) == 1 || likeSQI($data) == 1 || unionSQI($data) == 1 || booleanSQI($data) == 1 || batchedSQI($data) == 1) {
        echo "something wendwrrong";
        exit();
        session_write_close();
    } else {
        echo "all ok";
    }
}


//echo errorbasedSQI("kali");
//echo checkXSS("<script> alert(&#34; XSS &#34;)</script>");
//echo likeSQI("a‘ OR username LIKE ‘S%’;#");
//echo unionSQI("kalikali");
//echo booleanSQI("' OR “ = “; #");
//echo batchedSQI("‘ ; delete * from customer ; #");