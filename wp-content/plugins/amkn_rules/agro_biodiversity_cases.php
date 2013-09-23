<?php
header("Content-type: text/xml; charset=UTF-8");
ob_start ("ob_gzhandler");
$sXml  = "<xml></xml>"; 

# LOAD XML FILE 
$XML = new DOMDocument(); 
$XML->loadXML( $sXml ); 

# START XSLT 
$xslt = new XSLTProcessor(); 
$XSL = new DOMDocument(); 
$XSL->load( 'bioKML2RSS.xslt'); 
$xslt->importStylesheet( $XSL ); 
#PRINT 
print $xslt->transformToXML( $XML ); 
?>