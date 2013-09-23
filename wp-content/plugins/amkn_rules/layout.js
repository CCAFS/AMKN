dojo.require("esri.map");
dojo.require("dojox.data.CsvStore");
dojo.require("esri.arcgis.utils");
dojo.require("esri.dijit.OverviewMap");
var maxExtX = -20006031.09149561;
var maxExtY = -12433824.981519768;
var minExtX = 18816641.322648488;
var minExtY = 17739844.80810231;


var initExtent, maxExtent, visible = [];
var gcpFarmingSystems = new esri.layers.ArcGISDynamicMapServiceLayer("http://gismap.ciat.cgiar.org/ArcGISServer/rest/services/GCP/GCPAtlas/MapServer/",{"opacity":0.5});
function initMap() {
var itemDeferred = esri.arcgis.utils.getItem(agoId);
itemDeferred.addErrback(function(error) {
  console.log("getItem failed: ", dojo.toJson(error));
});
itemDeferred.addCallback(function(itemInfo) {
  if (!title) {
    title = itemInfo.item.title;
  }
  if (!subtitle) {
    subtitle = itemInfo.item.snippet;
  }
  //dojo.byId("titleDiv").innerHTML = title;
  //dojo.byId("subtitleDiv").innerHTML = subtitle;

  initExtent = new esri.geometry.Extent({"xmin":-3247790.679362219,"ymin":-2944708.4017954674,"xmax":10919353.89112171,"ymax":5449911.79259349,"spatialReference":{"wkid":4326}});
  var mapDeferred = esri.arcgis.utils.createMap(itemInfo, "map", {
    mapOptions: {
      slider: true,
      nav: true
    }
  });
  mapDeferred.addCallback(function(response) {
              dojo.connect(map,"onUpdateStart",showLoading);
        dojo.connect(map,"onUpdateEnd",hideLoading);
    map = response.map;

    map.disableScrollWheelZoom();
    //define symbology
    var colors = defaultSymbols.split(";");
    symbol = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_X, 10, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color(colors[0]), 3.5));




symbol6 = new esri.symbol.PictureMarkerSymbol("http://amkn-test.cgiar.org/wp-content/themes/amkn_theme/images/pin.png", 25, 25);
symbol4 = new esri.symbol.PictureMarkerSymbol("http://amkn-test.cgiar.org/wp-content/themes/amkn_theme/images/post.png", 25, 25);
symbol3 = new esri.symbol.PictureMarkerSymbol("http://amkn-test.cgiar.org/wp-content/themes/amkn_theme/images/photo.png", 25, 25);
symbol2 = new esri.symbol.PictureMarkerSymbol("http://amkn-test.cgiar.org/wp-content/themes/amkn_theme/images/video.png", 25, 25);

    highlightSymbol = new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_CIRCLE, 22, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color(colors[1]), 3.5), new dojo.Color([0, 0, 255, 0.01]));

    if (map.loaded) {
      mapLoaded();
    }
    else {
      dojo.connect(map, "onLoad", mapLoaded);
    }

  });
  mapDeferred.addErrback(function(error) {
    console.log("Map creation failed: ", dojo.toJson(error));
  });
});

}

