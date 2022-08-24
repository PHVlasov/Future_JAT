<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, max-age=0");
?>
<?php

require __DIR__."/../engine/xgetproc.php";


xout();

print json_encode(xread($GLOBALS["xletter"]));

?>



