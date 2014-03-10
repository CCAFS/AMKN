dojo.require("esri.map");
dojo.require("dojox.data.CsvStore");
dojo.require("esri.arcgis.utils");
dojo.require("esri.dijit.OverviewMap");
dojo.require("dijit.dijit"); // optimize: load dijit layer
dojo.require("dijit.layout.BorderContainer");
dojo.require("dijit.layout.ContentPane");
dojo.require("dijit.layout.AccordionContainer");
dojo.require("esri.layers.FeatureLayer");
dojo.require("dijit.TitlePane");
dojo.require("esri.dijit.BasemapGallery");
dojo.require("esri.dijit.Legend");
dojo.require("dijit.Dialog");
dojo.require("dijit.form.Button");
dojo.require("dijit.Tooltip");

var maxExtX = -20006031.09149561;
var maxExtY = -12433824.981519768;
var minExtX = 18816641.322648488;
var minExtY = 17739844.80810231;

var intMaxExtX = 16985396.45583168;
var intMaxExtY = 7524106.992139481;
var intMinExtX = -7728835.025551194;
var intMinExtY = -5586372.099330453;
var initLvl = 3;
var map, popupWindow, cntr, idCT, highlightSymbol, highlightGraphic, showLegend, sGCP, baseMP, iconT, baseExt, ctrPt, lvlMp, loadExtent, mapLevel, mapExtent, basemapGallery, tiledMapServiceLayer, gcpFarmingSystems, africaTSLayers, multipoint, popupSize, loading, initExtent, maxExtent, dataLayer, syms6 ,syms4, syms5, syms2, syml6 ,syml4, syml5, syml2, visible = [], legendLayers = [];
      var identifyTask, identifyParams, symbol, doingID;
      var layer2results, layer3results, layer4results, loading, hasContent;
      var intIdentify = setInterval('pulseId()',750);

var wcLabels = [
["Annual Mean Temperature", "1", "10"],
["Mean Diurnal Range (Mean of monthly (max temp - min temp))", "1", "10"],
["Isothermality (BIO2/BIO7) (* 100)", "1", "1"],
["Temperature Seasonality (standard deviation *100)", "1", "1000"],
["Max Temperature of Warmest Month", "1", "10"],
["Min Temperature of Coldest Month", "1", "10"],
["Temperature Annual Range (BIO5-BIO6)", "1", "10"],
["Mean Temperature of Wettest Quarter", "1", "10"],
["Mean Temperature of Driest Quarter", "1", "10"],
["Mean Temperature of Warmest Quarter", "1", "10"],
["Mean Temperature of Coldest Quarter", "1", "10"],
["Annual Precipitation", "1", "1"],
["Precipitation of Wettest Month", "1", "1"],
["Precipitation of Driest Month", "1", "1"],
["Precipitation Seasonality (Coefficient of Variation)", "1", "1"],
["Precipitation of Wettest Quarter", "1", "1"],
["Precipitation of Driest Quarter", "1", "1"],
["Precipitation of Warmest Quarter", "1", "1"],
["Precipitation of Coldest Quarter", "1", "1"]
]
var moLabels = [
['January'],
['February'],
['March'],
['April'],
['May'],
['June'],
['July'],
['August'],
['September'],
['October'],
['November'],
['December']
]
function pulseId() {
	if (dojo.byId("searching").style.color == 'white') {
	dojo.byId("searching").style.background = 'white';
	dojo.byId("searching").style.color = '#FFFFCC';
	dojo.byId("searching").style.border = 'thin solid #FFFFCC';
	} else {
	dojo.byId("searching").style.color = 'white';
	dojo.byId("searching").style.background = '#FFFFCC';
	dojo.byId("searching").style.border = 'thin solid white';
	}
}
function hideSearching() {
	dojo.byId("searching").style.visibility = 'hidden';
}

