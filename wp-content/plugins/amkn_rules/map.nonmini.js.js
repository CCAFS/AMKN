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
dojo.require("dijit.form.Slider");
dojo.require("esri.dijit.Legend");
dojo.require("dijit.Dialog");
dojo.require("dijit.form.Button");
dojo.require("dijit.layout.TabContainer");
dojo.require("dijit.Menu");
dojo.require("dojox.layout.ExpandoPane");
dojo.require("dijit.Tooltip");
dojo.require("esri.tasks.identify");
//dojo.require("dojo.hash");
//function hList() {
//    handle = dojo.subscribe("/dojo/hashchange",function(current_hash){
////        console.log(current_hash);
////       ((typeof current_hash == "undefined") || current_hash == "")? window.history.forward() : "";
//    });
//}
//hList();
var maxExtX = -20006031.09149561;
var maxExtY = -12433824.981519768;
var minExtX = 18816641.322648488;
var minExtY = 17739844.80810231;

var intMaxExtX = 16985396.45583168;
var intMaxExtY = 7524106.992139481;
var intMinExtX = -7728835.025551194;
var intMinExtY = -5586372.099330453;
var initLvl = 3;
var map, visLyr, tLayers=[], vLyr, qPop, identifyTask, identifyParams, legend, hQuery, cPx, cHType, polyGraphic, hoverGraphic, hoverText, currentLocation, popupWindow, cntr, idCT, highlightSymbol, highlightGraphic, showLegend, sGCP, baseMP, iconT, baseExt, ctrPt, lvlMp, loadExtent, mapLevel, mapExtent, basemapGallery, tiledMapServiceLayer, gcpFarmingSystems, africaTSLayers, multipoint, popupSize, loading, initExtent, maxExtent, dataLayer, hoverLayer, syms6 ,syms4, syms5, syms2, syml6 ,syml4, syml5, syml2, visible = [], legendLayers = [];
var vtonmap = [];
var cconmap = [];
var bgonmap = [];
var bdonmap = [];
var ptonmap = [];
function initMap() {
    baseMP = 1;
    getView();

    //processCsvData(dataUrl);
    syml6 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/pin-mini.png", 17, 25);
    //syml4 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/blog-mini.png", 21, 21);
    //syml5 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/photo_testimonials-mark.png", 20, 20);
    //syml2 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/video-mini.png", 21, 21);
    //
    syms6 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/pin-mini.png", 7, 10);
    //syms4 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/blog-mini.png", 10, 10);
    //syms5 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/photo-mini.png", 10, 10);
    //syms2 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/video-mini.png", 10, 10);


    //syml6 = new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0,0,255]));
    syml4 = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_CIRCLE, 15,
        new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID,
            new dojo.Color([0,128,0]), 1),
        new dojo.Color([0,128,0,0.25]));
    syml5 = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_CIRCLE, 15,
        new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID,
            new dojo.Color([0,0,139]), 1),
        new dojo.Color([0,0,139,0.25]));
    syml2 = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_CIRCLE, 15,
        new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID,
            new dojo.Color([128,0,128]), 1),
        new dojo.Color([128,0,128,0.25]));
    sym7 = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_CIRCLE, 15,
        new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID,
            new dojo.Color([255,140,0]), 1),
        new dojo.Color([255,140,0,0.25]));

    //symh4 = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_CIRCLE, 21,
    //   new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID,
    //   new dojo.Color([0,128,0]), 1),
    //   new dojo.Color([0,128,0,0.95]));
    //symh5 = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_CIRCLE, 21,
    //   new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID,
    //   new dojo.Color([0,0,139]), 1),
    //   new dojo.Color([0,0,139,0.95]));
    //symh2 = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_CIRCLE, 21,
    //   new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID,
    //   new dojo.Color([128,0,128]), 1),
    //   new dojo.Color([128,0,128,0.95]));
    symh2 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/video_testimonials-miniH.gif", 21, 21);   
    symh4 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/amkn_blog_posts-miniH.gif", 21, 21);   
    symh5 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/photo_testimonials-miniH.gif", 21, 21);   
    symh6 = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/ccafs_sites-miniH.gif", 17, 25);   
    //symhX = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_CIRCLE, 21,
    //   new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID,
    //   new dojo.Color([0,128,0]), 1),
    //   new dojo.Color([0,128,0,0.95]));
    symhX = new esri.symbol.PictureMarkerSymbol("/wp-content/themes/amkn_theme/images/biodiv_cases-miniH.gif", 21, 21);   

    //syms6 = new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0,0,255]));
    syms4 = new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0,0,255]));
    syms5 = new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0,0,255]));
    syms2 = new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0,0,255]));

    highlightSymbol = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_SQUARE, 25, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([39, 92, 3, 1]), 3.5), new dojo.Color([244, 201, 63, 0.2]));

    popupWindow = new dijit.Dialog({
        title: "Show Content",
        style: "width: 680px; min-height: 650px;"
    });
    hQuery = new dijit.TooltipDialog({
        id: "hQuery",
        style: "position: absolute; min-width: 250px; max-width: 350px; font: normal normal normal 10pt Helvetica;z-index:100"
    });
    hQuery.startup();

    loading = dojo.byId("loadingImg");  //loading image. id
    initExtent = new esri.geometry.Extent({
        "xmin":intMinExtX,
        "ymin":intMinExtY,
        "xmax":intMaxExtX,
        "ymax":intMaxExtY,
        "spatialReference":{
            "wkid":102100
        }
    });
