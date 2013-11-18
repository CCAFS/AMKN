<!--<iframe height="439" width="960" scrolling="no" align="center" src="http://lab.amkn.org/#/bm=1/ctr=9305003.853739217;1027571.0841275128/lvl=3/pts=ccafs_sites,"></iframe>-->
<?php
$url = "http://localhost/AMKN/wp-content/themes/amkn_theme/services.php/DataAndTools/get";
$http_respone_header = file_get_contents($url);

echo "<pre>".print_r( json_decode($http_respone_header,true),true)."</pre>"; 
?>