function initMap() {
baseMP = 1;
getView();
//processCsvData(dataUrl);
syml6 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/pin-mini.png", 17, 25);
syml4 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/blog-mini.png", 21, 21);
syml5 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/photo-mini.png", 21, 21);
syml2 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/video-mini.png", 21, 21);

syms6 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/pin-mini.png", 7, 10);
syms4 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/blog-mini.png", 10, 10);
syms5 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/photo-mini.png", 10, 10);
syms2 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/video-mini.png", 10, 10);
showLegend = dijit.byId("legendWindow");
highlightSymbol = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_SQUARE, 25, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([39, 92, 3, 1]), 3.5), new dojo.Color([244, 201, 63, 0.2]));

popupWindow = new dijit.Dialog({
    title: "Show Content",
    style: "width: 680px; min-height: 650px;"
});

loading = dojo.byId("loadingImg");  //loading image. id
initExtent = new esri.geometry.Extent({"xmin":intMinExtX,"ymin":intMinExtY,"xmax":intMaxExtX,"ymax":intMaxExtY,"spatialReference":{"wkid":102100}});

map = new esri.Map("map",{extent:initExtent, isZoomSlider: false});

dojo.connect(map,"onUpdateStart",showLoading);
dojo.connect(map,"onUpdateEnd",hideLoading);
dojo.connect(map, 'onLoad', function(map) {
  map.disableScrollWheelZoom();
  map.hideZoomSlider();
highlightGraphic = new esri.Graphic(null, highlightSymbol);
map.graphics.add(highlightGraphic);

  dojo.connect(dijit.byId('map'), 'resize', resizeMap);
  //add the overview map
  var overviewMapDijit = new esri.dijit.OverviewMap({
    map: map,
    visible:false
  });
  overviewMapDijit.startup();
  basemapGallery.select(baseMP);
  initBackMap();

  dojo.removeClass("legendDiv", "hide");
  dojo.removeClass("legendWindow", "hide");
//  dojo.removeClass("c_farming_systems", "hide");
//  dojo.removeClass("c_agroecological_zones, "hide");
  dojo.removeClass("c_adaptation_strategy", "hide");
  dojo.removeClass("c_mitigation_strategy", "hide");
//  dojo.removeClass("c_crops_livestock", "hide");
  dojo.removeClass("c_climate_change_challenges", "hide");

//

});

 dojo.connect(map, "onExtentChange", function(extent){
     setView();
  });

basemapGallery = new esri.dijit.BasemapGallery({
  showArcGISBasemaps: false,
  map: map
}, "basemapGallery");
var topoLayer = new esri.dijit.BasemapLayer({
  url:"http://services.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer"
});
var basemapTopo = new esri.dijit.Basemap({
  id:1,
  layers:[topoLayer],
  title:"Topo Map"
});
basemapGallery.add(basemapTopo);

var strtLayer = new esri.dijit.BasemapLayer({
  url:"http://services.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer"
});
var basestrtLayer = new esri.dijit.Basemap({
  id:2,
  layers:[strtLayer],
  title:"Street Map"
});
basemapGallery.add(basestrtLayer);

var aerLayer = new esri.dijit.BasemapLayer({
  url:"http://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer"
});
var baseaerLayer = new esri.dijit.Basemap({
  id:3,
  layers:[aerLayer],
  title:"Aerial Map"
});
basemapGallery.add(baseaerLayer);


basemapGallery.startup();

dojo.connect(basemapGallery,"onSelectionChange",function(){
    baseMP = basemapGallery.getSelected().id;
    setView();
});
//Takes a URL to a map in a map service.
tiledMapServiceLayer = new esri.layers.ArcGISTiledMapServiceLayer("http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer");
map.addLayer(tiledMapServiceLayer);


multipoint = new esri.geometry.Multipoint(new esri.SpatialReference({
  wkid: 4326
}));
dataLayer = new esri.layers.GraphicsLayer();
map.addLayer(dataLayer);
dojo.connect(dataLayer, "onClick", onFeatureClick);
dojo.connect(map.graphics, "onClick", onFeatureClick);
}


