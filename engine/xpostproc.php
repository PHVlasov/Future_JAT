<?php

/*Функция для очистки данных помещаемых в базу данных*/

function xcleaner($x){
	$stage1 = stripslashes($x);
	$stage2 = filter_var($stage1, FILTER_SANITIZE_STRING);
	return $stage2;
	}

/*Функция для подсчета наполненности записной книжки*/

function xcount(){
	
$xgate = new MySQLi("localhost", "login", "password");

$xgate->select_db("DB");

$xqbody = "SELECT COUNT(*) FROM future";

$xquery = $xgate->query($xqbody);

$box = $xquery->fetch_all();

$xgate->close();

return $box[0][0];
}

/*Функция добавляющая запись в базу данных*/

function xwrite($x){

$xgate = new MySQLi("localhost", "login", "password");

$xgate->select_db("DB");

$xqbody = "INSERT INTO future (name, company, phone, email, birthdate, photo) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $xgate->prepare($xqbody);

$name = $x["name"];
$company = $x["company"];
$phone = $x["phone"];
$email = $x["email"];
$birthdate = $x["birthdate"];
$photo = $x["photo"];

$stmt->bind_param("ssssss", $name, $company, $phone, $email, $birthdate, $photo);
$stmt->execute();
if($stmt){print json_encode("Record added");}else{print json_encode($xgate->error);}

$stmt->close();

$xgate->close();
}

/*Обработка запроса*/

if(isset($_POST["note"])){$box = json_decode($_POST["note"]);}else{exit(json_encode("Request name must be 'note', body must contain parsable JSON data"));}


/*Непосредственно чистка вводимых данных*/
if(isset($box)){
	foreach($box as $x=>$y){
	$x = xcleaner($x);
	$y = xcleaner($y);
	$repack[$x] = $y;	
	}}
	

/*Флаг регулирующий выполнение обязательных условий и выдающий вердикт будет запись добавлена или нет. Проверяет налчие имени, E-mail(и его валидность) и номера телефона.*/

$xreply = "";

$xnor = xcount();

if($xnor>20){$xreply = $xreply."Maximum number of records reached ";}
if(strlen($repack["name"])<3){$xreply = $xreply."Name is required ";}
if(filter_var($repack["email"], FILTER_VALIDATE_EMAIL)){}else{$xreply = $xreply."Valid E-mail is required ";}
if(strlen($repack["phone"])<10){$xreply = $xreply."Telephone number is required ";}


if(strlen($xreply)>5){print json_encode($xreply);}else{xwrite($repack);}




?>