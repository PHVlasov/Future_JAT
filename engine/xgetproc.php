<?php

/*Функция которая осуществляет экспликацию из базы данных согласно ключу предоставленному функцией xout()*/

function xread($fl){

$xgate = new MySQLi("localhost", "login", "password");

$xgate->select_db("DB");

$xqbody = "SELECT * FROM future WHERE name LIKE ".$fl;

$xquery = $xgate->query($xqbody);

$box = $xquery->fetch_all();

$xgate->close();

return $box;
}

/*Функция получает ключ для xread() из параметра переданного с GET запросом.*/

function xout(){
	if(isset($_GET["fl"])){$box = filter_var($_GET["fl"], FILTER_SANITIZE_STRING);}else{$GLOBALS["xletter"] = "'%'"; return;}
	
	$xstage1 = substr($box, 0, 1);
    $xstage2 = strtoupper($xstage1);
	$xstage3 = "'".$xstage2."%"."'";
	$GLOBALS["xletter"] = $xstage3;
	
}



?>