function showLoading() {
  esri.show(loading);
  map.disableMapNavigation();
  //map.hideZoomSlider();
  map.disableScrollWheelZoom();
}

function hideLoading(error) {

esri.hide(loading);
map.enableMapNavigation();
//map.showZoomSlider();
map.disableScrollWheelZoom();
}
function processCsvData(url) {

var frameUrl = new dojo._Url(window.location.href);
var csvUrl = new dojo._Url(url);
if (frameUrl.host !== csvUrl.host || frameUrl.port !== csvUrl.port || frameUrl.scheme !== csvUrl.scheme) {
  url = (proxyUrl) ? proxyUrl + "?" + url : url;
  console.log(url);
}
csvStore = new dojox.data.CsvStore({
  url: url
});

csvStore.fetch({
  onComplete: function(items, request) {
    var content = "";
    // RENDER THE TABLE AND MAP
    var labelField, latField, longField, typeField, cIDField;
    dojo.forEach(items, function(item, index) {
      if (index === 0) {
        var fields = getAttributeFields(item);
        labelField = fields[0];
        latField =  fields[1];
        longField =  fields[2];
        typeField = fields[3];
        cIDField = fields[4];
      }

      var label = csvStore.getValue(item, labelField) || "";
      var id = csvStore.getIdentity(item);


      content += ("<li onclick='showItemDetails(this, " + id + ");'><b>" + (id + 1) + ".</b> " + label.replace(/^\s+|\s+$/g, "") + "</li>");

      addGraphic(id, csvStore.getValue(item, latField), csvStore.getValue(item, longField), csvStore.getValue(item, typeField));
    });

    //dojo.byId("itemsList").innerHTML = "Data Loaded<br />";
    // REGISTER CLICK EVENT HANDLER


    // ZOOM TO THE COLLECTIVE EXTENT OF THE DATA

    dojo.forEach(dataLayer.graphics, function(graphic) {
      //dojo.byId("itemsList").innerHTML += "<br />"+graphic.geometry.x;
      var geometry = graphic.geometry;
      if (geometry) {
        multipoint.addPoint({
          x: geometry.x,
          y: geometry.y
        });
      }
    });
    if (multipoint.points.length > 0) {
      //map.setExtent(multipoint.getExtent(), true);
      maxExtent = multipoint.getExtent();
      //map.setExtent(initExtent, true);

    }
    enableFormsOnQuery();
  },
  //onComplete
  onError: function(error) {
    //dojo.byId("itemsList").innerHTML = error;
    //alert(error);
  }
});
}
function onFeatureClick(evt) {
var graphic = evt.graphic;

    if (graphic) {
        var id = graphic.attributes.id;
        map.graphics.remove(highlightGraphic);
    highlightGraphic = new esri.Graphic(null, highlightSymbol);
    map.graphics.add(highlightGraphic);
          highlightGraphic.setGeometry(graphic.geometry);
          highlightGraphic.setAttributes({
            id: graphic.attributes.id
          });
      setPopupContent(id);
      centerAtPoint(evt, graphic.geometry.x,  graphic.geometry.y);
    }
}

