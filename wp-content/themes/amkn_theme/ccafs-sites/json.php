<?php
require('../../../../wp-blog-header.php'); 
$bmsid = htmlentities($_GET["bmsid"]);
$table= htmlentities($_GET["table"]);
mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_NAME);
$sth = mysql_query("SELECT * FROM ".$table." WHERE bms_id='".$bmsid."'");
$rows = array();
while($r = mysql_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows); 
?>