qPop = new dijit.TooltipDialog({
    style: "position: absolute; min-width: 250px; max-width: 350px;z-index:100;"
});
qPop.startup();
map = new esri.Map("map",{
    extent:initExtent, 
    isZoomSlider: true, 
    wrapAround180: true
});

dojo.connect(map,"onUpdateStart",showLoading);
dojo.connect(map,"onUpdateEnd",cT);
dojo.connect(map,"onPanStart",showLoading);
dojo.connect(map,"onPanEnd",hideLoading);
dojo.connect(map,"onZoomStart",showLoading);
dojo.connect(map,"onZoomEnd",hideLoading);
dojo.connect(map, 'onLoad', function(map) {
    createMapMenu();
    map.disableScrollWheelZoom();

    // ((typeof vLyr == "undefined") || vLyr == "") ? "" : updateLayerVisibility(vLyr.split("|")[1], vLyr.split("|")[0]);
    // dojo.connect(map, "onLayerAdd", function() { console.log("Layer added"); });
    // 
    //map.hideZoomSlider();
    highlightGraphic = new esri.Graphic(null, cHType);
    map.graphics.add(highlightGraphic);

    dojo.connect(dijit.byId('map'), 'resize', resizeMap);
    //add the overview map
    var overviewMapDijit = new esri.dijit.OverviewMap({
        map: map,
        visible:true
    });
    overviewMapDijit.startup();
    basemapGallery.select(baseMP);
    initBackMap();
  
    dojo.removeClass("c_impacts", "hide");
    //  dojo.removeClass("c_agroecological_zones, "hide");
    dojo.removeClass("c_adaptation_strategy", "hide");
    dojo.removeClass("c_mitigation_strategy", "hide");
    //  dojo.removeClass("c_crops_livestock", "hide");
    dojo.removeClass("c_climate_change_challenges", "hide");
    //  dojo.removeClass("tb1", "hide");
    dojo.removeClass("tb2", "hide");
    dojo.removeClass("rsType", "hide");
    dojo.removeClass("rsLayers", "hide");
    dojo.removeClass("tb3", "hide");

//

});
dojo.connect(map, "onExtentChange", function(extent){
    setView();
    dijit.popup.close(hQuery);
    findPointsInExtent(map.extent);
    hoverLayer.remove(polyGraphic);
});
dojo.connect(map, "onKeyDown", function(evt){
    dijit.popup.close(hQuery);
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
hoverLayer = new esri.layers.GraphicsLayer();
map.addLayer(dataLayer);
map.addLayer(hoverLayer);

dojo.connect(dataLayer, "onClick", onFeatureClick);
dojo.connect(map.graphics, "onClick", onFeatureClick);
dojo.connect(dataLayer, "onMouseOver", onFeatureHover);
dojo.connect(hoverLayer, "onMouseOut", onFeatureLeave);
dojo.connect(hoverLayer, "onMouseOver", showTT);
dojo.connect(map, "onLoad", addDataLayers);

//dojo.connect(map,"onClick",function(evt){
//    identifyTask = new esri.tasks.IdentifyTask(map.getLayer(visLyr).url);
//    identifyParams = new esri.tasks.IdentifyParameters();
//    identifyParams.tolerance = 0;
//    identifyParams.returnGeometry = false;
//    identifyParams.geometry = evt.mapPoint;
//    identifyParams.mapExtent = map.extent;
//    identifyParams.layerIds = visible;
//    identifyParams.layerOption = esri.tasks.IdentifyParameters.LAYER_OPTION_ALL;
//    identifyParams.width  = map.width;
//    identifyParams.height = map.height;
//    identifyTask.execute(identifyParams, function(rsts) { addToMap(rsts, evt); });
//});


}

function addToMap(rsts, evt) {
    for (var i=0, il=rsts.length; i<il; i++) {
        var result = rsts[i];
        qPop.setContent(result.layerName + ": "+result.value);
    }
    dijit.popup.open({
        popup: qPop, 
        x:evt.pageX,
        y:evt.pageY
        });
}

function cPop(){
    dijit.popup.close(hQuery);
}
function cT(){
    hideLoading();
}
function showLoading() {
    esri.show(loading);
    dijit.popup.close(hQuery);
    map.disableMapNavigation();
    //map.hideZoomSlider();
    map.disableScrollWheelZoom();
}

function hideLoading(error) {
    esri.hide(loading);
    map.enableMapNavigation();
    //map.showZoomSlider();
    map.disableScrollWheelZoom();
    findPointsInExtent(map.extent);
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
        setPopupContent(id);
        map.graphics.remove(highlightGraphic);
        highlightGraphic = new esri.Graphic(null, cHType);
        map.graphics.add(highlightGraphic);
        highlightGraphic.setGeometry(graphic.geometry);
        highlightGraphic.setAttributes({
            id: graphic.attributes.id
        });
        centerAtPoint(graphic.geometry.x,  graphic.geometry.y);
    }
}