function centerAtPoint(evt, clkX, clkY)
{
var displace = map.extent.xmax - clkX;
var displace2 = clkX - map.extent.getCenter().x;
var displace3 = (map.extent.xmax - map.extent.getCenter().x)/2;
var iDl = displace/displace2;
var newX = map.extent.getCenter().x + (displace2 - displace3);
    var centerPoint = new esri.geometry.Point(newX,clkY,evt.mapPoint.spatialReference);
    map.centerAt(centerPoint);
}
function addGraphic(id, latitude, longitude, type) {
latitude = parseFloat(latitude);
longitude = parseFloat(longitude);

if (isNaN(latitude) || isNaN(longitude)) {
  return;
}

var geometry = new esri.geometry.Point(longitude, latitude);
if (dojo.indexOf([102113, 102100, 3857, 4326], map.spatialReference.wkid) !== -1) {
  geometry = esri.geometry.geographicToWebMercator(geometry);
}

var sym6 = (document.getElementById('iconType').checked) ? syml6 : syms6;
var sym4 = (document.getElementById('iconType').checked) ? syml4 : syms4;
var sym5 = (document.getElementById('iconType').checked) ? syml5 : syms5;
var sym2 = (document.getElementById('iconType').checked) ? syml2 : syms2;

switch (type) {
  case "video_testimonials":
    dataLayer.add(new esri.Graphic(geometry, sym2, {
      id: id
    }));
    break;
  case "ccafs_sites":
    dataLayer.add(new esri.Graphic(geometry, sym6, {
      id: id
    }));
    break;
  case "amkn_blog_posts":
    dataLayer.add(new esri.Graphic(geometry, sym4, {
      id: id
    }));
    break;
  case "photo_testimonials":
    dataLayer.add(new esri.Graphic(geometry, sym5, {
      id: id
    }));
    break;
  default:
    dataLayer.add(new esri.Graphic(geometry, sym5, {
      id: id
    }));
    break;
}

}
function getAttributeFields(item) {
var attributes = csvStore.getAttributes(item);
if (!attributes) {
  return defaultFields;
}

var defLabelField = defaultFields[0],
  defLatField = defaultFields[1],
  defLongField = defaultFields[2],
  defTypeField = defaultFields[3],
  defcIDField = defaultFields[4];
var labelField, latField, longField, typeField, cIDField;

dojo.forEach(attributes, function(attr) {
  attr = attr || "";
  var attr_lwr = attr.toLowerCase();
  switch (attr_lwr) {
  case defLabelField:
    if (!labelField) {
      labelField = attr;
    }
    break;
  case defcIDField:
    if (!cIDField) {
      cIDField = attr;
    }
    break;
  case defLatField:
    if (!latField) {
      latField = attr;
    }
    break;
  case defLongField:
    if (!longField) {
      longField = attr;
    }
    break;
  case defTypeField:
    if (!typeField) {
      typeField = attr;
    }
    break;

  }
});

return [labelField || defLabelField, latField || defLatField, longField || defLongField, typeField || defTypeField, cIDField || defcIDField];
}
function setPopupContent(id) {
csvStore.fetchItemByIdentity({
  identity: id,
  onItem: function(item) {
    var attributes = csvStore.getAttributes(item),
      data = {};
    dojo.forEach(attributes, function(attr) {
      data[attr] = csvStore.getValue(item, attr);
    });
    //alert(data['Latitude']);

//    popupWindow.innerHTML = "<div id='popupHide' onclick='hideItemDetails();'>Close</div>" + esri.substitute(data, defaultInfoTemplate);
    dijit.byId("popContent").attr("content", esri.substitute(data, defaultInfoTemplate));
    dijit.byId("popContent").attr("title", getPopupTitle(esri.substitute(data, titleTemplate)));
//        popupWindow.attr("content", esri.substitute(data, defaultInfoTemplate));
//        popupWindow.attr("title", getPopupTitle(esri.substitute(data, titleTemplate)));
    dojo.removeClass(document.getElementById("showContent"), "navigating");
    (dijit.byId("popContent").open)==true ? "" : dijit.byId("popContent").toggle();
    dojo.addClass(document.getElementById("tb1"), "navigating");
    dojo.connect(dijit.byId("popContent"),"onHide",function(){
        dojo.addClass(document.getElementById("showContent"), "navigating");
        dojo.removeClass(document.getElementById("tb1"), "navigating");
        document.getElementById('ifrm').src = "about:blank";
        map.graphics.remove(highlightGraphic);
    });
  }
});
}
function getPopupTitle(type){
    switch (type) {
      case "video_testimonials":
        return "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Video";
        break;
      case "ccafs_sites":
        return "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Site";
        break;
      case "amkn_blog_posts":
        return "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Blog Post";
        break;
      case "photo_testimonials":
        return "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Photo Set";
        break;
      default:
        return "Content Preview";
        break;
    }
}

