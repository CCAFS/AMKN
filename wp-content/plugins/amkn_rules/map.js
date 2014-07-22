/*
 *  This file is part of Adaptation and Mitigation Knowledge Network (AMKN).
 *
 *  AMKN is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  at your option) any later version.
 *
 *  AMKN is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with DMSP.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2012 (C) Climate Change, Agriculture and Food Security (CCAFS)
 * 
 * Created on : 20-10-2012
 * @author      
 * @version     1.0
 */

dojo.require("esri.map");
dojo.require("dojox.data.CsvStore");
dojo.require("esri.arcgis.utils");
dojo.require("esri.dijit.OverviewMap");
dojo.require("dijit.dijit");
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
dojo.require("esri.dijit.Popup");
dojo.require("esri.dijit.PopupTemplate");
dojo.require("esri.lang");

var maxExtX = -20006031.09149561;
var maxExtY = -12433824.981519768;
var minExtX = 18816641.322648488;
var minExtY = 17739844.80810231;
var intMaxExtX = 16985396.45583168;
var intMaxExtY = 7524106.992139481;
var intMinExtX = -7728835.025551194;
var intMinExtY = -5586372.099330453;
var initLvl = 3;

var map, visLyr, popup, popupOptions, tLayers = [], vLyr, qPop, identifyTask, identifyParams, legend, hQuery, cPx, cHType, polyGraphic, hoverGraphic, hoverText, currentLocation, popupWindow, cntr, idCT, highlightSymbol, highlightGraphic, showLegend, sGCP, baseMP, iconT, baseExt, ctrPt, lvlMp, loadExtent, mapLevel, mapExtent, basemapGallery, tiledMapServiceLayer, gcpFarmingSystems, africaTSLayers, multipoint, popupSize, loading, initExtent, maxExtent, dataLayer, hoverLayer, syms6, syms4, syms5, syms2, syml6, syml4, syml5, syml2, visible = [], legendLayers = [], featureLayer, featureRegion, totalSources;
var dataLayerVt, dataLayerCs, dataLayerBp, dataLayerBc, dataLayerPt, dataLayerCa;
var vtonmap = [];
var cconmap = [];
var bgonmap = [];
var bdonmap = [];
var ptonmap = [];
totalSources = {};
oactnmap = {};
topics = {'1': 'Adaptation to Progressive Climate Change', '2': 'Adaptation through Managing Climate Risk', '3': ' Pro-Poor Climate Change Mitigation', '4.1': ' Linking Knowledge to Action', '4.2': 'Data and Tools for Analysis and Planning', '4.3': 'Policies and Institutions'};

/**
 * @function initMap
 * @description this method is incharge of initialise the map, it make the calls and the assignations to the map to be loaded
 * @return {void} 
 **/
function initMap() {
    baseMP = 'basemap_5';
    getViewTree();
    syml6 = new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/pin-mini.png?ver=2", 17, 25);
    syms6 = new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/pin-mini.png?ver=2", 7, 10);
    syml4 = new esri.symbol.PictureMarkerSymbol('./wp-content/themes/amkn_theme/images/amkn_blog_posts-mini.png?ver=2', 21, 21);
    syml5 = new esri.symbol.PictureMarkerSymbol('./wp-content/themes/amkn_theme/images/photo_testimonials-mini.png?ver=2', 21, 21);
    syml2 = new esri.symbol.PictureMarkerSymbol('./wp-content/themes/amkn_theme/images/video_testimonials-mini.png?ver=2', 21, 21);
    sym7 = new esri.symbol.PictureMarkerSymbol('./wp-content/themes/amkn_theme/images/biodiv_cases-mini.png?ver=2', 21, 21);
    symh2 = new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/video_testimonials-miniH.gif", 21, 21);
    symh4 = new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/amkn_blog_posts-miniH.gif", 21, 21);
    symh5 = new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/photo_testimonials-miniH.gif", 21, 21);
    symh6 = new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/ccafs_sites-miniH.gif", 17, 25);
    symhX = new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/biodiv_cases-miniH.gif", 21, 21);
    symhA = new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/ccafs_activities-mini.png?ver=2", 21, 21);
    syms4 = new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0, 0, 255]));
    syms5 = new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0, 0, 255]));
    syms2 = new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0, 0, 255]));
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
    loading = dojo.byId("loadingImg");
    initExtent = new esri.geometry.Extent({
        "xmin": intMinExtX,
        "ymin": intMinExtY,
        "xmax": intMaxExtX,
        "ymax": intMaxExtY,
        "spatialReference": {
            "wkid": 102100
        }
    });
    qPop = new dijit.TooltipDialog({
        style: "position: absolute; min-width: 250px; max-width: 350px;z-index:100;"
    });
    qPop.startup();
    map = new esri.Map("map", {
        extent: initExtent,
        isZoomSlider: false,
        wrapAround180: true
    });
//    getActivitiesByCountry();
    dojo.connect(map, "onUpdateStart", showLoading);
    dojo.connect(map, "onUpdateEnd", hideLoading);
    dojo.connect(map, "onPanStart", showLoading);
    dojo.connect(map, "onPanEnd", hideLoading);
    dojo.connect(map, "onZoomStart", showLoading);
    dojo.connect(map, "onZoomEnd", hideLoading);
    dojo.connect(map, 'onLoad', function(map) {
        createMapMenu();
        map.disableScrollWheelZoom();
        highlightGraphic = new esri.Graphic(null, cHType);
        map.graphics.add(highlightGraphic);
        dojo.connect(dijit.byId('map'), 'resize', resizeMap);
        var overviewMapDijit = new esri.dijit.OverviewMap({
            map: map,
            visible: false
        });
        overviewMapDijit.startup();
        initBackMap();
        dojo.removeClass("tb3", "hide");
    });
    dojo.connect(map, "onExtentChange", function(extent) {
        setViewTree();
        dijit.popup.close(hQuery);
        findPointsInExtentTree(map.extent);
        hoverLayer.remove(polyGraphic);
    });
    dojo.connect(map, "onKeyDown", function(evt) {
        dijit.popup.close(hQuery);
    });
    createDataLayersBranch();

    basemapGallery = new esri.dijit.BasemapGallery({
        showArcGISBasemaps: true,
        map: map
    }, "basemapGallery");
    basemapGallery.startup();

    dojo.connect(basemapGallery, "onSelectionChange", function() {
        baseMP = basemapGallery.getSelected().id;
        setViewTree();
    });

    require(["dojo/on"], function(on) {
        on(basemapGallery, "load", function() {
            basemapGallery.select(baseMP);
        });
    });

    tiledMapServiceLayer = new esri.layers.ArcGISTiledMapServiceLayer("http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer");
    map.addLayer(tiledMapServiceLayer);
    multipoint = new esri.geometry.Multipoint(new esri.SpatialReference({
        wkid: 4326
    }));
    dataLayer = new esri.layers.GraphicsLayer();
    dataLayerVt = new esri.layers.GraphicsLayer();
    dataLayerCs = new esri.layers.GraphicsLayer();
    dataLayerBp = new esri.layers.GraphicsLayer();
    dataLayerBc = new esri.layers.GraphicsLayer();
    dataLayerPt = new esri.layers.GraphicsLayer();
    dataLayerCa = new esri.layers.GraphicsLayer();
    hoverLayer = new esri.layers.GraphicsLayer();
    dataLayer.hide();
    dataLayerVt.hide();
    dataLayerCs.hide();
    dataLayerBp.hide();
    dataLayerBc.hide();
    dataLayerPt.hide();
    dataLayerCa.hide();
    layersSwitchInitial();
    map.addLayer(dataLayer);
    map.addLayer(dataLayerVt);
    map.addLayer(dataLayerCs);
    map.addLayer(dataLayerBp);
    map.addLayer(dataLayerBc);
    map.addLayer(dataLayerPt);
    map.addLayer(dataLayerCa);
    map.addLayer(hoverLayer);
    dojo.connect(dataLayer, "onClick", onFeatureClick);
    dojo.connect(map.graphics, "onClick", onFeatureClick);
    dojo.connect(dataLayer, "onMouseOver", onFeatureHover);
    dojo.connect(hoverLayer, "onMouseOut", onFeatureLeave);
    dojo.connect(dataLayerVt, "onMouseOver", onFeatureHover);
    dojo.connect(dataLayerCs, "onMouseOver", onFeatureHover);
    dojo.connect(dataLayerBp, "onMouseOver", onFeatureHover);
    dojo.connect(dataLayerBc, "onMouseOver", onFeatureHover);
    dojo.connect(dataLayerPt, "onMouseOver", onFeatureHover);
    dojo.connect(dataLayerCa, "onMouseOver", onFeatureHover);
    dojo.connect(hoverLayer, "onMouseOver", showTT);
    dojo.connect(map, "onLoad", addDataLayers);

    require(["dijit/Tooltip", "dojo/domReady!"], function(Tooltip) {
        new Tooltip({
            connectId: ["filter-button"],
            label: "Resources"
        });
        new Tooltip({
            connectId: ["legend-button"],
            label: "Data Layers"
        });
        new Tooltip({
            connectId: ["basemap-button"],
            label: "Base map galery"
        });
        new Tooltip({
            connectId: ["region-button"],
            label: "CCAFS Regions"
        });
        new Tooltip({
            connectId: ["reset-button"],
            label: "Reset zoom"
        });
    });
}

function layersSwitchInitial() {
    var pointsi = $("#cFiltersList2").dynatree("getTree").getSelectedNodes();
    for (var i = 0; i < pointsi.length; i++) {
        if (pointsi[i].data.key.match('accord_')) {
            switch (pointsi[i].data.key) {
                case 'accord_ccafs_sites':
                    dataLayerCs.show();
                    break;
                case 'accord_video_testimonials':
                    dataLayerVt.show();
                    break;
                case 'accord_amkn_blog_posts':
                    dataLayerBp.show();
                    break;
                case 'accord_biodiv_cases':
                    dataLayerBc.show();
                    break;
                case 'accord_photo_testimonials':
                    dataLayerPt.show();
                    break;
                case 'accord_ccafs_activities':
                    dataLayerCa.show();
                    break;
            }
        }
    }
}

function layersSwitch(node, flag) {
    switch (node) {
        case 'accord_ccafs_sites':
            if (flag)
                dataLayerCs.show();
            else
                dataLayerCs.hide();
            break;
        case 'accord_video_testimonials':
            if (flag)
                dataLayerVt.show();
            else
                dataLayerVt.hide();
            break;
        case 'accord_amkn_blog_posts':
            if (flag)
                dataLayerBp.show();
            else
                dataLayerBp.hide();
            break;
        case 'accord_biodiv_cases':
            if (flag)
                dataLayerBc.show();
            else
                dataLayerBc.hide();
            break;
        case 'accord_photo_testimonials':
            if (flag)
                dataLayerPt.show();
            else
                dataLayerPt.hide();
            break;
        case 'accord_ccafs_activities':
            if (flag)
                dataLayerCa.show();
            else
                dataLayerCa.hide();
            break;
    }
}

