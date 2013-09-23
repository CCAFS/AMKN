<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $post;
?>
<?php wp_reset_query(); ?>
<?php
$bookmarks = get_bookmarks( array(
    'orderby'        => 'name',
    'order'          => 'ASC',
    'category_name'  => 'MapServerLayers'
));
?>
<div id="layercontainer">
<form name="lyrF">
<?php

foreach($bookmarks as $bm)
{
$bmLStr = explode("||",$bm->link_url);
if(count($bmLStr) == 1){
$bmLURL = $bm->link_url;
$singleLayer = "null";
} else{
$bmLURL = $bmLStr[0];
$singleLayer = $bmLStr[1];
}
?>
<div id="lC"><div id="layerbt_aglyr<?php echo $bm->link_id; ?>"></div></div><h4><?php echo $bm->link_name; ?></h4>

<p><?php echo $bm->link_description; ?><br /><a href="<?php echo $bm->link_rss; ?>" target="_blank">Source</a></p>
<div id="layercontainer_<?php echo $bm->link_id; ?>"></div>
<hr />
<?php
}
?>    
</form> 
</div>

<script type="text/javascript">
//<![CDATA[ 
var fUd = false;
<?php
foreach($bookmarks as $bm)
{
$bmLStr = explode("||",$bm->link_url);
if(count($bmLStr) == 1){
$bmLURL = $bm->link_url;
$singleLayer = "null";
} else{
$bmLURL = $bmLStr[0];
$singleLayer = $bmLStr[1];
}
?>
var aglyr<?php echo $bm->link_id; ?>;
<?php
}
?> 
function addDataLayers()
{

<?php
foreach($bookmarks as $bm)
{
$bmLStr = explode("||",$bm->link_url);
if(count($bmLStr) == 1){
$bmLURL = $bm->link_url;
$singleLayer = "null";
} else{
$bmLURL = $bmLStr[0];
$singleLayer = $bmLStr[1];
}
?>
aglyr<?php echo $bm->link_id; ?> = new esri.layers.ArcGISDynamicMapServiceLayer("<?php echo $bmLURL; ?>");
aglyr<?php echo $bm->link_id; ?>.id = "aglyr<?php echo $bm->link_id; ?>";
legendLayers.push({layer:aglyr<?php echo $bm->link_id; ?>,title:''});
tLayers.push(aglyr<?php echo $bm->link_id; ?>);
dojo.connect(aglyr<?php echo $bm->link_id; ?>,"onError",function(error){
    var layer<?php echo $bm->link_id; ?> = new dijit.TooltipDialog({
        content: "No layers were found"
    });
    
    var layerbutton<?php echo $bm->link_id; ?> = new dijit.form.DropDownButton({
        label: "Data source not available",
        id: "aglyr<?php echo $bm->link_id; ?>",
        dropDown: layer<?php echo $bm->link_id; ?>
    });
    dojo.byId("layerbt_aglyr<?php echo $bm->link_id; ?>").appendChild(layerbutton<?php echo $bm->link_id; ?>.domNode);
});
dojo.connect(aglyr<?php echo $bm->link_id; ?>,"onLoad",function(aglyr<?php echo $bm->link_id; ?>){
    var layer<?php echo $bm->link_id; ?> = new dijit.TooltipDialog({
        content: buildLayerList(aglyr<?php echo $bm->link_id; ?>, "<?php echo $bm->link_id; ?>", "aglyr<?php echo $bm->link_id; ?>", <?php echo $singleLayer; ?>)
    });
    
dojo.connect(aglyr<?php echo $bm->link_id; ?>,"onUpdateStart",showLoading);
dojo.connect(aglyr<?php echo $bm->link_id; ?>,"onUpdateEnd",hideLoading); 
dojo.connect(aglyr<?php echo $bm->link_id; ?>,"onVisibilityChange",rLegend); 
    var layerbutton<?php echo $bm->link_id; ?> = new dijit.form.DropDownButton({
        label: "Layers",
        id: "aglyr<?php echo $bm->link_id; ?>",
        dropDown: layer<?php echo $bm->link_id; ?>
    });
    layerbutton<?php echo $bm->link_id; ?>.openDropDown();
    layerbutton<?php echo $bm->link_id; ?>.closeDropDown();

    dojo.byId("layerbt_aglyr<?php echo $bm->link_id; ?>").appendChild(layerbutton<?php echo $bm->link_id; ?>.domNode);
    //dojo.place("<br />", dojo.byId("layercontainer_<?php echo $bm->link_id; ?>"), "after"); 
}); 


<?php
}
?>
map.addLayers(tLayers);
dojo.connect(map,"onLayersAddResult",sLeg);
}


function sLeg(results) {
    legend = new esri.dijit.Legend({
    map:map,
    layerInfos:legendLayers
    },"legendDiv");
    rLegend();
}
function addInitLayers()
{
<?php
foreach($bookmarks as $bm)
{
$bmLStr = explode("||",$bm->link_url);
if(count($bmLStr) == 1){
$bmLURL = $bm->link_url;
$singleLayer = "null";
} else{
$bmLURL = $bmLStr[0];
$singleLayer = $bmLStr[1];
}
?>
 if(((typeof vLyr != "undefined") && vLyr != "") && fUd==false && vLyr.split("|")[0]=="aglyr<?php echo $bm->link_id; ?>"){
    fUd=true;
    updateInitLyr(vLyr.split("|")[1], vLyr.split("|")[0], vLyr.split("|")[2]);
    rLegend();
 }
<?php
}
?>     
}
//]]>
</script>