function hideItemDetails() {

if (popupWindow) {
  dojo.style(popupWindow, {
    left: "-1000px",
    top: "-1000px"
  });
}

}
function resizeMap() {
//resize the map when the browser resizes - view the 'Resizing and repositioning the map' section in
//the following help topic for more details http://help.esri.com/EN/webapi/javascript/arcgis/help/jshelp_start.htm#jshelp/inside_guidelines.htm
var resizeTimer;
clearTimeout(resizeTimer);
resizeTimer = setTimeout(function() {
  map.resize();
  map.reposition();
}, 500);
}

function addGCPLayers()
{
	gcpFarmingSystems = new esri.layers.ArcGISDynamicMapServiceLayer("http://gismap.ciat.cgiar.org/ArcGISServer/rest/services/GCP/GCPAtlas/MapServer/", {id:'gcpFarmingSystems',visible:true});
	gcpFarmingSystems.setOpacity(0.75);
        legendLayers = [];
        legendLayers.push({layer:gcpFarmingSystems,title:''});

          var legend = new esri.dijit.Legend({
            map:map,
            layerInfos:legendLayers
          },"legendDiv");
          legend.startup();


	map.addLayer(gcpFarmingSystems);


        gcpFarmingSystems.setVisibleLayers([1]);
        setView();
}
function updateLegend()
{

}
function addATSitesLayers()
{
africaTSLayers = new esri.layers.ArcGISDynamicMapServiceLayer("http://gismap.ciat.cgiar.org/ArcGISServer/rest/services/CIAT/AfricaTS/MapServer");
map.addLayer(africaTSLayers);
}
function showHideGCP() {
var gcpLayer = map.getLayer("gcpFarmingSystems");
if(gcpLayer)
    {
      (document.getElementById('gcpFS').checked) ? gcpLayer.show() : gcpLayer.hide();
    }
    else
        {
            (document.getElementById('gcpFS').checked) ? addGCPLayers() : "";
        }
setView();
}

function updateDataLayer(cb)
{
    var pts = document.pts;
    var fs = document.farming_systems;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
    var showpts = "";
    var showfs = "";
    var showas = "";
    var showms = "";
    var showcl = "";
    var showccc = "";
    var showaz = "";
    for (var i=0;i<pts.length;i++)
    {
	    if(pts.elements[i].checked)
	    {
	       showpts += pts.elements[i].value+",";
	    }
    }
//    for (var i=0;i<az.length;i++)
//    {
//	    if(az.elements[i].checked)
//	    {
//	       showaz += az.elements[i].value+",";
//	    }
//    }
//    for (var i=0;i<fs.length;i++)
//    {
//	    if(fs.elements[i].checked)
//	    {
//	       showfs += fs.elements[i].value+",";
//	    }
//    }
    for (var i=0;i<as.length;i++)
    {
	    if(as.elements[i].checked)
	    {
	       showas += as.elements[i].value+",";
	    }
    }
    for (var i=0;i<ms.length;i++)
    {
	    if(ms.elements[i].checked)
	    {
	       showms += ms.elements[i].value+",";
	    }
    }
//    for (var i=0;i<cl.length;i++)
//    {
//	    if(cl.elements[i].checked)
//	    {
//	       showcl += cl.elements[i].value+",";
//	    }
//    }
    for (var i=0;i<ccc.length;i++)
    {
	    if(ccc.elements[i].checked)
	    {
	       showccc += ccc.elements[i].value+",";
	    }
    }


showpts = showpts == "" ? "" : "&pts="+showpts;
showfs = showfs == "" ? "" : "&fs="+showfs;
showas = showas == "" ? "" : "&as="+showas;
showms = showms == "" ? "" : "&ms="+showms;
showcl = showcl == "" ? "" : "&cl="+showcl;
showccc = showccc == "" ? "" : "&ccc="+showccc;
showaz = showaz == "" ? "" : "&az="+showaz;



//hlfs = showfs == "" ? dojo.removeClass(document.getElementById("d_farming_systems"), "sldMenu") : dojo.addClass(document.getElementById("d_farming_systems"), "sldMenu");
hlas = showas == "" ? dojo.removeClass(document.getElementById("d_adaptation_strategy"), "sldMenu") : dojo.addClass(document.getElementById("d_adaptation_strategy"), "sldMenu");
hlms = showms == "" ? dojo.removeClass(document.getElementById("d_mitigation_strategy"), "sldMenu") : dojo.addClass(document.getElementById("d_mitigation_strategy"), "sldMenu");
//hlcl = showcl == "" ? dojo.removeClass(document.getElementById("d_crops_livestock"), "sldMenu") : dojo.addClass(document.getElementById("d_crops_livestock"), "sldMenu");
hlccc = showccc == "" ? dojo.removeClass(document.getElementById("d_climate_change_challenges"), "sldMenu") : dojo.addClass(document.getElementById("d_climate_change_challenges"), "sldMenu");
//hlaz = showaz == "" ? dojo.removeClass(document.getElementById("d_agroecological_zones"), "sldMenu") : dojo.addClass(document.getElementById("d_agroecological_zones"), "sldMenu");

    var newURL = baseDataURL+"?fmt=csv"+showpts + showfs + showas + showms + showcl + showccc + showaz;
    //baseDataURL;
    if(cb)
        {
            map.removeLayer(dataLayer);
            dataLayer = "";
            dataLayer = new esri.layers.GraphicsLayer();
            map.addLayer(dataLayer);
            disableFormsOnQuery();
        }

    processCsvData(newURL);
    if(cb)
        {
        dojo.connect(dataLayer, "onClick", onFeatureClick);
        dojo.connect(map.graphics, "onClick", onFeatureClick);
        setView();
        }

}