function getActivitiesByCountry() {
//    showLoading();   
    var regmap = {};

    var csvStore = new dojox.data.CsvStore({
        url: regionsDataURL
    });
    csvStore.fetch({
        onComplete: function(items, request) {
            var labelField, regField, typeField, cIDField;
            var defaultFields = ["Regions", "Location", "CID", "Type"];
            dojo.forEach(items, function(item, index) {
                if (index === 0) {
                    regField = defaultFields[0];
                    labelField = defaultFields[1];
                    cIDField = defaultFields[2];
                    typeField = defaultFields[3];
                }
                if (csvStore.getValue(item, typeField) == 'ccafs_activities') {
                    if (!regmap[csvStore.getValue(item, regField)])
                        regmap[csvStore.getValue(item, regField)] = [];
                    regmap[csvStore.getValue(item, regField)].push({
                        cIDField: csvStore.getValue(item, cIDField),
                        labelField: csvStore.getValue(item, labelField),
                        typeField: csvStore.getValue(item, typeField)
                    });
                }
            });
            polygonsDraw(regmap);
            findPointsRegions(regmap);
            featureLayer.hide();
//          hideLoading();
        },
        onError: function(error) {
        }
    });
}

function polygonsDraw(regions) {
//create a popup to replace the map's info window
    var content = "<b>Name</b>: ${SHAPE_AREA}" + "<br /><b>Area</b>: ${COUNTRY}";
    var infoTemplate = new esri.InfoTemplate("${address}", content);

    //create a feature layer based on the feature collection
    featureLayer = new esri.layers.FeatureLayer("http://gisweb.ciat.cgiar.org/arcgis/rest/services/CCAFS/ccafs_climate/MapServer/0",
            {
                mode: esri.layers.FeatureLayer.MODE_SNAPSHOT,
//      infoTemplate: infoTemplate,
                outFields: ["*"]
            });
    featureLayer.setDefinitionExpression("COUNTRY IN ('" + Object.keys(regions).join("','") + "')");
//    var symbol = new esri.symbol.SimpleFillSymbol(esri.symbol.SimpleFillSymbol.STYLE_SOLID, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([0, 0, 0, 1]), 1), new dojo.Color([0, 255, 0, 0.35]));
    var symbol = new esri.symbol.SimpleFillSymbol(esri.symbol.SimpleFillSymbol.STYLE_SOLID, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([255, 255, 255, 0.35]), 1), new dojo.Color([125, 125, 125, 0.35]));
    featureLayer.setRenderer(new esri.renderer.SimpleRenderer(symbol));
    map.addLayer(featureLayer, 0);

    featureLayer.on("click", function(evt) {
//    console.log(JSON.stringify(evt.graphic.geometry, null, 4));
        var results = [];
        dojo.forEach(regions[evt.graphic.attributes['COUNTRY']], function(item) {
            if (item.typeField == "ccafs_activities") {
                ttl = item.labelField.split('|');
                ttl = "<b>Title: </b>" + ttl[0] + "<br><b>Contact: </b>" + ttl[1].replace(/#/gi, ", ") + "<br><b>Topic: </b>" + topics[ttl[2]];
            }
            results.push("<li style='cursor:pointer;' onMouseOut='onFeatureLeave()' onclick='document.location = \"./?p=" + item.cIDField + "\"''>" + "<img class='titleImg' src='./wp-content/themes/amkn_theme/images/" + item.typeField + "-mini.png?ver=2' />&nbsp;" + ttl + "</li>");
        });

        var ttContent = "<span class='blockNoWrap'>At " + evt.graphic.attributes['COUNTRY'] + " (" + results.length + ") <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='zoomToCtxt();'><a>Zoom here</a></button> <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='cPop();'><a>Close</a></button></span>";
        ttContent += "<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + results.join("") + "<ul></tr></td></tbody></table>";

        hQuery.setContent(ttContent);
        dojo.style(hQuery.domNode, "opacity", 1);
        dijit.popup.open({
            popup: hQuery,
            x: evt.pageX,
            y: evt.pageY
        });
//    dojo.forEach(featureLayer.graphics,function(item){
//      console.log(JSON.stringify(item.attributes, null, 4));
//    });
//    alert(featureLayer.graphics);
    });

    var highlightSymbol = new esri.symbol.SimpleFillSymbol(
            esri.symbol.SimpleFillSymbol.STYLE_NULL,
            new esri.symbol.SimpleLineSymbol(
                    esri.symbol.SimpleLineSymbol.STYLE_SOLID,
                    new dojo.Color([125, 125, 125]), 3
                    ),
            new dojo.Color([125, 125, 125, 0.35])
            );

    //listen for when the onMouseOver event fires on the countiesGraphicsLayer
    //when fired, create a new graphic with the geometry from the event.graphic and add it to the maps graphics layer
    featureLayer.on("mouse-over", function(evt) {
        var highlightGraphic = new esri.Graphic(evt.graphic.geometry, highlightSymbol);
        map.graphics.add(highlightGraphic);
    });
    featureLayer.on("mouse-out", function(evt) {
        map.graphics.clear();
    });
    featureLayer.on("selection-complete", function(evt) {
        alert(featureLayer.graphics + '@');
    });
//    dojo.forEach(featureLayer.graphics,function(graphic){
//      if(extent.contains(graphic.geometry)){       
//            results.push(getListingContentTree(graphic.attributes.id));
//        } 
//    });
}

function highlightRegions(region) {
    if ((typeof featureRegion != 'undefined'))
        map.removeLayer(featureRegion);

    var contriesRegion = {};
//  contriesRegion['la'] = "'Guatemala','Honduras','El Salvador','Nicaragua','Colombia','Peru'";
    contriesRegion['la'] = "'GT','HO','ES','NU','CO','PE'";
//  contriesRegion['wa'] = "'Senegal','Mali','Niger','Ghana','Burkina Faso'";
    contriesRegion['wa'] = "'SG','ML','NG','GH','UV'";
//  contriesRegion['ea'] = "'Ethiopia','Kenya','Uganda','Tanzania'";
    contriesRegion['ea'] = "'ET','KE','UG','TZ'";
//  contriesRegion['sa'] = "'India','Nepal','Bangladesh'";
    contriesRegion['sa'] = "'IN','NP','BG'";
//  contriesRegion['sea'] = "'Vietnam','Cambodia','Laos'";
    contriesRegion['sea'] = "'VM','CB','LA'";
    //create a feature layer based on the feature collection
    featureRegion = new esri.layers.FeatureLayer("http://gisweb.ciat.cgiar.org/arcgis/rest/services/CCAFS/ccafs_climate/MapServer/0",
            {
                mode: esri.layers.FeatureLayer.MODE_SNAPSHOT,
                outFields: ["*"]
            });
    featureRegion.setDefinitionExpression("FIPS_CNTRY IN (" + contriesRegion[region] + ")");
    var symbol = new esri.symbol.SimpleFillSymbol(esri.symbol.SimpleFillSymbol.STYLE_SOLID, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([255, 255, 255, 0.35]), 1), new dojo.Color([125, 125, 125, 0.35]));
    featureRegion.setRenderer(new esri.renderer.SimpleRenderer(symbol));
    map.addLayer(featureRegion, 0);

    var highlightSymbol = new esri.symbol.SimpleFillSymbol(
            esri.symbol.SimpleFillSymbol.STYLE_NULL,
            new esri.symbol.SimpleLineSymbol(
                    esri.symbol.SimpleLineSymbol.STYLE_SOLID,
                    new dojo.Color([125, 125, 125]), 3
                    ),
            new dojo.Color([125, 125, 125, 0.35])
            );
    //listen for when the onMouseOver event fires on the countiesGraphicsLayer
    //when fired, create a new graphic with the geometry from the event.graphic and add it to the maps graphics layer
    featureRegion.on("mouse-over", function(evt) {
        var highlightGraphic = new esri.Graphic(evt.graphic.geometry, highlightSymbol);
        map.graphics.add(highlightGraphic);
//    console.log(JSON.stringify(evt.graphic.attributes, null, 4));
    });
    featureRegion.on("mouse-out", function(evt) {
        map.graphics.clear();
    });
}
/*
 * This function is without use currently
 * @param {type} evt
 * @returns {void}
 */
function findPointsRegions(regions) {
    var results = [];
    actnmap = [];
    oactnmapr = {};
    tempCidr = 0;
    countCid = 0;
    limitfor = 0;
//    alert(JSON.stringify(regions, null, 4));
    for (var index in regions) {
//      alert(JSON.stringify(regions[index], null, 4));
        results.push(getListingRegionsTree(regions[index]));
    }
    totalSources['reg'] = actnmap.length;
//    dojo.forEach(regions,function(region){
////      alert(JSON.stringify(region, null, 4));
////        if(extent.contains(graphic.geometry)){            
//            results.push(getListingRegionsTree(region));
////        } 
//    });
//    var onthemap=dijit.byId('onthemap');
//    onthemap.attr("title","What&#39;s on the map ("+results.length+")");    
    var rootNode = $("#cFiltersRegion").dynatree("getRoot");
    var childrenNodes = rootNode.getChildren();

    for (i = 0; i < childrenNodes.length; i++) {
        // clean array.
//        if (childrenNodes[i].data.key !== 'accord_data_layer' && childrenNodes[i].data.key !== 'accord_filter_resource_theme') {
//          childrenNodes[i].removeChildren();
//        }
        // add children and update the number of records on it.
        switch (childrenNodes[i].data.key) {
//            case 'accord_ccafs_sites':                
//                childrenNodes[i].addChild(cconmap);
//                childrenNodes[i].data.title = "CCAFS Sites ("+cconmap.length+")";
//                childrenNodes[i].render();
//            break;
//            case 'accord_video_testimonials':     
//                childrenNodes[i].addChild(vtonmap);                
//                childrenNodes[i].data.title = "Videos ("+vtonmap.length+")";
//                childrenNodes[i].render();
//            break;
//            case 'accord_amkn_blog_posts':
//                childrenNodes[i].addChild(bgonmap);
//                childrenNodes[i].data.title = "Blog Posts ("+bgonmap.length+")";
//                childrenNodes[i].render();
//            break;
//            case 'accord_biodiv_cases':
//                childrenNodes[i].addChild(bdonmap);               
//                childrenNodes[i].data.title = "Agrobiodiversity Cases ("+bdonmap.length+")";
//                childrenNodes[i].render();
//            break;
//            case 'accord_photo_testimonials':
//                childrenNodes[i].addChild(ptonmap);                
//                childrenNodes[i].data.title = "Photo Sets ("+ptonmap.length+")";
//                childrenNodes[i].render();
//            break;
            case 'accord_ccafs_activities':
                childrenNodes[i].addChild(actnmap);
                childrenNodes[i].select(true);
                childrenNodes[i].data.title = "Research Projects (" + actnmap.length + ")";
                childrenNodes[i].render();
                break;
        }
    }
}

