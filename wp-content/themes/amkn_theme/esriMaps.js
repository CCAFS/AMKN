dojo.require("esri.map");
dojo.require("esri.arcgis.utils");
dojo.require("esri.dijit.Legend");
dojo.require("esri.dijit.Scalebar");
var map;
function initMap() {
    var itemDeferred = esri.arcgis.utils.getItem(webmap);

    itemDeferred.addCallback(function(itemInfo) {


        var mapDeferred = esri.arcgis.utils.createMap(itemInfo, "map", {
            mapOptions: {
                slider: true,
                nav: true
            },
            bingMapsKey: bingMapsKey,
            geometryServiceURL: "http://sampleserver3.arcgisonline.com/ArcGIS/rest/services/Geometry/GeometryServer"
        });

        mapDeferred.addCallback(function(response) {
            map = response.map;
            var layers = response.itemInfo.itemData.operationalLayers;
            if (map.loaded) {

                buildLayerList(layers);
            }
            else {
                dojo.connect(map, "onLoad", function() {

                    buildLayerList(layers);
                });
            }
            dojo.connect(dijit.byId('map'), 'resize', resizeMap);
        });

        mapDeferred.addErrback(function(error) {
            console.log("CreateMap failed: ", dojo.toJson(error));
        });
    });

    itemDeferred.addErrback(function(error) {
        if (error && error.message === "BingMapsKey must be provided.") {
            alert("Deploying this application requires your own Bing Maps key.");
        } else {
            console.log("CreateMap failed: ", dojo.toJson(error));
        }
    });

}
function addLegend(layers) {
    var scalebar = new esri.dijit.Scalebar({
        map: map,
        scalebarUnit: "english" //metric or english
    });
    var layerInfo = dojo.map(layers, function(layer, index) {
        var layer = map.getLayer("operational" + index);
        return {layer: layer, title: layer.title};
    });
    if (layerInfo.length > 0) {
        var legendDijit = new esri.dijit.Legend({
            map: map,
            layerInfos: layerInfo
        }, "legendDiv");
        legendDijit.startup();
    }
    else {
        dojo.byId('legendDiv').innerHTML = 'No operational layers';
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



function buildLayerList(layer) {
    var infos = layer.layerInfos, info;
    var items = [];
    alert(infos.length);
    for (var i = 0, il = infos.length; i < il; i++) {
        info = infos[i];
        if (info.defaultVisibility) {
            visible.push(info.id);
        }
        items[i] = "<input type='checkbox' class='list_item' checked='" + (info.defaultVisibility ? "checked" : "") + "' id='" + info.id + "' onclick='updateLayerVisibility();' /><label for='" + info.id + "'>" + info.name + "</label>";
    }
    dojo.byId("layer_list").innerHTML = items.join();

    layer.setVisibleLayers(visible);
    map.addLayer(layer);
}

function updateLayerVisibility() {
    var inputs = dojo.query(".list_item"), input;
    a
    visible = [];
    for (var i = 0, il = inputs.length; i < il; i++) {
        if (inputs[i].checked) {
            visible.push(inputs[i].id);
        }
    }
    layer.setVisibleLayers(visible);
}