function disableFormsOnQuery()
{
    showLoading();

    var pts = document.pts;
    var fs = document.farming_systems;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
    for (var i=0;i<pts.length;i++)
    {
        pts.elements[i].disabled="true";
    }
//    for (var i=0;i<az.length;i++)
//    {
//        az.elements[i].disabled="true";
//    }
//    for (var i=0;i<fs.length;i++)
//    {
//        fs.elements[i].disabled="true";
//    }
    for (var i=0;i<as.length;i++)
    {
        as.elements[i].disabled="true";
    }
    for (var i=0;i<ms.length;i++)
    {
        ms.elements[i].disabled="true";
    }
//    for (var i=0;i<cl.length;i++)
//    {
//        cl.elements[i].disabled="true";
//    }
    for (var i=0;i<ccc.length;i++)
    {
        ccc.elements[i].disabled="true";
    }
}
function enableFormsOnQuery()
{
   hideLoading();
   hideItemDetails();
   var pts = document.pts;
    var fs = document.farming_systems;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
    for (var i=0;i<pts.length;i++)
    {
        pts.elements[i].disabled="";
    }
//    for (var i=0;i<az.length;i++)
//    {
//        az.elements[i].disabled="";
//    }
//    for (var i=0;i<fs.length;i++)
//    {
//        fs.elements[i].disabled="";
//    }
    for (var i=0;i<as.length;i++)
    {
        as.elements[i].disabled="";
    }
    for (var i=0;i<ms.length;i++)
    {
        ms.elements[i].disabled="";
    }
//    for (var i=0;i<cl.length;i++)
//    {
//        cl.elements[i].disabled="";
//    }
    for (var i=0;i<ccc.length;i++)
    {
        ccc.elements[i].disabled="";
    }
}

function clearAllTaxSelections()
{
   hideLoading();
   hideItemDetails();
   var pts = document.pts;
    var fs = document.farming_systems;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
//    clearAllChecks(fs);
    clearAllChecks(as);
    clearAllChecks(ms);
//    clearAllChecks(cl);
    clearAllChecks(ccc);
//    clearAllChecks(az);
}
function clearAllChecks(formN){
    for (var i=0;i<formN.length;i++)
    {
       formN.elements[i].checked = "";
    }
    updateDataLayer(true);
}
function markAllChecks(formN){
    for (var i=0;i<formN.length;i++)
    {
       formN.elements[i].checked = "checked";
    }
    updateDataLayer(true);
}

