<?php
header("Content-Type:text/html;   charset=utf-8");

use yii\helpers\ArrayHelper;
use Overtrue\Pinyin\Pinyin;


foreach ($model as $key => $gllueClient) {
    $keyy = $key + 1;
    $company = array_column($model,'name');

}
//print_r($company);
//echo '<hr />';
//echo '总数：' . count($model) ;

echo '<hr />';

foreach ($cities as $key => $gllueCity) {
    $keyy = $key + 1;

}
$city = array_column($cities,'name');
$comma_separated = implode(",", $city);
//print_r($city);
//echo Pinyin::trans($comma_separated);
//echo '<hr />';
//echo '总数：' . count($city) ;

//echo '<hr />';
$why1 = $company;
$why2 = $city;
$why2 = array_map(function($value) { return '/'.$value.'/'; }, $why2);
$str = $why1;
$patterns = $why2;

$replacements = [''];
$pre = preg_replace($patterns, $replacements, $str);
//print_r($pre);
$comma_separated2 = implode(",",$pre);
$comma_separated3 = Pinyin::trans($comma_separated2);
$array = explode(",",$comma_separated3);

sort($array);
$trimmed_array=array_map('trim',$array);
print_r($trimmed_array);

$a = 0;
$b = 0;
$c = 0;
$d = 0;
$e = 0;
$f = 0;
$g = 0;
$h = 0;
$i = 0;
$j = 0;
$k = 0;
$l = 0;
$m = 0;
$n = 0;
$o = 0;
$p = 0;
$q = 0;
$r = 0;
$s = 0;
$t = 0;
$u = 0;
$v = 0;
$w = 0;
$x = 0;
$y = 0;
$z = 0;
$other = 0;


for($ii = 0; $ii < count($trimmed_array); $ii++){
    $first_char = substr($trimmed_array[$ii], 0, 1);
    if    ($first_char == 'A'){$a++;}
    elseif($first_char == 'B'){$b++;}
    elseif($first_char == 'C'){$c++;}
    elseif($first_char == 'D'){$d++;}
    elseif($first_char == 'E'){$e++;}
    elseif($first_char == 'F'){$f++;}
    elseif($first_char == 'G'){$g++;}
    elseif($first_char == 'H'){$h++;}
    elseif($first_char == 'I'){$i++;}
    elseif($first_char == 'J'){$j++;}
    elseif($first_char == 'K'){$k++;}
    elseif($first_char == 'L'){$l++;}
    elseif($first_char == 'M'){$m++;}
    elseif($first_char == 'N'){$n++;}
    elseif($first_char == 'O'){$o++;}
    elseif($first_char == 'P'){$p++;}
    elseif($first_char == 'Q'){$q++;}
    elseif($first_char == 'R'){$r++;}
    elseif($first_char == 'S'){$s++;}
    elseif($first_char == 'T'){$t++;}
    elseif($first_char == 'U'){$u++;}
    elseif($first_char == 'V'){$v++;}
    elseif($first_char == 'W'){$w++;}
    elseif($first_char == 'X'){$x++;}
    elseif($first_char == 'Y'){$y++;}
    elseif($first_char == 'Z'){$z++;}
    elseif($first_char == 'a'){$a++;}
    elseif($first_char == 'b'){$b++;}
    elseif($first_char == 'c'){$c++;}
    elseif($first_char == 'd'){$d++;}
    elseif($first_char == 'e'){$e++;}
    elseif($first_char == 'f'){$f++;}
    elseif($first_char == 'g'){$g++;}
    elseif($first_char == 'h'){$h++;}
    elseif($first_char == 'i'){$i++;}
    elseif($first_char == 'j'){$j++;}
    elseif($first_char == 'k'){$k++;}
    elseif($first_char == 'l'){$l++;}
    elseif($first_char == 'm'){$m++;}
    elseif($first_char == 'n'){$n++;}
    elseif($first_char == 'o'){$o++;}
    elseif($first_char == 'p'){$p++;}
    elseif($first_char == 'q'){$q++;}
    elseif($first_char == 'r'){$r++;}
    elseif($first_char == 's'){$s++;}
    elseif($first_char == 't'){$t++;}
    elseif($first_char == 'u'){$u++;}
    elseif($first_char == 'v'){$v++;}
    elseif($first_char == 'w'){$w++;}
    elseif($first_char == 'x'){$x++;}
    elseif($first_char == 'y'){$y++;}
    elseif($first_char == 'z'){$z++;}
    else {$other++;
    }


}

echo "a=". $a . "<br>";
echo "b=". $b . "<br>";
echo "c=". $c . "<br>";
echo "d=". $d . "<br>";
echo "e=". $e . "<br>";
echo "f=". $f . "<br>";
echo "g=". $g . "<br>";
echo "h=". $h . "<br>";
echo "i=". $i . "<br>";
echo "j=". $j . "<br>";
echo "k=". $k . "<br>";
echo "l=". $l . "<br>";
echo "m=". $m . "<br>";
echo "n=". $n . "<br>";
echo "o=". $o . "<br>";
echo "p=". $p . "<br>";
echo "q=". $q . "<br>";
echo "r=". $r . "<br>";
echo "s=". $s . "<br>";
echo "t=". $t . "<br>";
echo "u=". $u . "<br>";
echo "v=". $v . "<br>";
echo "w=". $w . "<br>";
echo "x=". $x . "<br>";
echo "y=". $y . "<br>";
echo "z=". $z . "<br>";
echo "other=". $other . "<br>";
echo "<br>";


$clientnumber = ['a'=> '152','b'=>'291','c'=>'149','d'=>'272','e'=>'30','f'=>'118','g'=>'124','h'=>'468','i'=>'26',];
print_r($clientnumber);
