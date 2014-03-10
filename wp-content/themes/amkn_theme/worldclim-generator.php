<?php
/*
  Template Name: WorldClim Weather Generator
 */
get_header('embed');
?>
<style type="text/css">
    @import url(http://ajax.googleapis.com/ajax/libs/dojo/1.6/dojox/form/resources/BusyButton.css);
    #wcResults_underlay { background-color: #421b14; } 
</style>
<script type="text/javascript">
    var djConfig = {
        parseOnLoad: true
    };
</script>
<script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.5compact">
</script>
<script type="text/javascript" src="/wp-content/plugins/amkn_rules/worldclim.js"></script>
<div class="content">
    <h2 class="title"><?php the_title(); ?> for <?php echo $_REQUEST['pl']; ?></h2>
    <br />
    
    
            <div class="amknTabC" dojoType="dijit.layout.TabContainer" style="width: 100%; height: 100%;">
                <div dojoType="dijit.layout.ContentPane" title="Model Parameters" selected="true">
<div class="homebox">
        <h3>Generator Parameters</h3>
<form action="" method="post" name="input_form" id="input_form">
                <input type="hidden" name="latitude" size="17" value="<?php echo $_REQUEST['lt']; ?>" title="take from the map (or enter manually)" />
                <input type="hidden" name="longitude" size="17" value="<?php echo $_REQUEST['ln']; ?>" title="take from the map (or enter manually)" />
                <input type="hidden" name="altitude" size="17" value="" title="take from the map (or enter manually)" />
                <input type="hidden" name="place" size="17" value="<?php echo $_REQUEST['pl']; ?>" />
                <br />
                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="20%" align="left" valign="top"> <b>Model<img src="<?php bloginfo('template_directory'); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="Select a General Circulation Model (GCM) from the six provided. Average is the mean for the ensemble of six GCMs for the scenario you choose."/></b><br />

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
                    </tr>
                    <tr>
                        <td width="20%" align="left" valign="top"><b>Scenario<img src="<?php bloginfo('template_directory'); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="Select one of the three AR4 SRES scenarios. A1b is the medium emissions scenario. A2 is the high emissions scenario. B1 is the low emissions scenario"/></b><br />
                            <input type="radio" name="scenario" value="a1" checked="checked" />
                            A1b &nbsp; <br />
                            <input type="radio" name="scenario" value="a2" />
                            A2 &nbsp; <br />
                            <input type="radio" name="scenario" value="b1" />
                            B1 &nbsp; </td>
                    </tr>
                    <tr>
                        <td width="20%" align="left" valign="top"><b>Year of Simulation<img src="<?php bloginfo('template_directory'); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" 
                                                                                            title="Note that if the year is between 2000 and 2010, these are still generated data (of course), using the delta regressions as generated by the respective GCM downscaled using MarkSim climate typing from the baseline of 1961-1990. Just to be clear, generating daily data for any year means that the climatology used is for a time slice of multiple years centred on that year."/></b><br />
                            <select name="yearsimulation" >
                            </select>
                            <br />
                            <span class="modeldescript">
                                <input type="checkbox" name="wcbaseline" title="Base WorldClim" onclick="changeWorldClimYear(this);"/>
                                <b> Base WorldClim<img src="<?php bloginfo('template_directory'); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="WorldClim Baseline (1960 - 1990). Use this to get the WorldClim regression model data."/></b></span></td>
                    </tr>
                    <tr>
                        <td width="20%" align="left" valign="top"><b>Number of Replications<img src="<?php bloginfo('template_directory'); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="Select a number of Replications."/></b><br />
                            <select name="numrep" >
                            </select></td>
                    </tr>
                    <tr>
                        <td width="20%" align="left" valign="top"><b>Seed<img src="<?php bloginfo('template_directory'); ?>/images/info.png" align="absmiddle" style="border:0;margin:0;" title="Random number seed. Use this to set the same run of random numbers when you need to produce two or more comparable sets of data. If left as zero it will be chosen at random from the system clock."/></b><br />
                            <input type="text" name="seed" size="17" value="1234" title="Random number seed" /></td>
                    </tr>
                    <tr>
                        <td width="20%" align="left" valign="top" id="runmodel">
                            
                        </td>
                    </tr>

                </table>
<br clear="all" />

 
<button id="BtnRun" dojoType="dojox.form.BusyButton" busyLabel="Requesting Model Data..." type="submit" onclick="javascript:RunModel();"><a>Run Model</a></button>
            </form>
<div style="display: none;" id="wcNoResults" dojoType="dijit.layout.ContentPane" title="Results">
Processing Job Failed. Please try again...
</div>
<div style="display: none;" id="wcResults" dojoType="dijit.layout.ContentPane" title="Results">
<table border="0" cellpadding="0" cellspacing="0" align="center" style="display: block; width: 100%;">
                    <tr align="left" valign="top">        <span id="cbxFileList" style="display:none;">File List
                        <select id="filelist" onchange="onChangeSelectClimateFile();" >
                        </select>
                    </span>
                    <b>File List</b>
                    <span id="filelistlinks"></span> </tr>            
                    <tr align="left" valign="top" id="td_results" style="display:none;" >
                        <td style="width:700px;height:350px;"><div id="tabs" style="width:100%;height:380px;">
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
                </table>
</div>         
        </div>
                </div>
                <div dojoType="dijit.layout.ContentPane" title="About the tool">
<div class="video blog-post">
        <?php if (have_posts())
            while (have_posts()) : the_post(); ?>
                <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/custom-theme/jquery-ui-1.8.11.custom.css" type="text/css" media="all" />
                <style type="text/css">
                    #worldclimData>table {
                        font-size: x-small;
                        width: 98%;
                    }
                    #worldclimData>img {
                        width: 98%;
                    }
                </style>
                <script>
                    $(function() {
                        $( "#tabs" ).tabs();
                    });
                </script>
                <p>

                
                
                    
                <?php the_content(); ?>
    <?php endwhile; // end of the loop.  ?>
<p align="center" class="egiron"><a href="http://gismap.ciat.cgiar.org/MarkSimGCM/" target="_blank">Simulate Daily Weather Home Page</a> | ILRI &copy; 2010-2011. <a href="http://futureclim.info/" target="_new">Terms of Use</a>. Developed by <a href="http://ernestogiron.blogspot.com" target="_new">egiron</a></p>                     
    </div>
                </div>
                
               
            </div>
    
    
<br clear="all" />    
</div><!-- end content -->
</div>
<?php
get_footer('embed');
?>