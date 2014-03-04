<?php
  $year = 2012;
  $limit= 20;
  if (isset($_GET['year']) && $_GET['year'] != '') $year = $_GET['year'];
  if (isset($_GET['limit']) && $_GET['limit'] != '') $limit = $_GET['limit'];
  $origen = file_get_contents('http://activities.ccafs.cgiar.org/xml.do?year='.$year.'&limit='.$limit);
  $fh = fopen("origen.xml", 'w');
  $stringData = $origen;
  fwrite($fh, $stringData);
  fclose($fh);
?>
<html>
  <body>
    <iframe id="fake" style="display:block" frameborder="0"></iframe>
    <form style="display:none" action="createXML.php" method="post" name="pas" id="pas" target="fake">
      <!--Name: <input type="text" name="name"><br>-->
      <textarea id="dataxml" name="dataxml"></textarea>
      <input type="submit">
    </form>
  <script type="text/javascript" src="importer.js">
  </script>  
  </body>
</html>