function getListingRegionsTree(region) {
    var rt, ttl, cid;

    dojo.forEach(region, function(activitie) {
        ttl = activitie.labelField;
        cid = activitie.cIDField;
        rt = activitie.typeField;
//      console.log(JSON.stringify(activitie, null, 4)+limitfor+'//'+cid+'/');
        if (!oactnmap[cid]) {
            countCid = 1;
            if (rt === "ccafs_activities") {
                ttl = ttl.split('|');
                title = "<b>Title: </b>" + ttl[0] + "<br><b>Contact: </b>" + ttl[1].replace(/#/gi, ",") + "<br><b>Topic: </b>" + topics[ttl[2]];
                mapPTS = actnmap.push({
                    title: title,
                    tooltip: ttl[0],
                    key: 52,
                    url: './?p=' + cid,
                    hideCheckbox: true,
                    unselectable: true,
                    select: false,
                    icon: '../../../../images/ccafs_activities-mini.png?ver=2'
                            //isLazy: true
                });
            }
        } else {
            countCid++;
        }
        if (!oactnmapr[cid])
            oactnmapr[cid] = [];
        oactnmapr[cid].push({
            key: 52,
        });
        tempCidr = cid;
        limitfor++;
//      if(limitfor==1) 
//        return;
    });
    return;
}

function updateDataLayerRegionTree(flag)
{
    if (flag)
        featureLayer.show();
    else
        featureLayer.hide();
}

function updateDataLayerPoints(flag)
{
//  console.log(dataLayer.visible+'1$%&'+featureLayer.visible+'//'+flag);
    if (flag == 'regs') {
        dataLayer.hide();
        featureLayer.show();
        dojo.style(dojo.byId('cFiltersList2'), "display", "none");
        dojo.style(dojo.byId('cFiltersRegion'), "display", "block");
    } else if (flag == 'geop') {
        dataLayer.show();
        featureLayer.hide();
        dojo.style(dojo.byId('cFiltersList2'), "display", "block");
        dojo.style(dojo.byId('cFiltersRegion'), "display", "none");
    }
    var onthemap = dijit.byId('onthemap');
    if (dojo.byId('geop').checked)
        onthemap.attr("title", "What&#39;s on the map (" + totalSources['gp'] + ")");
    else
        onthemap.attr("title", "What&#39;s on the map (" + totalSources['reg'] + ")");
}

function closeDialog() {
    map.graphics.clear();
//  dijitPopup.close(dialog);
}

function addToMap(rsts, evt) {
    for (var i = 0, il = rsts.length; i < il; i++) {
        var result = rsts[i];
        qPop.setContent(result.layerName + ": " + result.value);
    }
    dijit.popup.open({
        popup: qPop,
        x: evt.pageX,
        y: evt.pageY
    });
}
function cPop() {
    dijit.popup.close(hQuery);
}
function cT() {
    hideLoading();
}
function showLoading() {
    esri.show(loading);
    dijit.popup.close(hQuery);
    map.disableMapNavigation();
    map.disableScrollWheelZoom();
}
function hideLoading(error) {
    findPointsInExtentTree(map.extent);
    esri.hide(loading);
    map.enableMapNavigation();
    map.disableScrollWheelZoom();
//    findPointsInExtent(map.extent);

//    setViewTree();
}
function processCsvData(url) {
    showLoading();
    var frameUrl = new dojo._Url(window.location.href);
    var csvUrl = new dojo._Url(url);
    if (frameUrl.host !== csvUrl.host || frameUrl.port !== csvUrl.port || frameUrl.scheme !== csvUrl.scheme) {
        url = (proxyUrl) ? proxyUrl + "?" + url : url;
        console.log(url);
    }
    csvStore = new dojox.data.CsvStore({
        url: url
    });
//    console.log(JSON.stringify(csvStore, null, 4));
    csvStore.fetch({
        onComplete: function(items, request) {
            var content = "";
            var labelField, latField, longField, typeField, cIDField;
            var start = new Date().getTime();
            dojo.forEach(items, function(item, index) {
                if (index === 0) {
                    var fields = getAttributeFields(item);
                    labelField = fields[0];
                    latField = fields[1];
                    longField = fields[2];
                    typeField = fields[3];
                    cIDField = fields[4];
                }
                var label = csvStore.getValue(item, labelField) || "";
                var id = csvStore.getIdentity(item);
                addGraphic(id, csvStore.getValue(item, latField), csvStore.getValue(item, longField), csvStore.getValue(item, typeField), true);
                if (!totalSources[csvStore.getValue(item, typeField)])
                    totalSources[csvStore.getValue(item, typeField)] = {};
                totalSources[csvStore.getValue(item, typeField)][csvStore.getValue(item, "CID")] = 1;
//                totalSources[csvStore.getValue(item,typeField)] += 1;
                setTimeout(function() {
                    tmptotal++;
//        console.log(tmptotal+'/'+totalGraphs);        
                    progressbar.progressbar("option", {
                        value: (Math.round((index / items.length) * 100))
                    });
                }, 80);
            });
            var end = new Date().getTime();
            var time = end - start;
//            dojo.forEach(dataLayer.graphics,function(graphic){
//                var geometry=graphic.geometry;
//                if(geometry){
//                    multipoint.addPoint({
//                        x:geometry.x,
//                        y:geometry.y
//                    });
//                }
//            });
//            if(multipoint.points.length>0){
//                maxExtent=multipoint.getExtent();
//            }
            hideLoading();
//            console.log('**'+time);
//            enableFormsOnQuery();
        },
        onError: function(error) {
            console.log(error);
        }
    });
}

/**
 * @function onFeatureClick
 * @description this method executed when the icon in the map is clicked.
 * @argument {object} evt it is the reference of the object in the map
 * @return {void}
 * @
 **/
function onFeatureClick(evt) {
    var graphic = evt.graphic;
    if (graphic) {
        var id = graphic.attributes.id;
        var cid;
        csvStore.fetchItemByIdentity({
            identity: id,
            onItem: function(item) {
                cid = csvStore.getValue(item, "CID");
            }
        });
        document.location = "'./?p=" + cid + "'";
//        setPopupContent(id);
//        map.graphics.remove(highlightGraphic);
//        highlightGraphic=new esri.Graphic(null,cHType);
//        map.graphics.add(highlightGraphic);
//        highlightGraphic.setGeometry(graphic.geometry);
//        highlightGraphic.setAttributes({
//            id:graphic.attributes.id
//        });
//        centerAtPoint(graphic.geometry.x,graphic.geometry.y);
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
        centerAtPoint(match.geometry.x, match.geometry.y);
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

/**
 * @function onFeatureHover
 * @description this method executed when the mouse is over the icon in the map.
 * @argument {object} evt it is the reference of the object in the map
 * @return {void} 
 **/
function onFeatureHover(evt) {
    var gPt2Spt = map.toScreen(evt.graphic.geometry);
    getItemsAtLocation(gPt2Spt.x, gPt2Spt.y, evt);
}

/**
 * @function onListHover
 * @description this method stand out the icon on the map
 * @argument {int} id it is the reference of a item on the map
 * @argument {string} url it is the url for the element selected
 * @return {void} 
 **/
function onListHover(id, url) {
    var cit = (url) ? url.split('=') : '';
    if (typeof oactnmap[cit[1]] == 'undefined') {
        id = parseInt(id);
        if (!isNaN(id)) {
            var graphic = findGraphicById(id);
            map.graphics.remove(hoverGraphic);
            if (typeof graphic !== 'undefined') {
                var id = graphic.attributes.id;
                hoverGraphic = new esri.Graphic(null, highlightSymbol);
                map.graphics.add(hoverGraphic);
                hoverGraphic.setGeometry(graphic.geometry);
                hoverGraphic.setAttributes({
                    id: id
                });
            }
        }
    } else {
        map.graphics.remove(hoverGraphic);
        for (var i = 0; i < oactnmap[cit[1]].length; i++) {
            var graphic = findGraphicById(oactnmap[cit[1]][i].key);
            if (typeof graphic !== 'undefined') {
                var id = graphic.attributes.id;
                hoverGraphic = new esri.Graphic(null, highlightSymbol);
                map.graphics.add(hoverGraphic);
                hoverGraphic.setGeometry(graphic.geometry);
                hoverGraphic.setAttributes({
                    id: id
                });
            }
        }
    }

}
function onFeatureLeave() {
    if(map.graphics) map.graphics.clear();
    hoverLayer.clear();
}
function showTT(evt) {
}
function onQueryByPolyClick() {
}
function centerAtPoint(clkX, clkY)
{
    var displace = map.extent.xmax - clkX;
    var displace2 = clkX - map.extent.getCenter().x;
    var displace3 = (map.extent.xmax - map.extent.getCenter().x) / 2;
    var iDl = displace / displace2;
    var newX = map.extent.getCenter().x + (displace2 - displace3);
    var centerPoint = new esri.geometry.Point(newX, clkY, map.spatialReference);
    map.centerAt(centerPoint);
}
function addGraphic(id, latitude, longitude, type, init) {
    latitude = parseFloat(latitude);
    longitude = parseFloat(longitude);
    if (isNaN(latitude) || isNaN(longitude)) {
        return;
    }
    var geometry = new esri.geometry.Point(longitude, latitude);
    if (dojo.indexOf([102113, 102100, 3857, 4326], map.spatialReference.wkid) !== -1) {
        geometry = esri.geometry.geographicToWebMercator(geometry);
    }
//    var sym6=(document.getElementById('iconType').checked)?syml6:syms6;
//    var sym4=(document.getElementById('iconType').checked)?syml4:syms4;
//    var sym5=(document.getElementById('iconType').checked)?syml5:syms5;
//    var sym2=(document.getElementById('iconType').checked)?syml2:syms2;
    var sym6 = syml6;
    var sym4 = syml4;
    var sym5 = syml5;
    var sym2 = syml2;
    var symA = symhA;
    switch (type) {
        case"video_testimonials":
            dataLayer.add(new esri.Graphic(geometry, sym2, {
                id: id
            }));
            if (init) {
                dataLayerVt.add(new esri.Graphic(geometry, sym2, {
                    id: id
                }));
            }
            break;
        case"ccafs_sites":
            dataLayer.add(new esri.Graphic(geometry, sym6, {
                id: id
            }));
            if (init) {
                dataLayerCs.add(new esri.Graphic(geometry, sym6, {
                    id: id
                }));
            }
            break;
        case"amkn_blog_posts":
            dataLayer.add(new esri.Graphic(geometry, sym4, {
                id: id
            }));
            if (init) {
                dataLayerBp.add(new esri.Graphic(geometry, sym4, {
                    id: id
                }));
            }
            break;
        case"biodiv_cases":
            dataLayer.add(new esri.Graphic(geometry, sym7, {
                id: id
            }));
            if (init) {
                dataLayerBc.add(new esri.Graphic(geometry, sym7, {
                    id: id
                }));
            }
            break;
        case"photo_testimonials":
            dataLayer.add(new esri.Graphic(geometry, sym5, {
                id: id
            }));
            if (init) {
                dataLayerPt.add(new esri.Graphic(geometry, sym5, {
                    id: id
                }));
            }
            break;
        case"ccafs_activities":
            dataLayer.add(new esri.Graphic(geometry, symA, {
                id: id
            }));
            if (init) {
                dataLayerCa.add(new esri.Graphic(geometry, symA, {
                    id: id
                }));
            }
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
    var defLabelField = defaultFields[0], defLatField = defaultFields[1], defLongField = defaultFields[2], defTypeField = defaultFields[3], defcIDField = defaultFields[4];
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
    return[labelField || defLabelField, latField || defLatField, longField || defLongField, typeField || defTypeField, cIDField || defcIDField];
}
function setPopupContent(id) {
    csvStore.fetchItemByIdentity({
        identity: id,
        onItem: function(item) {
            var attributes = csvStore.getAttributes(item), data = {};

            dojo.forEach(attributes, function(attr) {
                data[attr] = csvStore.getValue(item, attr);
            });
            cType = esri.substitute(data, titleTemplate);
            dijit.byId("popContent").attr("content", esri.substitute(data, defaultInfoTemplate));
            dijit.byId("popContent").attr("title", getPopupTitle(esri.substitute(data, titleTemplate)));
            dojo.removeClass(document.getElementById("showContent"), "navigating");
            (dijit.byId("popContent").open) == true ? "" : dijit.byId("popContent").toggle();
            dojo.connect(dijit.byId("popContent"), "onHide", function() {
                dojo.addClass(document.getElementById("showContent"), "navigating");
                document.getElementById('ifrm').src = "about:blank";
                map.graphics.remove(highlightGraphic);
            });
        }
    });
}

/**
 * @function getListingContent
 * @description This method create the list item  to be show on the modal window that show the source near to the point selected
 * @argument {int} id it is the reference of a item on the map
 * @return {string} The list item to be show on the modal window 
 **/
function getListingContent(id) {
    var rt, ttl;
    csvStore.fetchItemByIdentity({
        identity: id,
        onItem: function(item) {
            var attributes = csvStore.getAttributes(item), data = {};

            dojo.forEach(attributes, function(attr) {
                data[attr] = csvStore.getValue(item, attr);
                ttl = attr;
            });
            ttl = csvStore.getValue(item, "Location");
            rt = esri.substitute(data, titleTemplate);
            cid = csvStore.getValue(item, "CID");
        }
    });
    //(0='title',1='contactName',2='theme')
    if (rt == "ccafs_activities") {
        ttl = ttl.split('|');
        ttl = "<b>Title: </b>" + ttl[0] + "<br><b>Contact: </b>" + ttl[1].replace(/#/gi, ", ") + "<br><b>Topic: </b>" + topics[ttl[2]];
    } else if (rt == "ccafs_sites") {
        ttl = ttl.split('|');
        ttl = "<b>Title: </b>" + ttl[0] + "<br><b>Site Id: </b>" + ttl[1] + "<br><b>Country: </b>" + ttl[2];
    } else if (rt == "biodiv_cases") {
        ttl = ttl.split('|');
        ttl = ttl[0];
    } else {
        ttl = ttl.split('|');
        ttl = "" + ttl[0] + "<br><span style='color:gray'><small>Published " + ttl[1] + "</small></span>";
    }
//    mapPTS=rt=="video_testimonials"?vtonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+",\'p="+cid+"\')' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png?ver=2' />&nbsp;"+ttl+"</li>"):"";
//    mapPTS=rt=="ccafs_sites"?cconmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' >"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png?ver=2' />&nbsp;<a class='link-ccafs-sites' href='./?p="+cid+"'>"+ttl+"</a></li>"):"";//without popup
//    mapPTS=rt=="amkn_blog_posts"?bgonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png?ver=2' />&nbsp;"+ttl+"</li>"):"";
//    mapPTS=rt=="biodiv_cases"?bdonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png?ver=2' />&nbsp;"+ttl+"</li>"):"";
//    mapPTS=rt=="photo_testimonials"?ptonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png?ver=2' />&nbsp;"+ttl+"</li>"):"";
//    maganaPpTS=rt=="ccafs_activities"?actnmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+",\'p="+cid+"\')' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png?ver=2' />&nbsp;"+ttl+"</li>"):"";
    if (location.search == '') {
//      if (rt=="ccafs_activities") {
        if (tempcid !== cid) {
//          tempcid = cid;
            countCid = 1;
        }
        else
            countCid++;
        tempcid = cid;
//        return"<li style='cursor:pointer;' onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+")'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png?ver=2' />&nbsp;"+countCid+'. '+ttl+"</li>";
//      } else {
        return"<li style='cursor:pointer;' onMouseOut='onFeatureLeave()' onMouseOver='onListHover(" + id + ")' onclick='document.location = \"./?p=" + cid + "\"'>" + "<img class='titleImg' src='./wp-content/themes/amkn_theme/images/" + rt + "-mini.png?ver=2' />&nbsp;" + ttl + "</li>";
//      }
    } else {
        str = location.search.split('&');
        parameterOne = str[1].split('=');
        parameterTwo = str[2].split('=');
        document.getElementById("showContent").style.top = "0px";
        document.getElementById("showContent").style.width = (parameterOne[1] - 50) + "px";
        document.getElementById("showContent").style.height = (parameterTwo[1] - 50) + "px";
//      document.getElementById("ifrm").style.width = (parameterOne[1]-50)+"px";
//      document.getElementById("ifrm").style.minHeight = (parameterTwo[1]-50)+"px";      
        return"<li style='cursor:pointer;' onMouseOut='onFeatureLeave()' onMouseOver='onListHover(" + id + ")' onclick='window.open(\"./?p=" + cid + "\",\"_blank\",\"scrollbars=yes, resizable=yes, top=60, left=60, width=700, height=630\");'>" + "<img class='titleImg' src='./wp-content/themes/amkn_theme/images/" + rt + "-mini.png?ver=2' />&nbsp;" + ttl + "</li>";
    }
}
function getPopupTitle(type) {
    switch (type) {
        case"video_testimonials":
            cHType = symh2;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/" + type + "-mini.png?ver=2' />&nbsp;Video";
            break;
        case"ccafs_sites":
            cHType = symh6;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/" + type + "-mini.png?ver=2' />&nbsp;Site";
            break;
        case"amkn_blog_posts":
            cHType = symh4;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/" + type + "-mini.png?ver=2' />&nbsp;Blog Post";
            break;
        case"biodiv_cases":
            cHType = symhX;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/" + type + "-mini.png?ver=2' />&nbsp;Agrobiodiversity Cases";
            break;
        case"photo_testimonials":
            cHType = symh5;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/" + type + "-mini.png?ver=2' />&nbsp;Photo Set";
            break;
        case"ccafs_activities":
            cHType = symhA;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/" + type + "-mini.png?ver=2' />&nbsp;Research Projects";
            break;
        default:
            cHType = highlightSymbol;
            return"Content Preview";
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
    var resizeTimer;
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        map.resize();
        map.reposition();
    }, 500);
}
function rLegend() {
    (typeof legend == "undefined") ? "" : legend.refresh();
}
function addGCPLayers()
{
}
function updateLegend()
{
    rLegend();
}
function showHideGCP() {
}

/**
 * @function updateDataLayerTree
 * @description this method show or hidde the different kind of content on the map
 * @argument {boolean} cb it is the reference of a item on the map
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
 **/
function updateDataLayerTree(cb)
{
    var points = $("#cFiltersList2").dynatree("getTree").getSelectedNodes();
    var showpts = "";
    var showimp = "";
    var showas = "";
    var showms = "";
    var showcl = "";
    var showccc = "";
    var showaz = "";
    for (var i = 0; i < points.length; i++) {
        if (points[i].data.key.match('accord_')) {
            showpts += points[i].data.key.replace('accord_', '') + ",";
        } else if (points[i].data.key.match('taxio_')) {
            switch (points[i].getParent().data.key) {
                case"impacts":
                    showimp += points[i].data.key.replace('taxio_', '') + ",";
                    break;
                case"adaptation_strategy":
                    showas += points[i].data.key.replace('taxio_', '') + ",";
                    break;
                case"mitigation_strategy":
                    showms += points[i].data.key.replace('taxio_', '') + ",";
                    break;
                case"climate_change_challenges":
                    showccc += points[i].data.key.replace('taxio_', '') + ",";
                    break;
            }
        }
    }
    showpts = showpts === "" ? "" : "&pts=" + showpts;

    //this vars provably will be use when the method be complet
    showimp = showimp === "" ? "" : "&imp=" + showimp;
    showas = showas === "" ? "" : "&as=" + showas;
    showms = showms == "" ? "" : "&ms=" + showms;
    showccc = showccc === "" ? "" : "&ccc=" + showccc;

    var newURL = baseDataURL + "?fmt=csv" + showpts + showimp + showas + showms + showcl + showccc + showaz;
    if (cb) {
        dataLayer.clear();
        dataLayerVt.clear();
        dataLayerCs.clear();
        dataLayerBp.clear();
        dataLayerBc.clear();
        dataLayerPt.clear();
        dataLayerCa.clear();
        processCsvData(newURL);
        setViewTree();
    }
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

    for (var i = 0; i < pts.length; i++) {
        if (pts.elements[i].checked)

        {
            showpts += pts.elements[i].value + ",";
            hasPts = true;
        }
    }

    for (var i = 0; i < imp.length; i++)
    {
        if (imp.elements[i].checked)

        {
            showimp += imp.elements[i].value + ",";
        }
    }
    for (var i = 0; i < as.length; i++)
    {
        if (as.elements[i].checked)

        {
            showas += as.elements[i].value + ",";
        }
    }
    for (var i = 0; i < ms.length; i++)
    {
        if (ms.elements[i].checked)

        {
            showms += ms.elements[i].value + ",";
        }
    }
    for (var i = 0; i < ccc.length; i++)
    {
        if (ccc.elements[i].checked)

        {
            showccc += ccc.elements[i].value + ",";
        }
    }
    showpts = showpts == "" ? "" : "&pts=" + showpts;
    showimp = showimp == "" ? "" : "&imp=" + showimp;
    showas = showas == "" ? "" : "&as=" + showas;
    showms = showms == "" ? "" : "&ms=" + showms;
    showcl = showcl == "" ? "" : "&cl=" + showcl;
    showccc = showccc == "" ? "" : "&ccc=" + showccc;
    showaz = showaz == "" ? "" : "&az=" + showaz;
    hasThemes = showimp + showas + showms + showcl + showccc + showaz;
    hasRes = hasThemes + hasPts;
    hasRes = hasRes == "" ? dojo.removeClass(document.getElementById("rsType_label"), "sldMenu") : dojo.addClass(document.getElementById("rsType_label"), "sldMenu");
    hlimp = showimp == "" ? dojo.removeClass(document.getElementById("d_impacts"), "sldMenu") : dojo.addClass(document.getElementById("d_impacts"), "sldMenu");
    hlas = showas == "" ? dojo.removeClass(document.getElementById("d_adaptation_strategy"), "sldMenu") : dojo.addClass(document.getElementById("d_adaptation_strategy"), "sldMenu");
    hlms = showms == "" ? dojo.removeClass(document.getElementById("d_mitigation_strategy"), "sldMenu") : dojo.addClass(document.getElementById("d_mitigation_strategy"), "sldMenu");
    hlccc = showccc == "" ? dojo.removeClass(document.getElementById("d_climate_change_challenges"), "sldMenu") : dojo.addClass(document.getElementById("d_climate_change_challenges"), "sldMenu");
    var newURL = baseDataURL + "?fmt=csv" + showpts + showimp + showas + showms + showcl + showccc + showaz;
    if (cb)
    {
        map.removeLayer(dataLayer);
        dataLayer = "";
        dataLayer = new esri.layers.GraphicsLayer();
        map.addLayer(dataLayer);
        disableFormsOnQuery();
    }
    processCsvData(newURL);
    if (cb)
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
    for (var i = 0; i < pts.length; i++)

    {
        pts.elements[i].disabled = "true";
    }
    for (var i = 0; i < imp.length; i++)
    {
        imp.elements[i].disabled = "true";
    }
    for (var i = 0; i < as.length; i++)
    {
        as.elements[i].disabled = "true";
    }
    for (var i = 0; i < ms.length; i++)
    {
        ms.elements[i].disabled = "true";
    }
    for (var i = 0; i < ccc.length; i++)
    {
        ccc.elements[i].disabled = "true";
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
    for (var i = 0; i < pts.length; i++)

    {
        pts.elements[i].disabled = "";
    }
    for (var i = 0; i < imp.length; i++)
    {
        imp.elements[i].disabled = "";
    }
    for (var i = 0; i < as.length; i++)
    {
        as.elements[i].disabled = "";
    }
    for (var i = 0; i < ms.length; i++)
    {
        ms.elements[i].disabled = "";
    }
    for (var i = 0; i < ccc.length; i++)
    {
        ccc.elements[i].disabled = "";
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
    clearAllChecks(ccc);
}
function clearAllChecks(formN) {
    for (var i = 0; i < formN.length; i++)

    {
        formN.elements[i].checked = "";
    }
    updateDataLayer(true);
}
function markAllChecks(formN) {
    for (var i = 0; i < formN.length; i++)

    {
        formN.elements[i].checked = "checked";
    }
    updateDataLayer(true);
}
function unChecks(formN) {
    for (var i = 0; i < formN.length; i++)

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
    for (var i = 0; i < pts.length; i++)

    {
        if (pts.elements[i].checked)

        {
            showpts += pts.elements[i].value + ",";
        }
    }
    for (var i = 0; i < imp.length; i++)
    {
        if (imp.elements[i].checked)

        {
            showimp += imp.elements[i].value + ",";
        }
    }
    for (var i = 0; i < as.length; i++)
    {
        if (as.elements[i].checked)

        {
            showas += as.elements[i].value + ",";
        }
    }
    for (var i = 0; i < ms.length; i++)
    {
        if (ms.elements[i].checked)

        {
            showms += ms.elements[i].value + ",";
        }
    }
    for (var i = 0; i < ccc.length; i++)
    {
        if (ccc.elements[i].checked)

        {
            showccc += ccc.elements[i].value + ",";
        }
    }
    showpts = showpts == "" ? "" : "/pts=" + showpts;
    showimp = showimp == "" ? "" : "/imp=" + showimp;
    showas = showas == "" ? "" : "/as=" + showas;
    showms = showms == "" ? "" : "/ms=" + showms;
    showcl = showcl == "" ? "" : "/cl=" + showcl;
    showccc = showccc == "" ? "" : "/ccc=" + showccc;
    showLyr = ((typeof vLyr == "undefined") || vLyr == "") ? "" : "/lyr=" + vLyr;
    ((typeof vLyr != "undefined") && vLyr != "") ? dojo.addClass(document.getElementById("rsLayers_label"), "sldMenu") : dojo.removeClass(document.getElementById("rsLayers_label"), "sldMenu");
    mapCenter = "/ctr=" + map.extent.getCenter().x + ";" + map.extent.getCenter().y;
    mapLevel = "/lvl=" + map.getLevel();
    var setBaseMP = "/bm=" + baseMP;
    var showGCP = "";
    location.hash = setBaseMP + showGCP + mapCenter + mapLevel + showpts + showimp + showas + showms + showcl + showccc + showaz + showLyr;
}

/**
 * @function setViewTree
 * @description this method update the url
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
 **/
function setViewTree()
{
    var points = $("#cFiltersList2").dynatree("getTree").getSelectedNodes();
    var pointsLyr = $("#dataLayers").dynatree("getTree").getSelectedNodes();
    var showpts = "";
    var showimp = "";
    var showas = "";
    var showms = "";
    var showccc = "";
    var showLyr = "";
    for (var i = 0; i < points.length; i++) {
        if (points[i].data.key.match('accord_')) {
            showpts += points[i].data.key.replace('accord_', '') + ",";
        } else if (points[i].data.key.match('taxio_')) {
            switch (points[i].getParent().data.key) {
                case"impacts":
                    showimp += points[i].data.key.replace('taxio_', '') + ",";
                    break;
                case"adaptation_strategy":
                    showas += points[i].data.key.replace('taxio_', '') + ",";
                    break;
                case"mitigation_strategy":
                    showms += points[i].data.key.replace('taxio_', '') + ",";
                    break;
                case"climate_change_challenges":
                    showccc += points[i].data.key.replace('taxio_', '') + ",";
                    break;
            }
        }
    }

    for (var i = 0; i < pointsLyr.length; i++) {
//    if (pointsLyr[i].data.key.match('aglyr') && pointsLyr[i].data.key.match('|')) {
        showLyr += pointsLyr[i].data.key + ",";
//    }
    }
    showpts = showpts === "" ? "" : "/pts=" + showpts;
    showimp = showimp === "" ? "" : "/imp=" + showimp;
    showas = showas === "" ? "" : "/as=" + showas;
    showms = showms === "" ? "" : "/ms=" + showms;
    showccc = showccc === "" ? "" : "/ccc=" + showccc;
    showLyr = showLyr === "" ? "" : "/lyr=" + showLyr;
//  showLyr=((typeof vLyr=="undefined")||vLyr=="")?"":"/lyr="+vLyr;
    mapCenter = "/ctr=" + map.extent.getCenter().x + ";" + map.extent.getCenter().y;
    mapLevel = "/lvl=" + map.getLevel();
    var setBaseMP = "/bm=" + baseMP;
    var showGCP = "";
    location.hash = setBaseMP + showGCP + mapCenter + mapLevel + showpts + showimp + showas + showms + showccc + showLyr;
}
function getView()
{
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
    if (location.hash)

    {
        location.hash = unescape(location.hash);
        var theMap = unescape(location.hash).split("/");
        if (theMap != "")

        {
            unChecks(document.pts);
            for (var mp = 0; mp < theMap.length; mp++)

            {
                var cEle = theMap[mp].split("=")[0];
                switch (cEle) {
                    case"pts":
                        checkTypeElements(theMap[mp].split("=")[1]);
                        break;
                    case"imp":
                        checkTaxElements("impacts", theMap[mp].split("=")[1]);
                        break;
                    case"as":
                        checkTaxElements("adaptation_strategy", theMap[mp].split("=")[1]);
                        break;
                    case"ms":
                        checkTaxElements("mitigation_strategy", theMap[mp].split("=")[1]);
                        break;
                    case"cl":
                        checkTaxElements("crops_livestock", theMap[mp].split("=")[1]);
                        break;
                    case"ccc":
                        checkTaxElements("climate_change_challenges", theMap[mp].split("=")[1]);
                        break;
                    case"az":
                        checkTaxElements("agroecological_zones", theMap[mp].split("=")[1]);
                        break;
                    case"ctr":
                        ctrPt = theMap[mp].split("=")[1];
                        break;
                    case"cntr":
                        cntr = theMap[mp].split("=")[1];
                        var ctPT = new esri.geometry.Point(parseFloat(cntr.split(";")[1]), parseFloat(cntr.split(";")[0]));
                        ctPT = esri.geometry.geographicToWebMercator(ctPT);
                        ctrPt = ctPT.x + ";" + ctPT.y;

                        break;
                    case"idCT":
                        idCT = theMap[mp].split("=")[1];
                        break;
                    case"lvl":
                        lvlMp = theMap[mp].split("=")[1];
                        break;
                    case"lyr":
                        vLyr = theMap[mp].split("=")[1];
                        break;
                    case"ext":
                        break;
                    case"gcp":
                        if (theMap[mp].split("=")[1] == "t") {
                            sGCP = theMap[mp].split("=")[1];
                            document.getElementById("gcpFS").checked = "checked";
                        } else {
                            document.getElementById("gcpFS").checked = "";
                        }

                        break;
                    case"bm":
                        baseMP = theMap[mp].split("=")[1];
                        break;
                    default:
                        break;
                }
            }
        }
    }
}

function getViewTree()
{
    var initPts = true;
    if (location.hash) {
        location.hash = unescape(location.hash);
        var theMap = unescape(location.hash).split("/");
        if (theMap != "") {
            for (var mp = 0; mp < theMap.length; mp++) {
                var cEle = theMap[mp].split("=")[0];
                switch (cEle) {
                    case"pts":
                        checkTypeElements(theMap[mp].split("=")[1]);
                        initPts = false;
                        break;
                    case"imp":
                        checkTaxElements(theMap[mp].split("=")[1]);
                        break;
                    case"as":
                        checkTaxElements(theMap[mp].split("=")[1]);
                        break;
                    case"ms":
                        checkTaxElements(theMap[mp].split("=")[1]);
                        break;
                    case"cl":
                        checkTaxElements(theMap[mp].split("=")[1]);
                        break;
                    case"ccc":
                        checkTaxElements(theMap[mp].split("=")[1]);
                        break;
                    case"ctr":
                        ctrPt = theMap[mp].split("=")[1];
                        break;
                    case"cntr":
                        cntr = theMap[mp].split("=")[1];
                        var ctPT = new esri.geometry.Point(parseFloat(cntr.split(";")[1]), parseFloat(cntr.split(";")[0]));
                        ctPT = esri.geometry.geographicToWebMercator(ctPT);
                        ctrPt = ctPT.x + ";" + ctPT.y;
                        break;
                    case"idCT":
//            idCT=theMap[mp].split("=")[1];
                        break;
                    case"lvl":
                        lvlMp = theMap[mp].split("=")[1];
                        break;
                    case"lyr":
                        vLyr = theMap[mp].split("=")[1];
                        break;
                    case"gcp":
//            if(theMap[mp].split("=")[1]=="t"){
//              sGCP=theMap[mp].split("=")[1];
//    //                                document.getElementById("gcpFS").checked="checked";
//            }else{
//    //                                document.getElementById("gcpFS").checked="";
//            }
                        break;
                    case"bm":
                        baseMP = theMap[mp].split("=")[1];
                        break;
                    default:
                        break;
                }
            }
        }
    }
    if (initPts) {
        $("#cFiltersList2").dynatree("getRoot").visit(function(node) {
            node.select(true);
        });
    }

    firstime = true;
}

function initBackMap()
{
    var move;
    if (ctrPt && lvlMp) {
        move = new esri.geometry.Point([parseFloat(ctrPt.split(";")[0]), parseFloat(ctrPt.split(";")[1])], new esri.SpatialReference({wkid: 102100}));
        map.centerAndZoom(move, parseFloat(lvlMp));
    }
    ctrPt = "";
    lvlMp = "";
    var newURLs = baseDataURL + "?fmt=csv&pts=ccafs_activities,ccafs_sites,biodiv_cases,amkn_blog_posts,photo_testimonials,video_testimonials,";
//    processCsvData(newURLs,true);

    updateDataLayerTree(true);
}
function go2Region(pt, zm, rg)
{
    move2 = new esri.geometry.Point([parseFloat(pt.split(";")[0]), parseFloat(pt.split(";")[1])], new esri.SpatialReference({
        wkid: 102100
    }));
    map.centerAndZoom(move2, parseFloat(zm));
    highlightRegions(rg);
//    map.centerAt(map.extent.getCenter());
}
function checkTaxElements(elements) {
    var chkElements = elements.split(",");
    for (var i = 0; i < chkElements.length; i++) {
        if (chkElements[i] != "") {
            $("#cFiltersList2").dynatree("getTree").getNodeByKey("taxio_" + chkElements[i]).select(true);
            $("#cFiltersList2").dynatree("getTree").getNodeByKey("taxio_" + chkElements[i]).getParent().getParent().expand(true);
            $("#cFiltersList2").dynatree("getTree").getNodeByKey("taxio_" + chkElements[i]).getParent().expand(true);
        }
    }
}
function checkTypeElements(elements) {
    var chkElements = elements.split(",");
    for (var i = 0; i < chkElements.length; i++) {
        if (chkElements[i] != "") {
            $("#cFiltersList2").dynatree("getTree").getNodeByKey("accord_" + chkElements[i]).select(true);
        }
    }
}
function setBaseMap(bmId)
{
//    clearBaseSelection();
//    dojo.addClass("mapType"+bmId,"controls-selected");
    baseMP = bmId;
    basemapGallery.select(baseMP);
//    setViewTree();
}
function clearBaseSelection()
{
    dojo.removeClass("mapType1", "controls-selected");
    dojo.removeClass("mapType2", "controls-selected");
    dojo.removeClass("mapType3", "controls-selected");
}
function go2Loc(xMn, yMn, xMx, yMx) {
    var setExt = new esri.geometry.Extent({
        "xmin": xMn,
        "ymin": yMn,
        "xmax": xMx,
        "ymax": yMx,
        "spatialReference": {
            "wkid": 102100
        }
    });
    map.setExtent(setExt);
}
function createMapMenu() {
    ctxMenuForMap = new dijit.Menu({
        onOpen: function(box) {
            currentLocation = getMapPointFromMenuPosition(box);
        }
    });
    ctxMenuForMap.addChild(new dijit.MenuItem({
        label: "Center and zoom here",
        onClick: function(evt) {
            var centerPoint = new esri.geometry.Point(currentLocation.x, currentLocation.y, currentLocation.spatialReference);
            var tolvl = (map.getLevel() < 10) ? map.getLevel() + 1 : 10;
            map.centerAndZoom(centerPoint, tolvl);
        }
    }));
    ctxMenuForMap.startup();
    ctxMenuForMap.bindDomNode(map.container);
}
function zoomToCtxt() {
    var tolvl = (map.getLevel() < 10) ? map.getLevel() + 1 : 10;
    map.centerAndZoom(cPx, tolvl);
}
function zoomToOExt() {
    var tExt = new esri.geometry.Extent({
        "xmin": intMinExtX,
        "ymin": intMinExtY,
        "xmax": intMaxExtX,
        "ymax": intMaxExtY,
        "spatialReference": {
            "wkid": 102100
        }
    });
    map.setExtent(tExt);
    if (typeof featureRegion != "undefined")
        featureRegion.hide();

}
function getMapPointFromMenuPosition(box) {
    var x = box.x, y = box.y;
    switch (box.corner) {
        case"TR":
            x += box.w;
            break;
        case"BL":
            y += box.h;
            break;
        case"BR":
            x += box.w;
            y += box.h;
            break;
    }
    var screenPoint = new esri.geometry.Point(x - map.position.x, y - map.position.y);
    return map.toMap(screenPoint);
}

/**
 * @function getListingContentTree
 * @description this method create the diferents objects to display in each item of the tree
 * @argument {int} id it is the reference of a item on the map
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
 **/
function getListingContentTree(id) {
    var rt, ttl, cid;
    csvStore.fetchItemByIdentity({
        identity: id,
        onItem: function(item) {
            var attributes = csvStore.getAttributes(item), data = {};

            dojo.forEach(attributes, function(attr) {
                data[attr] = csvStore.getValue(item, attr);
                ttl = attr;
            });
            ttl = csvStore.getValue(item, "Location");
            cid = csvStore.getValue(item, "CID");
            rt = esri.substitute(data, titleTemplate);
        }
    });
    if (tempCid != cid) {
        countCid = 1;
        if (rt === "ccafs_sites") {
            ttl = ttl.split('|');
            title = "<b>Title: </b>" + ttl[0] + "<br><b>Site Id: </b>" + ttl[1] + "<br><b>Country: </b>" + ttl[2];
            cconmap.push({
                title: title,
                key: id,
                url: './?p=' + cid,
                hideCheckbox: true,
                unselectable: true,
                select: false,
                icon: '../../../../images/ccafs_sites-mini.png?ver=2'
            });
        }
        if (rt === "video_testimonials") {
            ttl = ttl.split('|');
            vtonmap.push({
                title: "" + ttl[0] + "<br><span style='color:gray'><small>Published " + ttl[1] + "</small></span>",
                tooltip: "Title: " + ttl[0],
                key: id,
                url: './?p=' + cid,
                hideCheckbox: true,
                unselectable: true,
                select: false,
                icon: '../../../../images/video_testimonials-mini.png?ver=2'
                        //isLazy: true
            });
        }
        if (rt === "amkn_blog_posts") {
            ttl = ttl.split('|');
            bgonmap.push({
                title: "" + ttl[0] + "<br><span style='color:gray'><small>Published " + ttl[1] + "</small></span>",
                tooltip: "Title: " + ttl[0],
                key: id,
                url: './?p=' + cid,
                hideCheckbox: true,
                unselectable: true,
                select: false,
                icon: '../../../../images/amkn_blog_posts-mini.png?ver=2'
                        //isLazy: true
            });
        }
        if (rt === "biodiv_cases") {
            ttl = ttl.split('|');
            bdonmap.push({
                title: ttl[0],
                tooltip: ttl[0],
                key: id,
                url: './?p=' + cid,
                hideCheckbox: true,
                unselectable: true,
                select: false,
                icon: '../../../../images/biodiv_cases-mini.png?ver=2'
                        //isLazy: true
            });
        }
        if (rt === "photo_testimonials") {
            ttl = ttl.split('|');
            ptonmap.push({
                title: "" + ttl[0] + "<br><span style='color:gray'><small>Published " + ttl[1] + "</small></span>",
                tooltip: "Title: " + ttl[0],
                key: id,
                url: './?p=' + cid,
                hideCheckbox: true,
                unselectable: true,
                select: false,
                icon: '../../../../images/photo_testimonials-mini.png?ver=2'
                        //isLazy: true
            });
        }
        if (rt === "ccafs_activities") {
            //(0='title',1='contactName',2='theme')
            ttl = ttl.split('|');
            title = "<b>Title:</b>" + ttl[0] + "<br><b>Contact:</b>" + ttl[1].replace(/#/gi, ",") + "<br><b>Topic:</b>" + topics[ttl[2]];
            mapPTS = actnmap.push({
                title: title,
                tooltip: ttl[0],
                key: id,
                url: './?p=' + cid,
                hideCheckbox: true,
                unselectable: true,
                select: false,
                icon: '../../../../images/ccafs_activities-mini.png?ver=2'
                        //isLazy: true
            });
        }
    } else {
        countCid++;
    }
    if (!oactnmap[cid])
        oactnmap[cid] = [];
    oactnmap[cid].push({
        key: id,
    });
    tempCid = cid;
    return;
}

/**
 * @function findPointsInExtentTree
 * @description this method update the left panel, updates the number of children of each item on the tree
 * @argument {esri.Map} extent containt the map's settings
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
 **/
function findPointsInExtentTree(extent) {
    var results = [];
    vtonmap = [];
    cconmap = [];
    bgonmap = [];
    bdonmap = [];
    ptonmap = [];
    actnmap = [];
    oactnmap = {};
    tempCid = 0;
    countCid = 0;
    progressbar = $("#progressbar");
    tmptotal = 0;
    totalGraphs = dataLayer.graphics.length;
    var totalNum = 0;
    dojo.forEach(dataLayer.graphics, function(graphic) {
        if (extent.contains(graphic.geometry)) {
            results.push(getListingContentTree(graphic.attributes.id));
        }
    });
    var onthemap = dijit.byId('onthemap');
    if (dojo.byId('geop').checked) {
        onthemap.attr("title", "What&#39;s on the map (" + Object.keys(oactnmap).length + ")");
        totalSources['gp'] = results.length;
    } else {
        onthemap.attr("title", "What&#39;s on the map (" + totalSources['reg'] + ")");
    }
    var rootNode = $("#cFiltersList2").dynatree("getRoot");
    var childrenNodes = rootNode.getChildren();

    for (i = 0; i < childrenNodes.length; i++) {
        // clean array.
        if (childrenNodes[i].data.key !== 'accord_data_layer' && childrenNodes[i].data.key !== 'accord_filter_resource_theme') {
            childrenNodes[i].removeChildren();
        }
        // add children and update the number of records on it.
        if (totalSources[childrenNodes[i].data.key.replace('accord_', '')]) {
            totalNum = Object.keys(totalSources[childrenNodes[i].data.key.replace('accord_', '')]).length;
        } else {
            totalNum = 0;
        }

        switch (childrenNodes[i].data.key) {
            case 'accord_ccafs_sites':
                childrenNodes[i].addChild(cconmap);
                childrenNodes[i].data.title = "Research Sites (" + cconmap.length + "/" + postTotal[childrenNodes[i].data.key.replace('accord_', '')] + ")";
                childrenNodes[i].render();
                break;
            case 'accord_video_testimonials':
                childrenNodes[i].addChild(vtonmap);
                childrenNodes[i].data.title = "Videos (" + vtonmap.length + "/" + postTotal[childrenNodes[i].data.key.replace('accord_', '')] + ")";
                childrenNodes[i].render();
                break;
            case 'accord_amkn_blog_posts':
                childrenNodes[i].addChild(bgonmap);
                childrenNodes[i].data.title = "Blog Posts (" + bgonmap.length + "/" + postTotal[childrenNodes[i].data.key.replace('accord_', '')] + ")";
                childrenNodes[i].render();
                break;
            case 'accord_biodiv_cases':
                childrenNodes[i].addChild(bdonmap);
                childrenNodes[i].data.title = "Agrobiodiversity Cases (" + bdonmap.length + "/" + postTotal[childrenNodes[i].data.key.replace('accord_', '')] + ")";
                childrenNodes[i].render();
                break;
            case 'accord_photo_testimonials':
                childrenNodes[i].addChild(ptonmap);
                childrenNodes[i].data.title = "Photo Sets (" + ptonmap.length + "/" + postTotal[childrenNodes[i].data.key.replace('accord_', '')] + ")";
                childrenNodes[i].render();
                break;
            case 'accord_ccafs_activities':
                childrenNodes[i].addChild(actnmap);
                childrenNodes[i].data.title = "Research Projects (" + actnmap.length + "/" + postTotal[childrenNodes[i].data.key.replace('accord_', '')] + ")";
                childrenNodes[i].render();
                break;
        }
    }
}

/**
 * @function createDataLayersBranch
 * @description this method create the tree's branch Data Layer on the left panel
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
 **/
function createDataLayersBranch() {
    var nodeDataLayer = $("#dataLayers").dynatree("getTree").getNodeByKey("accord_data_layer");
    var ly = '';
    var children = nodeDataLayer.getChildren();
    var totalLayers = 0;
    for (j = 0; j < children.length; j++) {
        soon = children[j];
        ly = soon.data.key.split("-");
        layer = new esri.layers.ArcGISDynamicMapServiceLayer(ly[2]);
        layer.id = ly[0];
        totalLayers += buildLayerListTree(layer, ly[0], ly[1], soon);
    }
    nodeDataLayer.expand(true);
}

function findPointsInExtent(extent) {
    var results = [];
    vtonmap = [];
    cconmap = [];
    bgonmap = [];
    bdonmap = [];
    ptonmap = [];
    dojo.forEach(dataLayer.graphics, function(graphic) {
        if (extent.contains(graphic.geometry)) {
            results.push(getListingContent(graphic.attributes.id));
        }
    });
    var onthemap = dijit.byId('onthemap');
    onthemap.attr("title", "What&#39;s on the map (" + results.length + ")");
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
    ccTx.attr("title", "Sites (" + cconmap.length + ")");
    vtTx.attr("title", "Videos (" + vtonmap.length + ")");
    bpTx.attr("title", "Blog Posts (" + bgonmap.length + ")");
    bcTx.attr("title", "Agrobiodiversity Cases (" + bdonmap.length + ")");
    ptTx.attr("title", "Photo Sets (" + ptonmap.length + ")");
}
function setTrans(value) {
    var cL = map.getLayer(visLyr);
    if (cL != null)
    {
        cL.setOpacity(value);
    }
}
function findPointsInPolygon(extent, evt) {
    var results = [];
    tempcid = 0;
    dojo.forEach(dataLayer.graphics, function(graphic) {
        if (extent.contains(graphic.geometry)) {
            results.push(getListingContent(graphic.attributes.id));
        }
    });
    cPx = new esri.geometry.Point(map.toMap(evt.screenPoint).x, map.toMap(evt.screenPoint).y, map.spatialReference);
    var ttContent = "<span class='blockNoWrap'>At this location (" + results.length + ") <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='zoomToCtxt();'><a>Zoom here</a></button> <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='cPop();'><a>Close</a></button></span>";
    ttContent += "<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + results.join("") + "<ul></tr></td></tbody></table>";
    hQuery.setContent(ttContent);
    dojo.style(hQuery.domNode, "opacity", 1);
    dijit.popup.open({
        popup: hQuery,
        x: evt.pageX,
        y: evt.pageY
    });
}
function getItemsAtLocation(sPtX, sPtY, evt)
{
    var sPt1 = new esri.geometry.Point(sPtX - 20, sPtY + 20);
    var sPt2 = new esri.geometry.Point(sPtX + 20, sPtY + 20);
    var sPt3 = new esri.geometry.Point(sPtX + 20, sPtY - 20);
    var sPt4 = new esri.geometry.Point(sPtX - 20, sPtY - 20);
//    hoverLayer=new esri.layers.GraphicsLayer();    
//    hoverLayer.remove(polyGraphic);
    hoverLayer.clear();
    points = [map.toMap(sPt1), map.toMap(sPt2), map.toMap(sPt3), map.toMap(sPt4), map.toMap(sPt1)];
    var polygon = new esri.geometry.Polygon();
    polygon.addRing(points);
    polygon.spatialReference = new esri.SpatialReference({
        wkid: 102100
    });
    var gs = new esri.symbol.SimpleFillSymbol().setStyle(esri.symbol.SimpleFillSymbol.STYLE_SOLID);
    polyGraphic = new esri.Graphic(polygon, gs);
    hoverLayer.add(polyGraphic);
//    dojo.connect(hoverLayer,"onClick",function(){
    hoverLayer.on("click", function(evts) {
        var results = [];
        tempcid = 0;
        countCid = 0;
        dojo.forEach(dataLayer.graphics, function(graphic) {
            if (polygon.getExtent().contains(graphic.geometry)) {
                results.push(getListingContent(graphic.attributes.id));
            }
        });
//      alert(results.length);
        cPx = new esri.geometry.Point(map.toMap(evt.screenPoint).x, map.toMap(evt.screenPoint).y, map.spatialReference);
        var ttContent = "<span class='blockNoWrap'>At this location (" + results.length + ") <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='zoomToCtxt();'><a>Zoom here</a></button> <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='cPop();'><a>Close</a></button></span>";
        ttContent += "<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>" + results.join("") + "<ul></tr></td></tbody></table>";
        hQuery.setContent(ttContent);
        dojo.style(hQuery.domNode, "opacity", 1);
        dijit.popup.open({
            popup: hQuery,
            x: evt.pageX,
            y: evt.pageY
        });
//      dojo.connect(hQuery,"onMouseOut",cPop);
    });
//    findPointsInPolygon(polygon.getExtent(),evt);
}
var addedLayers = [];

/**function in charge of paint the list of layers
 * @function buildLayerList
 * @deprecated buildLayerListTree() replace it**/
function buildLayerList(layer, lID, layerName, single) {
    addedLayers.push(layerName);
    layer.setVisibility(false);
    layer.setImageTransparency(true, false);
    var singleLyr = single == null ? -1 : single;
    var lyrH = "";
    var checked = "";
    var tmp = "";
    var items = dojo.map(layer.layerInfos, function(info, index) {
        checked = (((typeof vLyr != "undefined") && vLyr != "") && (vLyr.split("|")[0] == layerName) && (vLyr.split("|")[2] == info.id)) ? " checked=\"checked\"" : "";
        if (singleLyr == -1) {
            bf = info.parentLayerId == -1 ? "<li class='l1'>" : "<li class='l2'>";
            af = info.parentLayerId == -1 ? "</li>" : "</li>";
            if ((info.parentLayerId == -1 && info.subLayerIds == null) || (info.parentLayerId != -1 && info.subLayerIds == null)) {
                lyrH += bf + "<input" + checked + " name='aLayer' type='radio' class='list_item_" + lID + "' id='" + info.id + "' onclick='updateLayerVisibility(" + lID + ", \"" + layer.id + "\");' /><label for='" + info.id + "'>" + info.name + "</label>" + af;
            } else {
                lyrH += bf + "<b>" + info.name + "</b>" + af;
            }
        }
        else {
            if (info.id == singleLyr) {
                bf = info.parentLayerId == -1 ? "<li class='l1'>" : "<li class='l2'>";
                af = info.parentLayerId == -1 ? "</li>" : "</li>";
                lyrH += bf + "<input" + checked + " name='aLayer' type='radio' class='list_item_" + lID + "' id='" + info.id + "' onclick='updateLayerVisibility(" + lID + ", \"" + layer.id + "\");' /><label for='" + info.id + "'>" + info.name + "</label>" + af;
            }
        }
    });
    if (((typeof vLyr != "undefined") && vLyr != "") && fUd == false && vLyr.split("|")[0] == layerName) {
        fUd = true;
        visible = [];
        visible.push(vLyr.split("|")[2]);
        visLyr = layerName;
        layer.setVisibility(true);
        layer.setVisibleLayers(visible);
//        dijit.byId('cFiltersList').selectChild(dijit.byId('accord_legend'));
        dojo.addClass(document.getElementById("layerbt_" + layerName), "sldMenu");
        map.centerAt(map.extent.getCenter());
    }
    return"<ul class='homebox-list zoom_in-list'>" + tmp + lyrH + "</ul>";
}

/**function in charge of paint the list of layers
 * @argument {esri.layers} layer description
 * @argument {String} layerName Layer's name
 * @argument {object} soon it is an object of a tree's branch (child)
 * @argument {int} single description
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
 **/
function buildLayerListTree(layer, layerName, single, soon) {
    addedLayers.push(layerName);
    layer.setVisibility(false);
    layer.setImageTransparency(true, false);
    single = single == 'null' ? null : single;
    var singleLyr = single == null ? -1 : single;
    var child = [];
    var checked = false;
//    soon.data.hideCheckbox = false;
//    ly = soon.data.key.split("-");
    setTimeout(function() {
        for ($i = 0; $i < layer.layerInfos.length; $i++) {
            ly = soon.data.key.split("-");
//    dojo.map(layer.layerInfos,function(info){
            if (singleLyr == -1) {
                if ((ly[3] == 14 && layer.layerInfos[$i].id == 26) || (ly[3] == 14 && layer.layerInfos[$i].id == 25) || (ly[3] == 21 && layer.layerInfos[$i].id == 0)) {

                } else if ((layer.layerInfos[$i].parentLayerId == -1 && layer.layerInfos[$i].subLayerIds == null) || (layer.layerInfos[$i].parentLayerId != -1 && layer.layerInfos[$i].subLayerIds == null)) {
                    child.push({
                        title: layer.layerInfos[$i].name,
                        key: layer.id + '|' + ly[3] + '|' + layer.layerInfos[$i].id,
//                  url: './?p='+cid,
//                  hideCheckbox: true,
                        select: checked,
                        icon: '../../../../images/map_icon.png?ver=2'
                    });
                } else {
                    child.push({
                        title: "<h4>" + layer.layerInfos[$i].name + "</h4>",
//                  isFolder: true,
//                  key: layer.layerInfos[$i].id
                        icon: '../../../../images/data_layersM.png?ver=2',
                        hideCheckbox: true,
                        unselectable: true
//                  icon: '../../../../images/map_icon.png?ver=2'
                    });
                    //Here comes the title or header layer's group
                }
            } else {
                if (layer.layerInfos[$i].id == singleLyr) {
                    child.push({
                        title: layer.layerInfos[$i].name,
                        key: layer.id + '|' + ly[3] + '|' + layer.layerInfos[$i].id,
//                  url: './?p='+cid,
//                  hideCheckbox: true,
                        select: checked,
                        icon: '../../../../images/map_icon.png?ver=2'
                    });
                }
            }
            soon.removeChildren();
            soon.addChild(child);
            if (checked) {
                soon.getParent().expand(true);
                soon.expand(true);
            }
        }
        var vLyrArray = (typeof vLyr !== "undefined") ? vLyr.split(",") : new Array();
        for ($j = 0; $j < vLyrArray.length; $j++) {
            if ($("#dataLayers").dynatree("getTree").getNodeByKey(vLyrArray[$j]) != null) {
                $("#dataLayers").dynatree("getTree").getNodeByKey(vLyrArray[$j]).select(true);
                $("#dataLayers").dynatree("getTree").getNodeByKey(vLyrArray[$j]).getParent().expand(true);
                $("#dataLayers").dynatree("getTree").getNodeByKey(vLyrArray[$j]).getParent().getParent().expand(true);
            }
        }

        soon.data.title = soon.data.title + " (" + child.length + ")";
        if (child.length === 0)
            soon.data.hideCheckbox = true;
    }, 1000);

    if (((typeof vLyr != "undefined") && vLyr != "") && fUd == false && vLyr.split("|")[0] == layerName) {
        fUd = true;
        visible = [];
        visible.push(vLyr.split("|")[2]);
        visLyr = layerName;
        layer.setVisibility(true);
        layer.setVisibleLayers(visible);
        //dijit.byId('cFiltersList').selectChild(dijit.byId('accord_legend'));
        dojo.addClass(document.getElementById("layerbt_" + layerName), "sldMenu");
        map.centerAt(map.extent.getCenter());
    }
    return child.length;
}

/**function in charge of paint the list of layers
 * @argument {object} node it is item from the tree that was selected
 * @argument {boolean} flag indicates if the tree item is check or not
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
 **/
function updateLayerVisibilityTree(node, flag) {
    var ly = node.data.key.split("|");
    if (flag) {
        unselectCheck(node);
        unselectCheckParents(node);
    }
    lyrID = ly[0];
    lID = ly[1];
    if (map)
        var cLyr = map.getLayer(ly[0]);

    if (cLyr != null) {
        cLyr.setVisibility(false);
        dijit.byId('tslider').setValue(cLyr.opacity * 100);
    }
    visLyr = lyrID;
    vLyr = "";
    visible = [];
    visible.push(ly[2]);
    if (visible.length === 0) {
        visible.push(-1);
    }
    if (flag && cLyr != null) {
        (visible.length != -1) ? cLyr.setVisibility(true) : cLyr.setVisibility(false);
        (visible.length != -1) ? cLyr.setVisibleLayers(visible) : "";
    }
    var deltLyr;
    clearTimeout(deltLyr);
    deltLyr = setTimeout(function() {
        map.centerAt(map.extent.getCenter());
        rLegend();
        dijit.byId('layersDiv').selectChild(dijit.byId('accord_legend'));
    }, 1000);
}

function unselectCheck(node) {
    tmp = node.getNextSibling();
    while (tmp) {
        tmp.select(false);
        tmp = tmp.getNextSibling();
    }
    tmp = node.getPrevSibling();
    while (tmp) {
        tmp.select(false);
        tmp = tmp.getPrevSibling();
    }
}

function unselectCheckParents(node) {
    parent = node.getParent();
    tmp = parent.getNextSibling();
    while (tmp) {
        children = tmp.getChildren();
        if (children !== null) {
            for (var i = 0, l = children.length; i < l; i++) {
                children[i].select(false);
            }
        }
        tmp = tmp.getNextSibling();
    }
    tmp = parent.getPrevSibling();
    while (tmp) {
        children = tmp.getChildren();
        if (children !== null) {
            for (var i = 0, l = children.length; i < l; i++) {
                children[i].select(false);
            }
        }
        tmp = tmp.getPrevSibling();
    }
}

function updateLayerVisibility(lID, lyrID) {
    var inputs = dojo.query(".list_item_" + lID), input;
    var cLyr = map.getLayer(lyrID);
    cLyr.setVisibility(false);
    (typeof visLyr != "undefined") ? map.getLayer(visLyr).setVisibility(false) : "";
    (typeof visLyr != "undefined") ? dojo.removeClass(document.getElementById(visLyr + "_label"), "sldMenu") : "";
    (typeof visLyr != "undefined") ? dojo.removeClass(document.getElementById("layerbt_" + visLyr), "sldMenu") : "";
    if (cLyr != null)

    {
        dijit.byId('tslider').setValue(cLyr.opacity * 100);
    }
    visLyr = lyrID;
    vLyr = "";

    visible = [];
    dojo.forEach(inputs, function(input) {
        if (input.checked) {
            visible.push(input.id);
            vLyr = lyrID + "|" + lID + "|" + input.id;
        }
    });
    if (visible.length === 0) {
        visible.push(-1);
    }
    (visible.length != -1) ? cLyr.setVisibility(true) : cLyr.setVisibility(false);
    (lID != null) ? dojo.addClass(document.getElementById(lyrID + "_label"), "sldMenu") : dojo.removeClass(document.getElementById(lyrID + "_label"), "sldMenu");
    (visible.length != -1) ? cLyr.setVisibleLayers(visible) : "";
    var tpp = 0;
    for (var al = 0; al < addedLayers.length; al++)

    {
        if (dojo.hasClass(document.getElementById(addedLayers[al] + "_label"), "sldMenu")) {
            tpp++;
        }
    }
    (tpp > 0) ? dojo.addClass(document.getElementById("rsLayers_label"), "sldMenu") : dojo.removeClass(document.getElementById("rsLayers_label"), "sldMenu");
    var deltLyr;
    clearTimeout(deltLyr);
    deltLyr = setTimeout(function() {
        map.centerAt(map.extent.getCenter());
        rLegend();
    }, 1000);
    dojo.hasClass(document.getElementById("onthemap"), "dojoxExpandoClosed") ? dijit.byId('onthemap').toggle() : "";
//    dijit.byId('cFiltersList').selectChild(dijit.byId('accord_legend'));
}
function updateInitLyr(lID, lyrID, id) {
    var cLyr = map.getLayer(lyrID);
    cLyr.setVisibility(false);
    (typeof visLyr != "undefined") ? map.getLayer(visLyr).setVisibility(false) : "";
    (typeof visLyr != "undefined") ? dojo.removeClass(document.getElementById(visLyr + "_label"), "sldMenu") : "";
    visLyr = lyrID;
    vLyr = "";
    visible = [];
    visible.push(id);
    vLyr = lyrID + "|" + lID + "|" + id;
    (visible.length != -1) ? cLyr.setVisibility(true) : cLyr.setVisibility(false);
    (lID != null) ? dojo.addClass(document.getElementById(lyrID + "_label"), "sldMenu") : dojo.removeClass(document.getElementById(lyrID + "_label"), "sldMenu");
    (visible.length != -1) ? cLyr.setVisibleLayers(visible) : "";
    var tpp = 0;
    for (var al = 0; al < addedLayers.length; al++)

    {
        if (dojo.hasClass(document.getElementById(addedLayers[al] + "_label"), "sldMenu")) {
            tpp++;
        }
    }
    (tpp > 0) ? dojo.addClass(document.getElementById("rsLayers_label"), "sldMenu") : dojo.removeClass(document.getElementById("rsLayers_label"), "sldMenu");
    map.centerAt(map.extent.getCenter());
}

function validateSelect() {
    var checkedAll = true;
    $("#cFiltersList2").dynatree("getRoot").visit(function(node) {
        if (!node.data.url && node.data.key != 'accord_data_layers') {
            if (!node.isSelected())
                checkedAll = false;
        }
    });
    if (!checkedAll)
        $("#ckbSelectAll").prop('checked', false);
    else
        $("#ckbSelectAll").prop('checked', true);
}

/*
 * test function
 */
function showCoordinates(evt) {
    //the map is in web mercator but display coordinates in geographic (lat, long)
    var mp = esri.geometry.webMercatorToGeographic(evt.mapPoint);
    //display mouse coordinates
    console.log(mp.x.toFixed(3) + ", " + mp.y.toFixed(3));
}
var mp = {};

mp.lMap = function() {
    var lMapTimer;
    clearTimeout(lMapTimer);
    lMapTimer = setTimeout(function() {
        initMap();
    }, 500);
}
dojo.addOnLoad(function() {
    mp.lMap();
});