function unChecks(formN){
    for (var i=0;i<formN.length;i++)
    {
       formN.elements[i].checked = "";
    }
}
function setView()
{
    var pts = document.pts;
    var fs = document.farming_systems;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
    var showpts = "";
    var showfs = "";
    var showas = "";
    var showms = "";
    var showcl = "";
    var showccc = "";
    var showaz = "";

    for (var i=0;i<pts.length;i++)
    {
	    if(pts.elements[i].checked)
	    {
	       showpts += pts.elements[i].value+",";
	    }
    }
//    for (var i=0;i<az.length;i++)
//    {
//	    if(az.elements[i].checked)
//	    {
//	       showaz += az.elements[i].value+",";
//	    }
//    }
//    for (var i=0;i<fs.length;i++)
//    {
//	    if(fs.elements[i].checked)
//	    {
//	       showfs += fs.elements[i].value+",";
//	    }
//    }
    for (var i=0;i<as.length;i++)
    {
	    if(as.elements[i].checked)
	    {
	       showas += as.elements[i].value+",";
	    }
    }
    for (var i=0;i<ms.length;i++)
    {
	    if(ms.elements[i].checked)
	    {
	       showms += ms.elements[i].value+",";
	    }
    }
//    for (var i=0;i<cl.length;i++)
//    {
//	    if(cl.elements[i].checked)
//	    {
//	       showcl += cl.elements[i].value+",";
//	    }
//    }
    for (var i=0;i<ccc.length;i++)
    {
	    if(ccc.elements[i].checked)
	    {
	       showccc += ccc.elements[i].value+",";
	    }
    }

showpts = showpts == "" ? "" : "/pts="+showpts;
showfs = showfs == "" ? "" : "/fs="+showfs;
showas = showas == "" ? "" : "/as="+showas;
showms = showms == "" ? "" : "/ms="+showms;
showcl = showcl == "" ? "" : "/cl="+showcl;
showccc = showccc == "" ? "" : "/ccc="+showccc;
//showaz = showaz == "" ? "" : "/az="+showaz;
mapCenter = "/ctr="+map.extent.getCenter().x+";"+map.extent.getCenter().y;
mapLevel = "/lvl="+map.getLevel();
var setBaseMP = "/bm="+baseMP;
var showGCP = "";
if(gcpFarmingSystems && gcpFarmingSystems.visible){showGCP = "/gcp=t";}
location.hash = setBaseMP + showGCP + mapCenter + mapLevel + showpts + showfs + showas + showms + showcl + showccc + showaz;
}

