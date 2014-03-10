<?php
require_once("../../../wp-config.php");
require_once("../../../wp-includes/wp-db.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Author" content="Ernesto Giron" />
        <meta name="copyright" content="&copy; 2010 ILRI." />
        <meta name="Keywords" content="ILRI, CCAFS, CIAT, MarkSim, GCM, DSSAT, weather, generator, egiron, ArcGISServer" />
        <meta name="date" content="2010-10-31T05:55:55+00:00" />
        <title>Daily Weather Simulation Tool (MarkSIM)</title> 
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />        
<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/custom-theme/jquery-ui-1.8.11.custom.css" type="text/css" media="all" />
<script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.3compact">
</script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
	//<![CDATA[
	google.load("jquery", "1.4.2");
	google.load("jqueryui", "1.8.2");
	//]]>
</script>
<script type="text/javascript" src="worldclim.js"></script>

    </head> 
    <body onload='init()'> 

        <h1>MarkSim™ DSSAT weather file generator for <?php echo $_REQUEST['pl']; ?></h1>
		<form action="" method="post" name="input_form" id="input_form">
		<input type="hidden" name="latitude" size="17" value="<?php echo $_REQUEST['lt']; ?>" title="take from the map (or enter manually)" />
		<input type="hidden" name="longitude" size="17" value="<?php echo $_REQUEST['ln']; ?>" title="take from the map (or enter manually)" />
		<input type="hidden" name="altitude" size="17" value="" title="take from the map (or enter manually)" />
		<input type="hidden" name="place" size="17" value="<?php echo $_REQUEST['pl']; ?>" />
        <br />
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" align="left" valign="top"> <b>Model<img src="<?php bloginfo( 'template_directory' ); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="Select a General Circulation Model (GCM) from the six provided. Average is the mean for the ensemble of six GCMs for the scenario you choose."/></b><br />
	
	<select name="model" title="Atmosphere-Ocean General Circulation Models used in GCM4" onchange="updateModelSelected();">
              <option value="bcc">BCCR_BCM2.0 </option>
              <option value="cnr">CNRM-CM3 </option>
              <option value="csi">CSIRO-Mk3.5 </option>
              <option value="ech" selected="selected">ECHam5
              <!-- <option value="had">HadCM3 -->
              </option>
              <option value="inm">INMCM3.0 </option>
              <option value="mir">MIROC3.2 (medres) </option>
              <option value="avr">AVERAGE </option>
            </select>
<div id="modeldescript" class="modeldescript" >Roeckner, E., et al. 2003. The Atmospheric General Circulation Model ECHAM5. 
				Part I: Model Description. MPI Report 349, Max Planck Institute for Meteorology, Hamburg, Germany, 127 pp.</div>		
				
				</td>
    <td width="80%" rowspan="6" align="left" valign="top">
	<img id="loadingImg" src="<?php bloginfo( 'template_directory' ); ?>/images/loading.gif" style="position:absolute; right:512px; top:256px; z-index:100; display:none;" />

	<table border="3" cellpadding="0" cellspacing="0" align="center" >
      <tr align="left" valign="top" id="td_results" style="display:none;" >
        <td><span id="cbxFileList" style="display:none;">File List
              <select id="filelist" onchange="onChangeSelectClimateFile();" >
              </select>
          </span>
            <h3>File List</h3>
            <span id="filelistlinks"></span> </td>
        <td style="width:700px;height:350px;"><div id="tabs" style="width:700px;height:380px;">
            <ul>
              <li><a href="#tabs-1">Chart</a></li>
              <li><a href="#tabs-2">Data</a></li>
              <li><a href="#tabs-3">Download</a></li>
            </ul>
            <div id="tabs-1">
              <div style="text-align: center; background: none repeat scroll 0% 0% rgb(255, 255, 255); padding: 2px;">
                <div id="radioCharts">
                  <input type="radio" id="rdRAIN" name="radio" onclick="showChart('RAIN')" checked="checked"/>
                  <label for="rdRAIN">Daily Rainfall (mm)</label>
                  <input type="radio" id="rdTEMP" name="radio" onclick="showChart('TEMP')"/>
                  <label for="rdTEMP">Temperature (C)</label>
                  <input type="radio" id="rdSRAD" name="radio" onclick="showChart('SRAD')"/>
                  <label for="rdSRAD">Radiation (MJ/m2)</label>
                </div>
              </div>
              <div style="background: none repeat scroll 0% 0% rgb(153, 179, 204); padding: 3px;">
                <div style="text-align: center; background: none repeat scroll 0% 0% rgb(255, 255, 255); padding: 5px;" id="info"></div>
              </div>
            </div>
            <div id="tabs-2">
              <div id="TitleFileClim"></div>
              <iframe id="ifarchWTG" width="100%" height="320px;"> </iframe>
            </div>
            <div id="tabs-3">
              <div id="btnDownload">
                <h3>Data with () replications in a zip file. Click on the icon to start download</h3>
                <a href=""><img src="http://gismap.ciat.cgiar.org/MarkSimGCM/images/zip-icon.jpg" style="border:0;margin:0;" /></a> </div>
              <h5>Note: This data is temporally saved in our servers for a couple of hours</h5>
            </div>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="20%" align="left" valign="top"><b>Scenario<img src="<?php bloginfo( 'template_directory' ); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="Select one of the three AR4 SRES scenarios. A1b is the medium emissions scenario. A2 is the high emissions scenario. B1 is the low emissions scenario"/></b><br />
      <input type="radio" name="scenario" value="a1" checked="checked" />
A1b &nbsp; <br />
<input type="radio" name="scenario" value="a2" />
A2 &nbsp; <br />
<input type="radio" name="scenario" value="b1" />
B1 &nbsp; </td>
    </tr>
  <tr>
    <td width="20%" align="left" valign="top"><b>Year of Simulation<img src="<?php bloginfo( 'template_directory' ); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" 
                                         title="Note that if the year is between 2000 and 2010, these are still generated data (of course), using the delta regressions as generated by the respective GCM downscaled using MarkSim climate typing from the baseline of 1961-1990. Just to be clear, generating daily data for any year means that the climatology used is for a time slice of multiple years centred on that year."/></b><br />
      <select name="yearsimulation" >
      </select>
      <br />
      <span class="modeldescript">
      <input type="checkbox" name="wcbaseline" title="Base WorldClim" onclick="changeWorldClimYear(this);"/>
      <b> Base WorldClim<img src="<?php bloginfo( 'template_directory' ); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="WorldClim Baseline (1960 - 1990). Use this to get the WorldClim regression model data."/></b></span></td>
    </tr>
  <tr>
    <td width="20%" align="left" valign="top"><b>Number of Replications<img src="<?php bloginfo( 'template_directory' ); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="Select a number of Replications."/></b><br />
      <select name="numrep" >
      </select></td>
    </tr>
  <tr>
    <td width="20%" align="left" valign="top"><b>Seed<img src="<?php bloginfo( 'template_directory' ); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="Random number seed. Use this to set the same run of random numbers when you need to produce two or more comparable sets of data. If left as zero it will be chosen at random from the system clock."/></b><br />
      <input type="text" name="seed" size="17" value="1234" title="Random number seed" /></td>
    </tr>
  <tr>
    <td width="20%" align="left" valign="top" id="runmodel"><input type="button" id="BtnRun" value="Run Model" onclick="javascript:RunModel();" /></td>
    </tr>

</table>

    </form> 
        <p>&nbsp;</p>
        <!-- <br />  -->
<p align="center" class="egiron"><a href="http://gismap.ciat.cgiar.org/MarkSimGCM/" target="_blank">Daily Weather Simulation Tool (MarkSIM) Home Page</a> | ILRI &copy; 2010-2011. <a href="http://futureclim.info/" target="_new">Terms of Use</a>. Developed by <a href="http://ernestogiron.blogspot.com" target="_new">egiron</a></p> 

    </body> 
</html>