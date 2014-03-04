<?php  
  $fh = fopen("rssActivities.xml", 'w');
  $stringData = $_POST['dataxml'];
  fwrite($fh, $stringData);
  fclose($fh);
  echo 'rssActivities.xml created successfully';
?>