function getView()
{
    var pts = document.pts;
    var fs = document.farming_systems;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
    var showpts = "";
    var showfs = "";
    var showas = "";
    var showms = "";
    var showcl = "";
    var showccc = "";
    var showaz = "";
    var setCTR = "";
    var setLVL = "";
	if(location.hash)
	{
            location.hash = unescape(location.hash);
            var theMap = unescape(location.hash).split("/");
            if(theMap!="")
            {
                unChecks(document.pts);
                for (var mp=0;mp<theMap.length;mp++)
                {
                    var cEle = theMap[mp].split("=")[0];
                    switch (cEle) {
			case "pts":
                            checkTypeElements(theMap[mp].split("=")[1]);
                        break;
			case "fs":
                            checkTaxElements("farming_systems", theMap[mp].split("=")[1]);
                        break;
			case "as":
                            checkTaxElements("adaptation_strategy", theMap[mp].split("=")[1]);
                        break;
			case "ms":
                            checkTaxElements("mitigation_strategy", theMap[mp].split("=")[1]);
                        break;
			case "cl":
                            checkTaxElements("crops_livestock", theMap[mp].split("=")[1]);
                        break;
			case "ccc":
                            checkTaxElements("climate_change_challenges", theMap[mp].split("=")[1]);
                        break;
			case "az":
                            checkTaxElements("agroecological_zones", theMap[mp].split("=")[1]);
                        break;
			case "ctr":
                                ctrPt = theMap[mp].split("=")[1];
                        break;
			case "cntr":
                                cntr = theMap[mp].split("=")[1];
                                var ctPT = new esri.geometry.Point(parseFloat(cntr.split(";")[1]), parseFloat(cntr.split(";")[0]));
                                ctPT = esri.geometry.geographicToWebMercator(ctPT);
                                ctrPt = ctPT.x+";"+ctPT.y;
                        break;

			case "idCT":
                                idCT = theMap[mp].split("=")[1];
                        break;
			case "lvl":
                                lvlMp = theMap[mp].split("=")[1];
                        break;
			case "ext":
//                            var tmPts = theMap[mp].split("=")[1].split(";");
//                                intMinExtX = (tmPts[0]) ? parseFloat(tmPts[0]) : intMinExtX;
//                                intMinExtY = (tmPts[1]) ? parseFloat(tmPts[0]) : intMinExtY;
//                                intMaxExtX = (tmPts[2]) ? parseFloat(tmPts[0]) : intMaxExtX;
//                                intMaxExtY = (tmPts[3]) ? parseFloat(tmPts[0]) : intMaxExtY;
                        break;
			case "gcp":
                                if(theMap[mp].split("=")[1] == "t"){
                                    sGCP = theMap[mp].split("=")[1];
                                    document.getElementById("gcpFS").checked = "checked";
                                }else{
                                    document.getElementById("gcpFS").checked = "";
                                }
                        break;
			case "bm":
                            baseMP = theMap[mp].split("=")[1];
                        break;

                      default:

                        break;
                    }
                }
             }
	}
}
function initBackMap()
{
    var move;
         showHideGCP();
         if(ctrPt && lvlMp){
            move = new esri.geometry.Point([parseFloat(ctrPt.split(";")[0]), parseFloat(ctrPt.split(";")[1])], new esri.SpatialReference({ wkid:4326 }));
            map.centerAndZoom(move, parseFloat(lvlMp));
         }
         ctrPt = "";
         lvlMp = "";
          setBaseMap(baseMP);
         updateDataLayer(false);
}
function go2Region(pt, zm)
{
    move2 = new esri.geometry.Point([parseFloat(pt.split(";")[0]), parseFloat(pt.split(";")[1])], new esri.SpatialReference({ wkid:4326 }));
    map.centerAndZoom(move2, parseFloat(zm));
}
function checkTaxElements(tax, elements){
var chkElements = elements.split(",");
    for (var i=0;i<chkElements.length;i++)
    {
       if(chkElements[i]!=""){
       document.getElementById(tax+"_"+chkElements[i]).checked = "checked";
       }
    }
}
function checkTypeElements(elements){
var chkElements = elements.split(",");
    for (var i=0;i<chkElements.length;i++)
    {
       if(chkElements[i]!=""){
       document.getElementById(chkElements[i]).checked = "checked";
       }
    }
}
function setBaseMap(bmId)
{
    //basemapGallery.getSelected().id
   clearBaseSelection();
   dojo.addClass("mapType"+bmId, "controls-selected");
   baseMP = bmId;
   basemapGallery.select(baseMP);
   setView();
}
function clearBaseSelection()
{
   dojo.removeClass("mapType1", "controls-selected");
   dojo.removeClass("mapType2", "controls-selected");
   dojo.removeClass("mapType3", "controls-selected");
}
function go2Loc(xMn, yMn, xMx, yMx){
var setExt = new esri.geometry.Extent({"xmin":xMn,"ymin":yMn,"xmax":xMx,"ymax":yMx,"spatialReference":{"wkid":102100}});
map.setExtent(setExt);
}
dojo.addOnLoad(initMap);