function mapLoaded() {
addGCPData();

dojo.connect(dijit.byId('map'), 'resize', resizeMap);


highlightGraphic = new esri.Graphic(null, highlightSymbol);
map.graphics.add(highlightGraphic);
var overviewMapDijit = new esri.dijit.OverviewMap({
map: map,
visible:true
});
          overviewMapDijit.startup();
          map.disableScrollWheelZoom();
popupWindow = dojo.create("div", {
  id: "popupWindow"
}, dojo.body());
if (popupSize) {
  var sizeArr = popupSize.split(",");
  dojo.style(popupWindow, {
    width: sizeArr[0] + "px",
    height: sizeArr[1] + "px"
  });
}
console.log("Process CSV");

processCsvData(dataUrl);
//dojo.byId("dataSource").innerHTML = "Data from: <a href='" + dataUrl + "'>" + dataUrl + "</a>";


dojo.connect(dojo.byId("itemsDiv"), "onscroll", hideItemDetails);
dojo.connect(map, "onMouseDragStart", hideItemDetails);
dojo.connect(map, "onZoomStart", hideItemDetails);
dojo.connect(map, "onExtentChange", function(extent){

    var maxExtent = new esri.geometry.Extent({"xmin":minExtX,"ymin":minExtY,"xmax":maxExtX,"ymax":maxExtY,"spatialReference":{"wkid":4326}});
    var adjustedEx = new esri.geometry.Extent(extent.xmin, extent.ymin, extent.xmax, extent.ymax);
    if(map.getLevel()<3)
    {
        //map.setLevel(3);
    //alert(extent.xmin + "\n" + minExtX);
    //map.setExtent(maxExtent, true);
    }

var vals = "";

        var flag = false;
        var buffer = 10;

              if(Math.abs(extent.xmax) > Math.abs(initExtent.xmax)) {
                vals += "xmax | "+ extent.xmax +" | "+ maxExtent.xmax + "\n";
                flag = true;
    }
                if(Math.abs(extent.ymax) > Math.abs(initExtent.ymax)) {
                vals += "ymax | "+ extent.ymax +" | "+ maxExtent.ymax + "\n";
                flag = true;
    }
    if (flag === true) {
           //map.setExtent(initExtent, true);
           //alert(vals);
    }
    flag = false;
hideLoading();

  });



}
function showLoading() {
  esri.show(document.getElementById('loadingImg'));

  map.disableMapNavigation();

}

function hideLoading(error) {
  esri.hide(document.getElementById('loadingImg'));
  map.enableMapNavigation();
}

function processCsvData(url) {
dojo.byId("itemsList").innerHTML = "Downloading data...";

// CREATE A GRAPHICS LAYER FOR CSV DATA
dataLayer = new esri.layers.GraphicsLayer();
map.addLayer(dataLayer);

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
    var labelField, latField, longField, typeField;
    dojo.forEach(items, function(item, index) {
      if (index === 0) {
        var fields = getAttributeFields(item);
        labelField = fields[0];
        latField =  fields[1];
        longField =  fields[2];
        typeField = fields[3];
      }

      var label = csvStore.getValue(item, labelField) || "";
      var id = csvStore.getIdentity(item);


      content += ("<li onclick='showItemDetails(this, " + id + ");'><b>" + (id + 1) + ".</b> " + label.replace(/^\s+|\s+$/g, "") + "</li>");

      addGraphic(id, csvStore.getValue(item, latField), csvStore.getValue(item, longField), csvStore.getValue(item, typeField));
    });

    dojo.byId("itemsList").innerHTML = "Data Loaded"+"<br>"+content;
    // REGISTER CLICK EVENT HANDLER
    dojo.connect(dataLayer, "onClick", onFeatureClick);
    dojo.connect(map.graphics, "onClick", onFeatureClick);

    // ZOOM TO THE COLLECTIVE EXTENT OF THE DATA
    var multipoint = new esri.geometry.Multipoint(new esri.SpatialReference({
      wkid: 4326
    }));
    dojo.forEach(dataLayer.graphics, function(graphic) {
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
  },
  //onComplete
  onError: function(error) {
    dojo.byId("itemsList").innerHTML = "Unable to download the data.";
  }

});


}
function addGCPData()
{
var items = dojo.map(gcpFarmingSystems.layerInfos,function(info,index){
  if (info.defaultVisibility) {
    //visible.push(info.id);
  }
  return "<input type='checkbox' class='list_item' id='" + info.id + "' onclick='updateLayerVisibility();' /><label for='" + info.id + "'>" + info.name + "</label><br />";
});

dojo.byId("layer_list").innerHTML = "<br />"+items.join("");
gcpFarmingSystems.setVisibleLayers(visible);
map.addLayer(gcpFarmingSystems);

}
function addGraphic(id, latitude, longitude, type) {
latitude = parseFloat(latitude);
longitude = parseFloat(longitude);

if (isNaN(latitude) || isNaN(longitude)) {
  return;
}

var geometry = new esri.geometry.Point(longitude, latitude);
if (dojo.indexOf([102113, 102100, 3857], map.spatialReference.wkid) !== -1) {
  geometry = esri.geometry.geographicToWebMercator(geometry);
}


switch (type) {
  case "video_testimonials":
    dataLayer.add(new esri.Graphic(geometry, symbol2, {
      id: id
    }));
    break;
  case "ccafs_sites":
    dataLayer.add(new esri.Graphic(geometry, symbol6, {
      id: id
    }));
    break;
  case "amkn_blog_posts":
    dataLayer.add(new esri.Graphic(geometry, symbol4, {
      id: id
    }));
    break;
  case "photo_testimonials":
    dataLayer.add(new esri.Graphic(geometry, symbol3, {
      id: id
    }));
    break;
  default:
    dataLayer.add(new esri.Graphic(geometry, symbol, {
      id: id
    }));
    break;
}

}