function showItemDetails(node, id) {
    var match = findGraphicById(id);
    map.infoWindow.hide();
    if (match) {
        setPopupContent(id);
        map.graphics.remove(highlightGraphic);
        highlightGraphic = new esri.Graphic(null, cHType);
        map.graphics.add(highlightGraphic);
        highlightGraphic.setGeometry(match.geometry);
        highlightGraphic.setAttributes({
            id: id
        });
        centerAtPoint(match.geometry.x,  match.geometry.y); 
    }
    dijit.popup.close(hQuery);
}
function findGraphicById(id) {
    var match;
    dojo.some(dataLayer.graphics, function(graphic) {
        if (graphic.attributes && graphic.attributes.id === id) {
            match = graphic;
            return true;
        }
        else {
            return false;
        }
    });
    return match;
}
function onFeatureHover(evt) {
    var gPt2Spt = map.toScreen(evt.graphic.geometry);
    getItemsAtLocation(gPt2Spt.x, gPt2Spt.y, evt);
//map.setMapCursor("auto");
//var graphic = evt.graphic;
//var id = graphic.attributes.id;
//        hoverGraphic = new esri.Graphic(null, highlightSymbol);
//        map.graphics.add(hoverGraphic);
//        hoverGraphic.setGeometry(graphic.geometry);
//        hoverGraphic.setAttributes({
//            id: id
//        });
//document.getElementById("searchbar").value = document.getElementById(dataLayer.id).childNodes.length;
}
function onListHover(id) {
    var graphic = findGraphicById(id);
    map.graphics.remove(hoverGraphic);
    var id = graphic.attributes.id;
    hoverGraphic = new esri.Graphic(null, highlightSymbol);
    map.graphics.add(hoverGraphic);
    hoverGraphic.setGeometry(graphic.geometry);
    hoverGraphic.setAttributes({
        id: id
    });
}
function onFeatureLeave() {
    map.graphics.remove(hoverGraphic);
    hoverLayer.remove(polyGraphic);
//dijit.popup.close(hQuery);
        
//        map.infoWindow.hide();
}
function showTT(evt){
//    alert(evt.screenPoint.x);
}
function onQueryByPolyClick() {

}
function centerAtPoint(clkX, clkY)
{
    var displace = map.extent.xmax - clkX;
    var displace2 = clkX - map.extent.getCenter().x;
    var displace3 = (map.extent.xmax - map.extent.getCenter().x)/2;
    var iDl = displace/displace2;
    var newX = map.extent.getCenter().x + (displace2 - displace3);
    var centerPoint = new esri.geometry.Point(newX,clkY,map.spatialReference);
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
        case "biodiv_cases":
            dataLayer.add(new esri.Graphic(geometry, sym7, {
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
            cType = esri.substitute(data, titleTemplate);
            //    popupWindow.innerHTML = "<div id='popupHide' onclick='hideItemDetails();'>Close</div>" + esri.substitute(data, defaultInfoTemplate);
            dijit.byId("popContent").attr("content", esri.substitute(data, defaultInfoTemplate));
            dijit.byId("popContent").attr("title", getPopupTitle(esri.substitute(data, titleTemplate)));
            //        popupWindow.attr("content", esri.substitute(data, defaultInfoTemplate));
            //        popupWindow.attr("title", getPopupTitle(esri.substitute(data, titleTemplate)));
            dojo.removeClass(document.getElementById("showContent"), "navigating");
            (dijit.byId("popContent").open)==true ? "" : dijit.byId("popContent").toggle();
            //    dojo.addClass(document.getElementById("tb1"), "navigating");
            dojo.connect(dijit.byId("popContent"),"onHide",function(){
                dojo.addClass(document.getElementById("showContent"), "navigating");
                //        dojo.removeClass(document.getElementById("tb1"), "navigating");
                document.getElementById('ifrm').src = "about:blank";
                map.graphics.remove(highlightGraphic);
            });
        }
    });
}

