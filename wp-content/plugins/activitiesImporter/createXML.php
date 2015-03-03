<?php  
  $dir = realpath(dirname(__FILE__));
  $fh = fopen($dir."/rssActivities.xml", 'w');
  $stringData = $_POST['dataxml'];
  fwrite($fh, $stringData);
  fclose($fh);
  echo 'rssActivities.xml created successfully';
?>