function highlight(id) {
var match = findGraphicById(id);
if (match) {
  highlightGraphic.setGeometry(match.geometry);
  highlightGraphic.setAttributes({
    id: match.attributes.id
  });
}
}

function showItemDetails(node, id) {
var match = findGraphicById(id);
if (match) {
  // HIGHLIGHT ITEM IN THE TABLE
  if (highlightedNode) {
    dojo.removeClass(highlightedNode, "highlightedItem");
  }
  dojo.addClass(node, "highlightedItem");
  highlightedNode = node;

  // SHOW POPUP WITH ITEM ATTRIBUTES
  setPopupContent(id);

  var coords = dojo.coords(node);
  if (layout === "left") {
    dijit.placeOnScreen(popupWindow, {
      x: coords.x + coords.w,
      y: coords.y
    }, ["TL", "BL"], {
      x: 10,
      y: 0
    });
  }
  else {
    dijit.placeOnScreen(popupWindow, {
      x: coords.x,
      y: coords.y
    }, ["TR", "BR"], {
      x: 10,
      y: 0
    });
  }

  highlight(id);
  map.centerAt(match.geometry);
}
}

function onFeatureClick(evt) {
var graphic = evt.graphic;
if (graphic) {
  if (highlightedNode) {
    dojo.removeClass(highlightedNode, "highlightedItem");
  }
  var node = graphic.getDojoShape().getNode(),
    id = graphic.attributes.id;
  highlight(id);
  setPopupContent(id);

  if (dojo.isWebKit || dojo.isIE) {
    dijit.placeOnScreen(popupWindow, {
      x: evt.pageX,
      y: evt.pageY
    }, ["TR", "BR", "BL", "TL"], {
      x: 14,
      y: 14
    });
  }
  else {
    dijit.placeOnScreenAroundNode(popupWindow, node, {
      "TR": "BL",
      "BR": "TL",
      "BL": "TR",
      "TL": "BR"
    });
  }
}
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
    popupWindow.innerHTML = "<div id='popupHide' onclick='hideItemDetails();'>Hide</div>" + esri.substitute(data, defaultInfoTemplate);
  }
});
}


function hideItemDetails() {
if (highlightedNode) {
  dojo.removeClass(highlightedNode, "highlightedItem");
}

if (popupWindow) {
  dojo.style(popupWindow, {
    left: "-1000px",
    top: "-1000px"
  });
}

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

function getAttributeFields(item) {
var attributes = csvStore.getAttributes(item);
if (!attributes) {
  return defaultFields;
}

var defLabelField = defaultFields[0],
  defLatField = defaultFields[1],
  defLongField = defaultFields[2];
  defTypeField = defaultFields[3];
var labelField, latField, longField, typeField;

dojo.forEach(attributes, function(attr) {
  attr = attr || "";
  var attr_lwr = attr.toLowerCase();
  switch (attr_lwr) {
  case defLabelField:
    if (!labelField) {
      labelField = attr;
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

return [labelField || defLabelField, latField || defLatField, longField || defLongField, typeField || defTypeField];
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
      function updateLayerVisibility() {
        var inputs = dojo.query(".list_item"), input;

        visible = [];

        dojo.forEach(inputs,function(input){
          if (input.checked) {
              visible.push(input.id);
          }
          });
        //if there aren't any layers visible set the array to be -1
        if(visible.length === 0){
          visible.push(-1);
        }
        gcpFarmingSystems.setVisibleLayers(visible);
      }