function getListingContent(id) {
    var rt, ttl;
    csvStore.fetchItemByIdentity({
        identity: id,
        onItem: function(item) {
            var attributes = csvStore.getAttributes(item),
            data = {};
            dojo.forEach(attributes, function(attr) {
                data[attr] = csvStore.getValue(item, attr);
                ttl = attr;
            });
            ttl = csvStore.getValue(item, "Location");
            rt = esri.substitute(data, titleTemplate);
        }
    });
    mapPTS = rt == "video_testimonials" ? vtonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover(" + id + ")' onclick='showItemDetails(this, " + id + ");'>" + "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;" + ttl+ "</li>") : "";
    mapPTS = rt == "ccafs_sites" ? cconmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover(" + id + ")' onclick='showItemDetails(this, " + id + ");'>" + "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;" + ttl+ "</li>") : "";
    mapPTS = rt == "amkn_blog_posts" ? bgonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover(" + id + ")' onclick='showItemDetails(this, " + id + ");'>" + "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;" + ttl+ "</li>") : "";
    mapPTS = rt == "biodiv_cases" ? bdonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover(" + id + ")' onclick='showItemDetails(this, " + id + ");'>" + "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;" + ttl+ "</li>") : "";
    mapPTS = rt == "photo_testimonials" ? ptonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover(" + id + ")' onclick='showItemDetails(this, " + id + ");'>" + "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;" + ttl+ "</li>") : "";
    return "<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover(" + id + ")' onclick='showItemDetails(this, " + id + ");'>" + "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;" + ttl+ "</li>";
}
function getPopupTitle(type){
    switch (type) {
        case "video_testimonials":
            cHType = symh2;
            return "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Video";
            break;
        case "ccafs_sites":
            cHType = symh6;
            return "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Benchmark Site";
            break;
        case "amkn_blog_posts":
            cHType = symh4;
            return "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Blog Post";
            break;
        case "biodiv_cases":
            cHType = symhX;
            return "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Agrobiodiversity Cases";
            break;        
        case "photo_testimonials":
            cHType = symh5;
            return "<img class='titleImg' src='/wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Photo Set";
            break;
        default:
            cHType = highlightSymbol;
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
function rLegend(){
    (typeof legend == "undefined") ? "" : legend.refresh();
}
function addGCPLayers()
{

}
function updateLegend()
{
    rLegend();
}
//function addATSitesLayers()
//{
//africaTSLayers = new esri.layers.ArcGISDynamicMapServiceLayer("http://gismap.ciat.cgiar.org/ArcGISServer/rest/services/CIAT/AfricaTS/MapServer");
//map.addLayer(africaTSLayers);
//}
function showHideGCP() {

}

function updateDataLayer(cb)
{
    var pts = document.pts;
    var imp = document.impacts;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
    var showpts = "";
    var showimp = "";
    var showas = "";
    var showms = "";
    var showcl = "";
    var showccc = "";
    var showaz = "";
    var hasPts = "";
    var hasRes = "";
    for (var i=0;i<pts.length;i++)
    {
        if(pts.elements[i].checked)
        {
            showpts += pts.elements[i].value+",";
            hasPts = true;
        }
    }
    //    for (var i=0;i<az.length;i++)
    //    {
    //	    if(az.elements[i].checked)
    //	    {
    //	       showaz += az.elements[i].value+",";
    //	    }
    //    }
    for (var i=0;i<imp.length;i++)
    {
        if(imp.elements[i].checked)
        {
            showimp += imp.elements[i].value+",";
        }
    }
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
    showimp = showimp == "" ? "" : "&imp="+showimp;
    showas = showas == "" ? "" : "&as="+showas;
    showms = showms == "" ? "" : "&ms="+showms;
    showcl = showcl == "" ? "" : "&cl="+showcl;
    showccc = showccc == "" ? "" : "&ccc="+showccc;
    showaz = showaz == "" ? "" : "&az="+showaz;



    hasThemes = showimp+showas+showms+showcl+showccc+showaz;
    //hasThemes = hasThemes == "" ? dojo.removeClass(document.getElementById("rsTheme_label"), "sldMenu") : dojo.addClass(document.getElementById("rsTheme_label"), "sldMenu");
    //hasPts = hasPts == "" ? dojo.removeClass(document.getElementById("rsType_label"), "sldMenu") : dojo.addClass(document.getElementById("rsType_label"), "sldMenu");
    hasRes = hasThemes + hasPts;
    hasRes = hasRes == "" ? dojo.removeClass(document.getElementById("rsType_label"), "sldMenu") : dojo.addClass(document.getElementById("rsType_label"), "sldMenu");


    hlimp = showimp == "" ? dojo.removeClass(document.getElementById("d_impacts"), "sldMenu") : dojo.addClass(document.getElementById("d_impacts"), "sldMenu");
    hlas = showas == "" ? dojo.removeClass(document.getElementById("d_adaptation_strategy"), "sldMenu") : dojo.addClass(document.getElementById("d_adaptation_strategy"), "sldMenu");
    hlms = showms == "" ? dojo.removeClass(document.getElementById("d_mitigation_strategy"), "sldMenu") : dojo.addClass(document.getElementById("d_mitigation_strategy"), "sldMenu");
    //hlcl = showcl == "" ? dojo.removeClass(document.getElementById("d_crops_livestock"), "sldMenu") : dojo.addClass(document.getElementById("d_crops_livestock"), "sldMenu");
    hlccc = showccc == "" ? dojo.removeClass(document.getElementById("d_climate_change_challenges"), "sldMenu") : dojo.addClass(document.getElementById("d_climate_change_challenges"), "sldMenu");
    //hlaz = showaz == "" ? dojo.removeClass(document.getElementById("d_agroecological_zones"), "sldMenu") : dojo.addClass(document.getElementById("d_agroecological_zones"), "sldMenu");

    var newURL = baseDataURL+"?fmt=csv"+showpts + showimp + showas + showms + showcl + showccc + showaz;
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
        dojo.connect(dataLayer, "onMouseOver", onFeatureHover);
        dojo.connect(dataLayer, "onMouseOut", onFeatureLeave);
        setView();
    }
}

function disableFormsOnQuery()
{
    showLoading();

    var pts = document.pts;
    var imp = document.impacts;
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
    for (var i=0;i<imp.length;i++)
    {
        imp.elements[i].disabled="true";
    }
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
    var imp = document.impacts;
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
    for (var i=0;i<imp.length;i++)
    {
        imp.elements[i].disabled="";
    }
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
    var imp = document.impacts;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
    clearAllChecks(imp);
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
    var imp = document.impacts;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
    var showpts = "";
    var showimp = "";
    var showas = "";
    var showms = "";
    var showcl = "";
    var showccc = "";
    var showaz = "";
    var showLyr = "";

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
    for (var i=0;i<imp.length;i++)
    {
        if(imp.elements[i].checked)
        {
            showimp += imp.elements[i].value+",";
        }
    }
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
    showimp = showimp == "" ? "" : "/imp="+showimp;
    showas = showas == "" ? "" : "/as="+showas;
    showms = showms == "" ? "" : "/ms="+showms;
    showcl = showcl == "" ? "" : "/cl="+showcl;
    showccc = showccc == "" ? "" : "/ccc="+showccc;
    showLyr = ((typeof vLyr == "undefined") || vLyr == "") ? "" : "/lyr="+vLyr;
    ((typeof vLyr != "undefined") && vLyr != "") ? dojo.addClass(document.getElementById("rsLayers_label"), "sldMenu") : dojo.removeClass(document.getElementById("rsLayers_label"), "sldMenu");

    //vLyr = showLyr;


    //showaz = showaz == "" ? "" : "/az="+showaz;
    mapCenter = "/ctr="+map.extent.getCenter().x+";"+map.extent.getCenter().y;
    mapLevel = "/lvl="+map.getLevel();
    var setBaseMP = "/bm="+baseMP;
    var showGCP = "";
    location.hash = setBaseMP + showGCP + mapCenter + mapLevel + showpts + showimp + showas + showms + showcl + showccc + showaz + showLyr;
}

function getView()
{
    var pts = document.pts;
    var imp = document.impacts;
    var as = document.adaptation_strategy;
    var ms = document.mitigation_strategy;
    var cl = document.crops_livestock;
    var ccc = document.climate_change_challenges;
    var az = document.agroecological_zones;
    var showpts = "";
    var showimp = "";
    var showas = "";
    var showms = "";
    var showcl = "";
    var showccc = "";
    var showaz = "";
    var showLyr = "";
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
                    case "imp":
                        checkTaxElements("impacts", theMap[mp].split("=")[1]);
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
                    case "lyr":
                        vLyr = theMap[mp].split("=")[1];
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
    //         showHideGCP();
    if(ctrPt && lvlMp){
        move = new esri.geometry.Point([parseFloat(ctrPt.split(";")[0]), parseFloat(ctrPt.split(";")[1])], new esri.SpatialReference({
            wkid:4326
        }));
        map.centerAndZoom(move, parseFloat(lvlMp));                 
    }
    ctrPt = "";
    lvlMp = "";
    setBaseMap(baseMP);
    updateDataLayer(false);
}
function go2Region(pt, zm)
{
    move2 = new esri.geometry.Point([parseFloat(pt.split(";")[0]), parseFloat(pt.split(";")[1])], new esri.SpatialReference({
        wkid:4326
    }));
    map.centerAndZoom(move2, parseFloat(zm));
    map.centerAt(map.extent.getCenter());
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
    var setExt = new esri.geometry.Extent({
        "xmin":xMn,
        "ymin":yMn,
        "xmax":xMx,
        "ymax":yMx,
        "spatialReference":{
            "wkid":102100
        }
    });
map.setExtent(setExt);
}

function createMapMenu() {
    // Creates right-click context menu for map
    ctxMenuForMap = new dijit.Menu({
        onOpen: function(box) {
            currentLocation = getMapPointFromMenuPosition(box);          
        }
    });

    ctxMenuForMap.addChild(new dijit.MenuItem({ 
        label: "Center and zoom here",
        onClick: function(evt) {
            var centerPoint = new esri.geometry.Point(currentLocation.x,currentLocation.y,currentLocation.spatialReference);
            var tolvl=(map.getLevel() < 10) ? map.getLevel()+1 : 10;
            map.centerAndZoom(centerPoint, tolvl);
        }
    }));
    ctxMenuForMap.startup();
    ctxMenuForMap.bindDomNode(map.container);
}
function zoomToCtxt(){
    var tolvl=(map.getLevel() < 10) ? map.getLevel()+1 : 10;
    map.centerAndZoom(cPx, tolvl);
}
function zoomToOExt(){
    var tExt = new esri.geometry.Extent({
        "xmin":intMinExtX,
        "ymin":intMinExtY,
        "xmax":intMaxExtX,
        "ymax":intMaxExtY,
        "spatialReference":{
            "wkid":102100
        }
    });
map.setExtent(tExt);
}
function getMapPointFromMenuPosition(box) {
    var x = box.x, y = box.y;

    switch(box.corner) {
        case "TR":
            x += box.w;
            break;
        case "BL":
            y += box.h;
            break;
        case "BR":
            x += box.w;
            y += box.h;
            break;
    }

    var screenPoint = new esri.geometry.Point(x - map.position.x, y - map.position.y);
    return map.toMap(screenPoint);
}
function findPointsInExtent(extent) {
    var results = [];
    //vfunctionar findInExt = new esri.geometry.Extent({"xmin":extent.xmin,"ymin":extent.ymin,"xmax":extent.xmax,"ymax":extent.ymax,"spatialReference":{"wkid":102100}});
    vtonmap = [];
    cconmap = [];
    bgonmap = [];
    bdonmap = [];
    ptonmap = [];
    //alert(map.graphics.graphics.length);
    dojo.forEach(dataLayer.graphics,function(graphic){
        if (extent.contains(graphic.geometry)) {
            results.push(getListingContent(graphic.attributes.id));
        }
    });

    //display number of points in extent
    //dojo.byId("inextent").innerHTML = results.length;
    var onthemap = dijit.byId('onthemap');
    onthemap.attr("title", "What&#39;s on the map ("+results.length+")");
    //display list of points in extent
    //dojo.byId("results").innerHTML = "<table style='width:100%;'><tbody><tr><td><ul>" + results.join("") + "<ul></tr></td></tbody></table>";
    dojo.byId("onmap_ccafs_sites").innerHTML = "<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + cconmap.join("") + "<ul></tr></td></tbody></table>";
    dojo.byId("onmap_video_testimonials").innerHTML = "<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + vtonmap.join("") + "<ul></tr></td></tbody></table>";
    dojo.byId("onmap_amkn_blog_posts").innerHTML = "<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + bgonmap.join("") + "<ul></tr></td></tbody></table>";
    dojo.byId("onmap_biodiv_cases").innerHTML = "<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + bdonmap.join("") + "<ul></tr></td></tbody></table>";
    dojo.byId("onmap_photo_testimonials").innerHTML = "<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + ptonmap.join("") + "<ul></tr></td></tbody></table>";

    var ccTx = dijit.byId('accord_ccafs_sites');
    var vtTx = dijit.byId('accord_video_testimonials');
    var bpTx = dijit.byId('accord_amkn_blog_posts');
    var bcTx = dijit.byId('accord_biodiv_cases');
    var ptTx = dijit.byId('accord_photo_testimonials');
    ccTx.attr("title", "Benchmark Sites ("+cconmap.length+")");
    vtTx.attr("title", "Videos ("+vtonmap.length+")");
    bpTx.attr("title", "Blog Posts ("+bgonmap.length+")");
    bcTx.attr("title", "Agrobiodiversity Cases ("+bdonmap.length+")");
    ptTx.attr("title", "Photo Sets ("+ptonmap.length+")");


}
function setTrans(value){
    var cL = map.getLayer(visLyr);
    if(cL != null)
    {
        cL.setOpacity(value);
    }
}
function findPointsInPolygon(extent, evt) {
    var results = [];
    dojo.forEach(dataLayer.graphics,function(graphic){
        if (extent.contains(graphic.geometry)) {
            results.push(getListingContent(graphic.attributes.id));
        }
    });

    //display list of points in extent
    //dojo.byId("cAtLoc").innerHTML = "At this location ("+results.length+")<br /><table><tbody><tr><td><ul>" + results.join("") + "<ul></tr></td></tbody></table>";
    cPx = new esri.geometry.Point(map.toMap(evt.screenPoint).x,map.toMap(evt.screenPoint).y,map.spatialReference);

    //          map.infoWindow.setContent("<table><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + results.join("") + "<ul></tr></td></tbody></table>");
    //          map.infoWindow.setTitle("At this location ("+results.length+") <a href='javascript:void(0)'>Zoom here</a>");
    //          map.infoWindow.show(evt.screenPoint,map.getInfoWindowAnchor(evt.screenPoint));
    var ttContent = "<span class='blockNoWrap'>At this location ("+results.length+") <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='zoomToCtxt();'><a>Zoom here</a></button> <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='cPop();'><a>Close</a></button></span>";
    ttContent += "<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + results.join("") + "<ul></tr></td></tbody></table>";
    //          var font = new esri.symbol.Font("24px", esri.symbol.Font.ALIGN_MIDDLE, esri.symbol.Font.STYLE_NORMAL, esri.symbol.Font.VARIANT_NORMAL, esri.symbol.Font.WEIGHT_BOLDER);
    //              
    //              hoverText = new esri.symbol.TextSymbol(results.length, font, new dojo.Color([255, 255, 255]));
    //              hoverText.yoffset = 0;
    //              map.graphics.add(new esri.Graphic(evt.mapPoint, hoverText));
    //            hoverLayer.add(hoverText);

    hQuery.setContent(ttContent);

    dojo.style(hQuery.domNode, "opacity", 1);
    dijit.popup.open({
        popup: hQuery, 
        x:evt.pageX,
        y:evt.pageY
        });

}
function getItemsAtLocation(sPtX, sPtY, evt)
{
    var sPt1 = new esri.geometry.Point(sPtX-20, sPtY+20);
    var sPt2 = new esri.geometry.Point(sPtX+20, sPtY+20);
    var sPt3 = new esri.geometry.Point(sPtX+20, sPtY-20);
    var sPt4 = new esri.geometry.Point(sPtX-20, sPtY-20);
    hoverLayer.remove(polyGraphic);
    points = [
    map.toMap(sPt1),
    map.toMap(sPt2),
    map.toMap(sPt3),
    map.toMap(sPt4),
    map.toMap(sPt1)
    ];
    var polygon = new esri.geometry.Polygon();
    polygon.addRing(points);
    polygon.spatialReference = new esri.SpatialReference({
        wkid: 102100
    });

    // Add the polygon to map
    var gs = new esri.symbol.SimpleFillSymbol().setStyle(esri.symbol.SimpleFillSymbol.STYLE_SOLID);
    polyGraphic = new esri.Graphic(polygon, gs);
    hoverLayer.add(polyGraphic);
      
    findPointsInPolygon(polygon.getExtent(), evt);     
}
var addedLayers=[];
function buildLayerList(layer, lID, layerName, single) {
    //map.addLayer(layer);
    addedLayers.push(layerName);
    //layer.setOpacity(0.5);
    layer.setVisibility(false);
    layer.setImageTransparency(true, false);
    var singleLyr = single==null ? -1 : single;
    var lyrH="";
    var checked="";
    //var tmp = "<input name='aLayer_"+lID+"' type='radio' class='list_item_"+lID+"' id='00' onclick='updateLayerVisibility(null, \""+layer.id+"\");' /><label for='00'>Hide All Layers</label>";
    var tmp = "";
    var items = dojo.map(layer.layerInfos,function(info,index){
        //  if (info.defaultVisibility) {
        //    visible.push(info.id);
        //  }  set('checked', true/false)

        checked = (((typeof vLyr != "undefined") && vLyr != "") && (vLyr.split("|")[0]==layerName) && (vLyr.split("|")[2]==info.id)) ? " checked=\"checked\"" : "";

        if(singleLyr == -1){
            bf = info.parentLayerId == -1 ? "<li class='l1'>" : "<li class='l2'>";
            af = info.parentLayerId == -1 ? "</li>" : "</li>";
            //  lyrH += bf+"<input name='aLayer_"+lID+"' type='radio' class='list_item_"+lID+"' id='" + info.id + "' onclick='updateLayerVisibility("+lID+", \""+layer.id+"\");' /><label for='" + info.id + "'>" + info.name + "</label>"+af;        
            if((info.parentLayerId == -1 && info.subLayerIds == null) || (info.parentLayerId != -1 && info.subLayerIds == null)){
                lyrH += bf+"<input"+checked+" name='aLayer' type='radio' class='list_item_"+lID+"' id='" + info.id + "' onclick='updateLayerVisibility("+lID+", \""+layer.id+"\");' /><label for='" + info.id + "'>" + info.name + "</label>"+af;        
            }else{
                lyrH += bf+"<b>"+info.name+"</b>"+af;
            }
        }
        else {
            if(info.id == singleLyr){
                bf = info.parentLayerId == -1 ? "<li class='l1'>" : "<li class='l2'>";
                af = info.parentLayerId == -1 ? "</li>" : "</li>";
                //      lyrH += bf+"<input name='aLayer_"+lID+"' type='radio' class='list_item_"+lID+"' id='" + info.id + "' onclick='updateLayerVisibility("+lID+", \""+layer.id+"\");' /><label for='" + info.id + "'>" + info.name + "</label>"+af;        
                lyrH += bf+"<input"+checked+" name='aLayer' type='radio' class='list_item_"+lID+"' id='" + info.id + "' onclick='updateLayerVisibility("+lID+", \""+layer.id+"\");' /><label for='" + info.id + "'>" + info.name + "</label>"+af;        
            }
        }
    });
    //layer.setVisibleLayers(visible);//
    if(((typeof vLyr != "undefined") && vLyr != "") && fUd==false && vLyr.split("|")[0]==layerName){
        fUd=true;
        visible = [];
        visible.push(vLyr.split("|")[2]);
        visLyr=layerName;
        layer.setVisibility(true);
        layer.setVisibleLayers(visible);
        dijit.byId('cFiltersList').selectChild(dijit.byId('accord_legend'));
        dojo.addClass(document.getElementById("layerbt_"+layerName), "sldMenu");
        map.centerAt(map.extent.getCenter());
    //    rLegend();
    }
    return "<ul class='homebox-list zoom_in-list'>"+tmp+lyrH+"</ul>";
}
function updateLayerVisibility(lID, lyrID) {
    var inputs = dojo.query(".list_item_"+lID), input;
    var cLyr = map.getLayer(lyrID);
    cLyr.setVisibility(false);
    (typeof visLyr != "undefined") ? map.getLayer(visLyr).setVisibility(false) : "";
    (typeof visLyr != "undefined") ? dojo.removeClass(document.getElementById(visLyr+"_label"), "sldMenu") : "";
    (typeof visLyr != "undefined") ? dojo.removeClass(document.getElementById("layerbt_"+visLyr), "sldMenu") : "";
    if(cLyr != null)
    {
        dijit.byId('tslider').setValue(cLyr.opacity * 100);
    }
    
    //    (lID != null) ? map.setMapCursor("help") : map.setMapCursor("auto");
    visLyr=lyrID;
    vLyr="";
    var test="";
    visible = [];
    dojo.forEach(inputs,function(input){
        if (input.checked) {
            visible.push(input.id);
            vLyr = lyrID+"|"+lID+"|"+input.id;
        }
    });
    //if there aren't any layers visible set the array to be -1
    if(visible.length === 0){
        visible.push(-1);
    }
    (visible.length != -1) ? cLyr.setVisibility(true) : cLyr.setVisibility(false);
    (lID != null) ? dojo.addClass(document.getElementById(lyrID+"_label"), "sldMenu") : dojo.removeClass(document.getElementById(lyrID+"_label"), "sldMenu");
    (visible.length != -1) ? cLyr.setVisibleLayers(visible) : "";
    var tpp=0;
    for (var al=0;al<addedLayers.length;al++)
    {
        if(dojo.hasClass(document.getElementById(addedLayers[al]+"_label"), "sldMenu")){
            tpp ++;
        }
    }
    (tpp > 0) ? dojo.addClass(document.getElementById("rsLayers_label"), "sldMenu") : dojo.removeClass(document.getElementById("rsLayers_label"), "sldMenu");
    //    (tpp > 0) ? dijit.byId("showLeg").set('disabled', false) : dijit.byId("showLeg").setAttribute('disabled', true);
    //    (tpp > 0) ? "" : dijit.byId("legendWindow").hide();

    var deltLyr;
    clearTimeout(deltLyr);
    deltLyr = setTimeout(function() {  
        map.centerAt(map.extent.getCenter());
        rLegend();
    }, 1000);


    dojo.hasClass(document.getElementById("onthemap"), "dojoxExpandoClosed")?dijit.byId('onthemap').toggle():"";
    dijit.byId('cFiltersList').selectChild(dijit.byId('accord_legend'));
}
function updateInitLyr(lID, lyrID, id) {
    var cLyr = map.getLayer(lyrID);
    cLyr.setVisibility(false);
    (typeof visLyr != "undefined") ? map.getLayer(visLyr).setVisibility(false) : "";
    (typeof visLyr != "undefined") ? dojo.removeClass(document.getElementById(visLyr+"_label"), "sldMenu") : "";
    visLyr=lyrID;
    vLyr="";
    visible = [];
    visible.push(id);
    vLyr = lyrID+"|"+lID+"|"+id;
    (visible.length != -1) ? cLyr.setVisibility(true) : cLyr.setVisibility(false);
    (lID != null) ? dojo.addClass(document.getElementById(lyrID+"_label"), "sldMenu") : dojo.removeClass(document.getElementById(lyrID+"_label"), "sldMenu");
    (visible.length != -1) ? cLyr.setVisibleLayers(visible) : "";
    var tpp=0;
    for (var al=0;al<addedLayers.length;al++)
    {
        if(dojo.hasClass(document.getElementById(addedLayers[al]+"_label"), "sldMenu")){
            tpp ++;
        }
    }
    (tpp > 0) ? dojo.addClass(document.getElementById("rsLayers_label"), "sldMenu") : dojo.removeClass(document.getElementById("rsLayers_label"), "sldMenu");
    map.centerAt(map.extent.getCenter());
//    rLegend();
}

var mp = {};
mp.lMap = function(){
    var lMapTimer;
    clearTimeout(lMapTimer);
    lMapTimer = setTimeout(function() {  
        initMap();
    }, 500);
}
dojo.addOnLoad(function(){
    mp.lMap();
});