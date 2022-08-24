<?php

/*Функция для очистки вносимых данных*/

function xcleaner($x){
	$stage1 = stripslashes($x);
	$stage2 = filter_var($stage1, FILTER_SANITIZE_STRING);
	return $stage2;
	}
	
/*Основная функция которая удаляет записи из базы данных по имени*/	

function xdelete($x){

$xgate = new MySQLi("localhost", "login", "password");

$xgate->select_db("DB");

$xqbody = "DELETE FROM future WHERE name='".$x."'";

$xquery = $xgate->query($xqbody);

$xgate->close();
}

/*Обработчик запроса DELETE.  Требует  параметр "name" с существующим в записной книжке именем человека, и параметр "op" со значением "erase"*/

if($_SERVER['REQUEST_METHOD'] === 'GET'){ 
}

$xdelparse = $_SERVER['QUERY_STRING'];

$extract = preg_split("/[=&]/", $xdelparse);

$delname = str_replace("%20"," ",$extract[1]);

$delname = xcleaner($delname);

if($extract[0]=="name" && $extract[2]=="op" && $extract[3]=="erase"){print "Processing"; xdelete($delname);}


?>