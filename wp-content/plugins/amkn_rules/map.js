
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

var maxExtX=-20006031.09149561;
var maxExtY=-12433824.981519768;
var minExtX=18816641.322648488;
var minExtY=17739844.80810231;
var intMaxExtX=16985396.45583168;
var intMaxExtY=7524106.992139481;
var intMinExtX=-7728835.025551194;
var intMinExtY=-5586372.099330453;
var initLvl=3;

var map,visLyr,popup,popupOptions,tLayers=[],vLyr,qPop,identifyTask,identifyParams,legend,hQuery,cPx,cHType,polyGraphic,hoverGraphic,hoverText,currentLocation,popupWindow,cntr,idCT,highlightSymbol,highlightGraphic,showLegend,sGCP,baseMP,iconT,baseExt,ctrPt,lvlMp,loadExtent,mapLevel,mapExtent,basemapGallery,tiledMapServiceLayer,gcpFarmingSystems,africaTSLayers,multipoint,popupSize,loading,initExtent,maxExtent,dataLayer,hoverLayer,syms6,syms4,syms5,syms2,syml6,syml4,syml5,syml2,visible=[],legendLayers=[];

var vtonmap=[];
var cconmap=[];
var bgonmap=[];
var bdonmap=[];
var ptonmap=[];

/**
 * @function initMap
 * @description this method is incharge of initialise the map, it make the calls and the assignations to the map to be loaded
 * @return {void} 
**/
function initMap(){
    baseMP='basemap_5';
    getViewTree();
    syml6=new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/pin-mini.png",17,25);
    syms6=new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/pin-mini.png",7,10);    
    syml4=new esri.symbol.PictureMarkerSymbol('./wp-content/themes/amkn_theme/images/amkn_blog_posts-mini.png',21,21);    
    syml5=new esri.symbol.PictureMarkerSymbol('./wp-content/themes/amkn_theme/images/photo_testimonials-mini.png',21,21);    
    syml2=new esri.symbol.PictureMarkerSymbol('./wp-content/themes/amkn_theme/images/video_testimonials-mini.png',21,21);    
    sym7=new esri.symbol.PictureMarkerSymbol('./wp-content/themes/amkn_theme/images/biodiv_cases-mini.png',21,21);    
    symh2=new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/video_testimonials-miniH.gif",21,21);
    symh4=new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/amkn_blog_posts-miniH.gif",21,21);
    symh5=new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/photo_testimonials-miniH.gif",21,21);
    symh6=new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/ccafs_sites-miniH.gif",17,25);
    symhX=new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/biodiv_cases-miniH.gif",21,21);
    symhA=new esri.symbol.PictureMarkerSymbol("./wp-content/themes/amkn_theme/images/ccafs_activities-mini.png",21,21);
    syms4=new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0,0,255]));
    syms5=new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0,0,255]));
    syms2=new esri.symbol.SimpleMarkerSymbol().setColor(new dojo.Color([0,0,255]));
    highlightSymbol=new esri.symbol.SimpleMarkerSymbol(esri.symbol.SimpleMarkerSymbol.STYLE_SQUARE,25,new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID,new dojo.Color([39,92,3,1]),3.5),new dojo.Color([244,201,63,0.2]));
    popupWindow=new dijit.Dialog({
        title:"Show Content",
        style:"width: 680px; min-height: 650px;"
    });
    hQuery=new dijit.TooltipDialog({
        id:"hQuery",
        style:"position: absolute; min-width: 250px; max-width: 350px; font: normal normal normal 10pt Helvetica;z-index:100"
    });
    hQuery.startup();
    loading=dojo.byId("loadingImg");
    initExtent=new esri.geometry.Extent({
        "xmin":intMinExtX,
        "ymin":intMinExtY,
        "xmax":intMaxExtX,
        "ymax":intMaxExtY,
        "spatialReference":{
            "wkid":102100
        }
    });
    qPop=new dijit.TooltipDialog({
        style:"position: absolute; min-width: 250px; max-width: 350px;z-index:100;"
    });
    qPop.startup();
    map=new esri.Map("map",{
        extent:initExtent,
        isZoomSlider:true,
        wrapAround180:true
    });
//    polygonsDraw();
    dojo.connect(map,"onUpdateStart",showLoading);
    dojo.connect(map,"onUpdateEnd",hideLoading);
    dojo.connect(map,"onPanStart",showLoading);
    dojo.connect(map,"onPanEnd",hideLoading);
    dojo.connect(map,"onZoomStart",showLoading);
    dojo.connect(map,"onZoomEnd",hideLoading);
    dojo.connect(map,'onLoad',function(map){
        createMapMenu();
        map.disableScrollWheelZoom();
        highlightGraphic=new esri.Graphic(null,cHType);
        map.graphics.add(highlightGraphic);
        dojo.connect(dijit.byId('map'),'resize',resizeMap);
        var overviewMapDijit=new esri.dijit.OverviewMap({
            map:map,
            visible:true
        });
        overviewMapDijit.startup();        
        initBackMap();
        dojo.removeClass("tb3","hide");
    });
    dojo.connect(map,"onExtentChange",function(extent){
        setViewTree();
        dijit.popup.close(hQuery);
        findPointsInExtentTree(map.extent);
        hoverLayer.remove(polyGraphic);        
    });
    dojo.connect(map,"onKeyDown",function(evt){
        dijit.popup.close(hQuery);
    });
    createDataLayersBranch();
    basemapGallery=new esri.dijit.BasemapGallery({
        showArcGISBasemaps:true,
        map:map
    },"basemapGallery");
    basemapGallery.startup();
    
    dojo.connect(basemapGallery,"onSelectionChange",function(){
        baseMP=basemapGallery.getSelected().id;
        setViewTree();
    });
    
    require(["dojo/on"], function(on){
      on(basemapGallery, "load", function(){
        basemapGallery.select(baseMP);
      });     
    });
    
    tiledMapServiceLayer=new esri.layers.ArcGISTiledMapServiceLayer("http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer");
    map.addLayer(tiledMapServiceLayer);
    multipoint=new esri.geometry.Multipoint(new esri.SpatialReference({
        wkid:4326
    }));
    dataLayer=new esri.layers.GraphicsLayer();
    hoverLayer=new esri.layers.GraphicsLayer();
    map.addLayer(dataLayer);
    map.addLayer(hoverLayer);
    dojo.connect(dataLayer,"onClick",onFeatureClick);
    dojo.connect(map.graphics,"onClick",onFeatureClick);
    dojo.connect(dataLayer,"onMouseOver",onFeatureHover);
    dojo.connect(hoverLayer,"onMouseOut",onFeatureLeave);
    dojo.connect(hoverLayer,"onMouseOver",showTT);
    dojo.connect(map,"onLoad",addDataLayers);
}

function polygonsDraw() {      
//create a popup to replace the map's info window
//    domConstruct = new dojo.domConstruct();
    require(["dojo.dom-construct","dojo/domReady!","esri/symbols/SimpleMarkerSymbol"], function(domConstruct,SimpleMarkerSymbol){
      popupOptions = {
        markerSymbol: new SimpleMarkerSymbol("circle", 32, null,
              new dojo.Color([0, 0, 0, 0.25])),
        marginLeft: "20",
        marginTop: "20"
      };
      popup = new esri.dijit.Popup(popupOptions, domConstruct.create("div"));   
    });
    
//    map=new esri.Map("map",{
//        extent:initExtent,
//        isZoomSlider:true,
//        wrapAround180:true,
//        infoWindow: popup
//    });
        
    var popupTemplate = new esri.dijit.PopupTemplate({
      title: "{address}",
      fieldInfos: [        
        {
          fieldName: "COUNTRY",
          visible: true,
          label: "COUNTRY"                
        },
        {
          fieldName: "Shape",
          visible: true,
          label: "Shape"                
        },
        {
          fieldName: "SHAPE_AREA",
          visible: true,
          label: "SHAPE_AREA"                
        },
        {
          fieldName: "FEATURECLA",
          visible: true,
          label: "FEATURECLA"                
        }
      ]      
    });

    //create a feature layer based on the feature collection
    var featureLayer = new esri.layers.FeatureLayer("http://gisweb.ciat.cgiar.org/arcgis/rest/services/CCAFS/ccafs_climate/MapServer/0",
    {
      mode: esri.layers.FeatureLayer.MODE_SNAPSHOT,
      infoTemplate: popupTemplate,
      outFields: ["*"]
    });
    featureLayer.setDefinitionExpression("COUNTRY IN ('Colombia','Brazil','Peru','Nigeria','argentina')");
    var symbol = new esri.symbol.SimpleFillSymbol(esri.symbol.SimpleFillSymbol.STYLE_SOLID, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([0, 0, 0, 1]), 1), new dojo.Color([0, 255, 0, 0.35]));
    featureLayer.setRenderer(new esri.renderer.SimpleRenderer(symbol));
    map.addLayer(featureLayer);
    
//    map.infoWindow.resize(245,125);
        
        dialog = new dijit.TooltipDialog({
          id: "tooltipDialog",
          style: "position: absolute; width: 250px; font: normal normal normal 10pt Helvetica;z-index:100"
        });
        dialog.startup();
        
        var highlightSymbol = new esri.symbol.SimpleFillSymbol(
          esri.symbol.SimpleFillSymbol.STYLE_NULL, 
          new esri.symbol.SimpleLineSymbol(
            esri.symbol.SimpleLineSymbol.STYLE_SOLID, 
            new dojo.Color([255,0,0]), 3
          ), 
          new dojo.Color([125,125,125,0.35])
        );

        //close the dialog when the mouse leaves the highlight graphic
        map.on("load", function(){
          map.graphics.enableMouseEvents();
          map.graphics.on("mouse-out", closeDialog);
          
        });
                
        //listen for when the onMouseOver event fires on the countiesGraphicsLayer
        //when fired, create a new graphic with the geometry from the event.graphic and add it to the maps graphics layer
        featureLayer.on("mouse-over", function(evt){
          var t = "<b>${NAME}</b><hr><b>2000 Population: </b>${POP2000:NumberFormat}<br>"
            + "<b>2000 Population per Sq. Mi.: </b>${POP00_SQMI:NumberFormat}<br>"
            + "<b>2007 Population: </b>${POP2007:NumberFormat}<br>"
            + "<b>2007 Population per Sq. Mi.: </b>${POP07_SQMI:NumberFormat}";
//          var esriLang = new esri.lang();
//          var content = esriLang.substitute(evt.graphic.attributes,t);
          var highlightGraphic = new esri.Graphic(evt.graphic.geometry,highlightSymbol);          
          map.graphics.add(highlightGraphic);
          map.graphics.on("click", function(){
            alert('ttt');
          });
//          dialog.setContent(content);

//          domStyle.set(dialog.domNode, "opacity", 0.85);
//          dijitPopup.open({
//            popup: dialog, 
//            x: evt.pageX,
//            y: evt.pageY
//          });
        });  
}

function closeDialog() {
  map.graphics.clear();
//  dijitPopup.close(dialog);
}

function addToMap(rsts,evt){
    for(var i=0,il=rsts.length;i<il;i++){
        var result=rsts[i];
        qPop.setContent(result.layerName+": "+result.value);
    }
    dijit.popup.open({
        popup:qPop,
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
function showLoading(){
//    esri.show(loading);
    dijit.popup.close(hQuery);
//    map.disableMapNavigation();
//    map.disableScrollWheelZoom();
}
function hideLoading(error){
//    esri.hide(loading);
//    map.enableMapNavigation();
//    map.disableScrollWheelZoom();
//    findPointsInExtent(map.extent);
    findPointsInExtentTree(map.extent);
//    setViewTree();
}
function processCsvData(url){
    var frameUrl=new dojo._Url(window.location.href);
    var csvUrl=new dojo._Url(url);
    if(frameUrl.host!==csvUrl.host||frameUrl.port!==csvUrl.port||frameUrl.scheme!==csvUrl.scheme){
        url=(proxyUrl)?proxyUrl+"?"+url:url;
        console.log(url);        
    }    
    csvStore=new dojox.data.CsvStore({
        url:url
    });
    csvStore.fetch({
        onComplete:function(items,request){
            var content="";
            var labelField,latField,longField,typeField,cIDField;
            dojo.forEach(items,function(item,index){
                if(index===0){
                    var fields=getAttributeFields(item);
                    labelField=fields[0];
                    latField=fields[1];
                    longField=fields[2];
                    typeField=fields[3];
                    cIDField=fields[4];
                }
                var label=csvStore.getValue(item,labelField)||"";
                var id=csvStore.getIdentity(item);
                addGraphic(id,csvStore.getValue(item,latField),csvStore.getValue(item,longField),csvStore.getValue(item,typeField));
            });
            dojo.forEach(dataLayer.graphics,function(graphic){
                var geometry=graphic.geometry;
                if(geometry){
                    multipoint.addPoint({
                        x:geometry.x,
                        y:geometry.y
                    });
                }
            });
            if(multipoint.points.length>0){
                maxExtent=multipoint.getExtent();
            }
            hideLoading();
//            enableFormsOnQuery();
        },
        onError:function(error){}
    });
}

/**
 * @function onFeatureClick
 * @description this method executed when the icon in the map is clicked.
 * @argument {object} evt it is the reference of the object in the map
 * @return {void}
 * @
**/
function onFeatureClick(evt){
    var graphic=evt.graphic;
    if(graphic){
        var id=graphic.attributes.id;
        var cid;
        csvStore.fetchItemByIdentity({
          identity:id,
          onItem:function(item){
            cid=csvStore.getValue(item,"CID");
          }
        });
        document.location = "'./?p="+cid+"'";
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
function showItemDetails(node,id){
    var match=findGraphicById(id);
    map.infoWindow.hide();
    if(match){
        setPopupContent(id);
        map.graphics.remove(highlightGraphic);
        highlightGraphic=new esri.Graphic(null,cHType);
        map.graphics.add(highlightGraphic);
        highlightGraphic.setGeometry(match.geometry);
        highlightGraphic.setAttributes({
            id:id
        });
        centerAtPoint(match.geometry.x,match.geometry.y);
    }
    dijit.popup.close(hQuery);
}
function findGraphicById(id){
    var match;
    dojo.some(dataLayer.graphics,function(graphic){
        if(graphic.attributes&&graphic.attributes.id===id){
            match=graphic;
            return true;
        }
        else{
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
function onFeatureHover(evt){
    var gPt2Spt=map.toScreen(evt.graphic.geometry);
    getItemsAtLocation(gPt2Spt.x,gPt2Spt.y,evt);
}

/**
 * @function onListHover
 * @description this method stand out the icon on the map
 * @argument {int} id it is the reference of a item on the map
 * @return {void} 
**/
function onListHover(id){
  id = parseInt(id);  
  if (!isNaN(id)) {
    var graphic=findGraphicById(id);
    map.graphics.remove(hoverGraphic);
    var id=graphic.attributes.id;
    hoverGraphic=new esri.Graphic(null,highlightSymbol);
    map.graphics.add(hoverGraphic);
    hoverGraphic.setGeometry(graphic.geometry);
    hoverGraphic.setAttributes({
        id:id
    });

  }

}
function onFeatureLeave(){
    map.graphics.remove(hoverGraphic);
    hoverLayer.remove(polyGraphic);
}
function showTT(evt){}
function onQueryByPolyClick(){}
function centerAtPoint(clkX,clkY)
{
    var displace=map.extent.xmax-clkX;
    var displace2=clkX-map.extent.getCenter().x;
    var displace3=(map.extent.xmax-map.extent.getCenter().x)/2;
    var iDl=displace/displace2;
    var newX=map.extent.getCenter().x+(displace2-displace3);
    var centerPoint=new esri.geometry.Point(newX,clkY,map.spatialReference);
    map.centerAt(centerPoint);
}
function addGraphic(id,latitude,longitude,type){
    latitude=parseFloat(latitude);
    longitude=parseFloat(longitude);
    if(isNaN(latitude)||isNaN(longitude)){
        return;
    }
    var geometry=new esri.geometry.Point(longitude,latitude);
    if(dojo.indexOf([102113,102100,3857,4326],map.spatialReference.wkid)!==-1){
        geometry=esri.geometry.geographicToWebMercator(geometry);
    }
//    var sym6=(document.getElementById('iconType').checked)?syml6:syms6;
//    var sym4=(document.getElementById('iconType').checked)?syml4:syms4;
//    var sym5=(document.getElementById('iconType').checked)?syml5:syms5;
//    var sym2=(document.getElementById('iconType').checked)?syml2:syms2;
    var sym6=syml6;
    var sym4=syml4;
    var sym5=syml5;
    var sym2=syml2;
    var symA=symhA;
    switch(type){
        case"video_testimonials":
            dataLayer.add(new esri.Graphic(geometry,sym2,{
                id:id
            }));
            break;
        case"ccafs_sites":
            dataLayer.add(new esri.Graphic(geometry,sym6,{
                id:id
            }));
            break;
        case"amkn_blog_posts":
            dataLayer.add(new esri.Graphic(geometry,sym4,{
                id:id
            }));
            break;
        case"biodiv_cases":
            dataLayer.add(new esri.Graphic(geometry,sym7,{
                id:id
            }));
            break;
        case"photo_testimonials":
            dataLayer.add(new esri.Graphic(geometry,sym5,{
                id:id
            }));
            break;
        case"ccafs_activities":
            dataLayer.add(new esri.Graphic(geometry,symA,{
                id:id
            }));
            break;
        default:
            dataLayer.add(new esri.Graphic(geometry,sym5,{
                id:id
            }));
            break;
    }
}
function getAttributeFields(item){
    var attributes=csvStore.getAttributes(item);
    if(!attributes){
        return defaultFields;
    }
    var defLabelField=defaultFields[0],defLatField=defaultFields[1],defLongField=defaultFields[2],defTypeField=defaultFields[3],defcIDField=defaultFields[4];
    var labelField,latField,longField,typeField,cIDField;
    dojo.forEach(attributes,function(attr){
        attr=attr||"";
        var attr_lwr=attr.toLowerCase();
        switch(attr_lwr){
            case defLabelField:
                if(!labelField){
                    labelField=attr;
                }
                break;
            case defcIDField:
                if(!cIDField){
                    cIDField=attr;
                }
                break;
            case defLatField:
                if(!latField){
                    latField=attr;
                }
                break;
            case defLongField:
                if(!longField){
                    longField=attr;
                }
                break;
            case defTypeField:
                if(!typeField){
                    typeField=attr;
                }
                break;
        }
    });
    return[labelField||defLabelField,latField||defLatField,longField||defLongField,typeField||defTypeField,cIDField||defcIDField];
}
function setPopupContent(id){
    csvStore.fetchItemByIdentity({
        identity:id,
        onItem:function(item){
            var attributes=csvStore.getAttributes(item),data={};

            dojo.forEach(attributes,function(attr){
                data[attr]=csvStore.getValue(item,attr);
            });
            cType=esri.substitute(data,titleTemplate);
            dijit.byId("popContent").attr("content",esri.substitute(data,defaultInfoTemplate));
            dijit.byId("popContent").attr("title",getPopupTitle(esri.substitute(data,titleTemplate)));
            dojo.removeClass(document.getElementById("showContent"),"navigating");
            (dijit.byId("popContent").open)==true?"":dijit.byId("popContent").toggle();
            dojo.connect(dijit.byId("popContent"),"onHide",function(){
                dojo.addClass(document.getElementById("showContent"),"navigating");
                document.getElementById('ifrm').src="about:blank";
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
function getListingContent(id){
    var rt,ttl;
    csvStore.fetchItemByIdentity({
        identity:id,
        onItem:function(item){
            var attributes=csvStore.getAttributes(item),data={};

            dojo.forEach(attributes,function(attr){
                data[attr]=csvStore.getValue(item,attr);
                ttl=attr;
            });
            ttl=csvStore.getValue(item,"Location");
            rt=esri.substitute(data,titleTemplate);
            cid=csvStore.getValue(item,"CID");
        }
    });
    mapPTS=rt=="video_testimonials"?vtonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;"+ttl+"</li>"):"";
    mapPTS=rt=="ccafs_sites"?cconmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' >"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;<a class='link-ccafs-sites' href='./?p="+cid+"'>"+ttl+"</a></li>"):"";//without popup
    mapPTS=rt=="amkn_blog_posts"?bgonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;"+ttl+"</li>"):"";
    mapPTS=rt=="biodiv_cases"?bdonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;"+ttl+"</li>"):"";
    mapPTS=rt=="photo_testimonials"?ptonmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;"+ttl+"</li>"):"";
    maganaPpTS=rt=="ccafs_activities"?actnmap.push("<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;"+ttl+"</li>"):"";
    if (location.search=='') {
      if (rt=="ccafs_activities") {
        return"<li style='cursor:pointer;' onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+")'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;"+ttl+"</li>";
      } else {
        return"<li style='cursor:pointer;' onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='document.location = \"./?p="+cid+"\"'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;"+ttl+"</li>";
      }
    } else {
      str = location.search.split('&');
      parameterOne = str[1].split('=');
      parameterTwo = str[2].split('=');
      document.getElementById("showContent").style.top = "0px";
      document.getElementById("showContent").style.width = (parameterOne[1]-50)+"px";
      document.getElementById("showContent").style.height = (parameterTwo[1]-50)+"px";
//      document.getElementById("ifrm").style.width = (parameterOne[1]-50)+"px";
//      document.getElementById("ifrm").style.minHeight = (parameterTwo[1]-50)+"px";
      
      return"<li style='cursor:pointer;' onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='window.open(\"./?p="+cid+"\",\"_blank\",\"scrollbars=yes, resizable=yes, top=60, left=60, width=700, height=630\");'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;"+ttl+"</li>";
//      return"<li onMouseOut='onFeatureLeave()' onMouseOver='onListHover("+id+")' onclick='showItemDetails(this, "+id+")'>"+"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+rt+"-mini.png' />&nbsp;"+ttl+"</li>";
    }    
}
function getPopupTitle(type){
    switch(type){
        case"video_testimonials":
            cHType=symh2;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Video";
            break;
        case"ccafs_sites":
            cHType=symh6;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Site";
            break;
        case"amkn_blog_posts":
            cHType=symh4;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Blog Post";
            break;
        case"biodiv_cases":
            cHType=symhX;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Agrobiodiversity Cases";
            break;
        case"photo_testimonials":
            cHType=symh5;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Photo Set";
            break;
        case"ccafs_activities":
            cHType=symhA;
            return"<img class='titleImg' src='./wp-content/themes/amkn_theme/images/"+type+"-mini.png' />&nbsp;Activities";
            break;
        default:
            cHType=highlightSymbol;
            return"Content Preview";
            break;
    }
}
function hideItemDetails(){
    if(popupWindow){
        dojo.style(popupWindow,{
            left:"-1000px",
            top:"-1000px"
        });
    }
}
function resizeMap(){
    var resizeTimer;
    clearTimeout(resizeTimer);
    resizeTimer=setTimeout(function(){
        map.resize();
        map.reposition();
    },500);
}
function rLegend(){
    (typeof legend=="undefined")?"":legend.refresh();
}
function addGCPLayers()
{}
function updateLegend()
{
    rLegend();
}
function showHideGCP(){}

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
  var showpts="";
  var showimp="";
  var showas="";
  var showms="";
  var showcl="";
  var showccc="";
  var showaz="";
  for(var i=0;i<points.length;i++){
      if(points[i].data.key.match('accord_')) {
          showpts+=points[i].data.key.replace('accord_','')+",";            
      } else if (points[i].data.key.match('taxio_')) {          
        switch(points[i].getParent().data.key){
          case"impacts":
            showimp+=points[i].data.key.replace('taxio_','')+",";
          break;
          case"adaptation_strategy":
            showas+=points[i].data.key.replace('taxio_','')+","; 
          break;
          case"mitigation_strategy":
            showms+=points[i].data.key.replace('taxio_','')+","; 
          break;
          case"climate_change_challenges":
            showccc+=points[i].data.key.replace('taxio_','')+","; 
          break;
        }
      }
  }
  showpts=showpts===""?"":"&pts="+showpts;

  //this vars provably will be use when the method be complet
  showimp=showimp===""?"":"&imp="+showimp;
  showas=showas===""?"":"&as="+showas;
  showms=showms==""?"":"&ms="+showms;
  showccc=showccc===""?"":"&ccc="+showccc;

  var newURL=baseDataURL+"?fmt=csv"+showpts+showimp+showas+showms+showcl+showccc+showaz;
  if(cb)
  {
//      map.removeLayer(dataLayer);
//      dataLayer="";
//      dataLayer=new esri.layers.GraphicsLayer();
//      map.addLayer(dataLayer);
      dataLayer.clear();
//      disableFormsOnQuery();
  }
  processCsvData(newURL);
  if(cb)
  {
//      dojo.connect(dataLayer,"onClick",onFeatureClick);
//      dojo.connect(map.graphics,"onClick",onFeatureClick);
//      dojo.connect(dataLayer,"onMouseOver",onFeatureHover);
//      dojo.connect(dataLayer,"onMouseOut",onFeatureLeave);
      setViewTree();
  }
}

function updateDataLayer(cb)
{
    var pts=document.pts;
    var imp=document.impacts;
    var as=document.adaptation_strategy;
    var ms=document.mitigation_strategy;
    var cl=document.crops_livestock;
    var ccc=document.climate_change_challenges;
    var az=document.agroecological_zones;
    var showpts="";
    var showimp="";
    var showas="";
    var showms="";
    var showcl="";
    var showccc="";
    var showaz="";
    var hasPts="";
    var hasRes="";
    
    for(var i=0;i<pts.length;i++){
        if(pts.elements[i].checked)

        {
            showpts+=pts.elements[i].value+",";
            hasPts=true;
        }
    }

    for(var i=0;i<imp.length;i++)
    {
        if(imp.elements[i].checked)

        {
            showimp+=imp.elements[i].value+",";
        }
    }
    for(var i=0;i<as.length;i++)
    {
        if(as.elements[i].checked)

        {
            showas+=as.elements[i].value+",";
        }
    }
    for(var i=0;i<ms.length;i++)
    {
        if(ms.elements[i].checked)

        {
            showms+=ms.elements[i].value+",";
        }
    }
    for(var i=0;i<ccc.length;i++)
    {
        if(ccc.elements[i].checked)

        {
            showccc+=ccc.elements[i].value+",";
        }
    }
    showpts=showpts==""?"":"&pts="+showpts;
    showimp=showimp==""?"":"&imp="+showimp;
    showas=showas==""?"":"&as="+showas;
    showms=showms==""?"":"&ms="+showms;
    showcl=showcl==""?"":"&cl="+showcl;
    showccc=showccc==""?"":"&ccc="+showccc;
    showaz=showaz==""?"":"&az="+showaz;
    hasThemes=showimp+showas+showms+showcl+showccc+showaz;
    hasRes=hasThemes+hasPts;
    hasRes=hasRes==""?dojo.removeClass(document.getElementById("rsType_label"),"sldMenu"):dojo.addClass(document.getElementById("rsType_label"),"sldMenu");
    hlimp=showimp==""?dojo.removeClass(document.getElementById("d_impacts"),"sldMenu"):dojo.addClass(document.getElementById("d_impacts"),"sldMenu");
    hlas=showas==""?dojo.removeClass(document.getElementById("d_adaptation_strategy"),"sldMenu"):dojo.addClass(document.getElementById("d_adaptation_strategy"),"sldMenu");
    hlms=showms==""?dojo.removeClass(document.getElementById("d_mitigation_strategy"),"sldMenu"):dojo.addClass(document.getElementById("d_mitigation_strategy"),"sldMenu");
    hlccc=showccc==""?dojo.removeClass(document.getElementById("d_climate_change_challenges"),"sldMenu"):dojo.addClass(document.getElementById("d_climate_change_challenges"),"sldMenu");
    var newURL=baseDataURL+"?fmt=csv"+showpts+showimp+showas+showms+showcl+showccc+showaz;
    if(cb)
    {
        map.removeLayer(dataLayer);
        dataLayer="";
        dataLayer=new esri.layers.GraphicsLayer();
        map.addLayer(dataLayer);
        disableFormsOnQuery();
    }
    processCsvData(newURL);
    if(cb)
    {
        dojo.connect(dataLayer,"onClick",onFeatureClick);
        dojo.connect(map.graphics,"onClick",onFeatureClick);
        dojo.connect(dataLayer,"onMouseOver",onFeatureHover);
        dojo.connect(dataLayer,"onMouseOut",onFeatureLeave);
        setView();
    }
}
function disableFormsOnQuery()
{
    showLoading();
    var pts=document.pts;
    var imp=document.impacts;
    var as=document.adaptation_strategy;
    var ms=document.mitigation_strategy;
    var cl=document.crops_livestock;
    var ccc=document.climate_change_challenges;
    var az=document.agroecological_zones;
    for(var i=0;i<pts.length;i++)

    {
            pts.elements[i].disabled="true";
        }
    for(var i=0;i<imp.length;i++)
    {
        imp.elements[i].disabled="true";
    }
    for(var i=0;i<as.length;i++)
    {
        as.elements[i].disabled="true";
    }
    for(var i=0;i<ms.length;i++)
    {
        ms.elements[i].disabled="true";
    }
    for(var i=0;i<ccc.length;i++)
    {
        ccc.elements[i].disabled="true";
    }
}
function enableFormsOnQuery()
{
    hideLoading();
    hideItemDetails();
    var pts=document.pts;
    var imp=document.impacts;
    var as=document.adaptation_strategy;
    var ms=document.mitigation_strategy;
    var cl=document.crops_livestock;
    var ccc=document.climate_change_challenges;
    var az=document.agroecological_zones;
    for(var i=0;i<pts.length;i++)

    {
            pts.elements[i].disabled="";
        }
    for(var i=0;i<imp.length;i++)
    {
        imp.elements[i].disabled="";
    }
    for(var i=0;i<as.length;i++)
    {
        as.elements[i].disabled="";
    }
    for(var i=0;i<ms.length;i++)
    {
        ms.elements[i].disabled="";
    }
    for(var i=0;i<ccc.length;i++)
    {
        ccc.elements[i].disabled="";
    }
}
function clearAllTaxSelections()
{
    hideLoading();
    hideItemDetails();
    var pts=document.pts;
    var imp=document.impacts;
    var as=document.adaptation_strategy;
    var ms=document.mitigation_strategy;
    var cl=document.crops_livestock;
    var ccc=document.climate_change_challenges;
    var az=document.agroecological_zones;
    clearAllChecks(imp);
    clearAllChecks(as);
    clearAllChecks(ms);
    clearAllChecks(ccc);
}
function clearAllChecks(formN){
    for(var i=0;i<formN.length;i++)

    {
            formN.elements[i].checked="";
        }
    updateDataLayer(true);
}
function markAllChecks(formN){
    for(var i=0;i<formN.length;i++)

    {
            formN.elements[i].checked="checked";
        }
    updateDataLayer(true);
}
function unChecks(formN){
    for(var i=0;i<formN.length;i++)

    {
            formN.elements[i].checked="";
        }
}
function setView()
{
    var pts=document.pts;
    var imp=document.impacts;
    var as=document.adaptation_strategy;
    var ms=document.mitigation_strategy;
    var cl=document.crops_livestock;
    var ccc=document.climate_change_challenges;
    var az=document.agroecological_zones;
    var showpts="";
    var showimp="";
    var showas="";
    var showms="";
    var showcl="";
    var showccc="";
    var showaz="";
    var showLyr="";
    for(var i=0;i<pts.length;i++)

    {
            if(pts.elements[i].checked)

            {
                showpts+=pts.elements[i].value+",";
            }
        }
    for(var i=0;i<imp.length;i++)
    {
        if(imp.elements[i].checked)

        {
            showimp+=imp.elements[i].value+",";
        }
    }
    for(var i=0;i<as.length;i++)
    {
        if(as.elements[i].checked)

        {
            showas+=as.elements[i].value+",";
        }
    }
    for(var i=0;i<ms.length;i++)
    {
        if(ms.elements[i].checked)

        {
            showms+=ms.elements[i].value+",";
        }
    }
    for(var i=0;i<ccc.length;i++)
    {
        if(ccc.elements[i].checked)

        {
            showccc+=ccc.elements[i].value+",";
        }
    }
    showpts=showpts==""?"":"/pts="+showpts;
    showimp=showimp==""?"":"/imp="+showimp;
    showas=showas==""?"":"/as="+showas;
    showms=showms==""?"":"/ms="+showms;
    showcl=showcl==""?"":"/cl="+showcl;
    showccc=showccc==""?"":"/ccc="+showccc;
    showLyr=((typeof vLyr=="undefined")||vLyr=="")?"":"/lyr="+vLyr;
    ((typeof vLyr!="undefined")&&vLyr!="")?dojo.addClass(document.getElementById("rsLayers_label"),"sldMenu"):dojo.removeClass(document.getElementById("rsLayers_label"),"sldMenu");
    mapCenter="/ctr="+map.extent.getCenter().x+";"+map.extent.getCenter().y;
    mapLevel="/lvl="+map.getLevel();
    var setBaseMP="/bm="+baseMP;
    var showGCP="";
    location.hash=setBaseMP+showGCP+mapCenter+mapLevel+showpts+showimp+showas+showms+showcl+showccc+showaz+showLyr;
}

/**
 * @function setViewTree
 * @description this method update the url
 * @argument {object} points It is an array of the element selected on the tree
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
**/
function setViewTree()
{    
  var points = $("#cFiltersList2").dynatree("getTree").getSelectedNodes();
  var showpts="";
  var showimp="";
  var showas="";
  var showms="";
  var showccc="";
  var showLyr="";
  for(var i=0;i<points.length;i++){
    if(points[i].data.key.match('accord_')) {
        showpts+=points[i].data.key.replace('accord_','')+",";            
    } else if (points[i].data.key.match('taxio_')) {
      switch(points[i].getParent().data.key){
        case"impacts":
          showimp+=points[i].data.key.replace('taxio_','')+",";
        break;
        case"adaptation_strategy":
          showas+=points[i].data.key.replace('taxio_','')+","; 
        break;
        case"mitigation_strategy":
          showms+=points[i].data.key.replace('taxio_','')+","; 
        break;
        case"climate_change_challenges":
          showccc+=points[i].data.key.replace('taxio_','')+",";
        break;
      }
    } else if (points[i].data.key.match('aglyr') && points[i].data.key.match('|')) {
      showLyr+=points[i].data.key+","; 
    }
  }
  showpts=showpts===""?"":"/pts="+showpts;
  showimp=showimp===""?"":"/imp="+showimp;
  showas=showas===""?"":"/as="+showas;
  showms=showms===""?"":"/ms="+showms;
  showccc=showccc===""?"":"/ccc="+showccc;
  showLyr=showLyr===""?"":"/lyr="+showLyr;
//  showLyr=((typeof vLyr=="undefined")||vLyr=="")?"":"/lyr="+vLyr;
  mapCenter="/ctr="+map.extent.getCenter().x+";"+map.extent.getCenter().y;
  mapLevel="/lvl="+map.getLevel();
  var setBaseMP="/bm="+baseMP;
  var showGCP="";  
  location.hash=setBaseMP+showGCP+mapCenter+mapLevel+showpts+showimp+showas+showms+showccc+showLyr;
}
function getView()
{
    var showpts="";
    var showimp="";
    var showas="";
    var showms="";
    var showcl="";
    var showccc="";
    var showaz="";
    var showLyr="";
    var setCTR="";
    var setLVL="";
    if(location.hash)

    {
    location.hash=unescape(location.hash);
    var theMap=unescape(location.hash).split("/");
        if(theMap!="")

        {
            unChecks(document.pts);
            for(var mp=0;mp<theMap.length;mp++)

            {
        var cEle=theMap[mp].split("=")[0];
        switch(cEle){
          case"pts":
                            checkTypeElements(theMap[mp].split("=")[1]);
          break;
          case"imp":
                            checkTaxElements("impacts",theMap[mp].split("=")[1]);
              break;
          case"as":
                            checkTaxElements("adaptation_strategy",theMap[mp].split("=")[1]);
              break;
          case"ms":
                            checkTaxElements("mitigation_strategy",theMap[mp].split("=")[1]);
              break;
          case"cl":
                            checkTaxElements("crops_livestock",theMap[mp].split("=")[1]);
              break;
          case"ccc":
                            checkTaxElements("climate_change_challenges",theMap[mp].split("=")[1]);
              break;
          case"az":
                            checkTaxElements("agroecological_zones",theMap[mp].split("=")[1]);
              break;
          case"ctr":
            ctrPt=theMap[mp].split("=")[1];
          break;
          case"cntr":
                            cntr=theMap[mp].split("=")[1];
                            var ctPT=new esri.geometry.Point(parseFloat(cntr.split(";")[1]),parseFloat(cntr.split(";")[0]));
                            ctPT=esri.geometry.geographicToWebMercator(ctPT);
                            ctrPt=ctPT.x+";"+ctPT.y;

          break;
          case"idCT":
                            idCT=theMap[mp].split("=")[1];
          break;
          case"lvl":
              lvlMp=theMap[mp].split("=")[1];
          break;
          case"lyr":
                            vLyr=theMap[mp].split("=")[1];
          break;
          case"ext":
          break;
          case"gcp":
                            if(theMap[mp].split("=")[1]=="t"){
                                sGCP=theMap[mp].split("=")[1];
                                document.getElementById("gcpFS").checked="checked";
                            }else{
                                document.getElementById("gcpFS").checked="";
                            }

          break;
          case"bm":
            baseMP=theMap[mp].split("=")[1];
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
  if(location.hash) {
    location.hash=unescape(location.hash);
    var theMap=unescape(location.hash).split("/");
    if(theMap!="") {
      for(var mp=0;mp<theMap.length;mp++) {
        var cEle=theMap[mp].split("=")[0];
        switch(cEle){
          case"pts":
            checkTypeElements(theMap[mp].split("=")[1]);
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
            ctrPt=theMap[mp].split("=")[1];
          break;
          case"cntr":
//            cntr=theMap[mp].split("=")[1];
//            var ctPT=new esri.geometry.Point(parseFloat(cntr.split(";")[1]),parseFloat(cntr.split(";")[0]));
//            ctPT=esri.geometry.geographicToWebMercator(ctPT);
//            ctrPt=ctPT.x+";"+ctPT.y;
          break;
          case"idCT":
//            idCT=theMap[mp].split("=")[1];
          break;
          case"lvl":
              lvlMp=theMap[mp].split("=")[1];
          break;
          case"lyr":  
              vLyr=theMap[mp].split("=")[1];
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
            baseMP=theMap[mp].split("=")[1];
          break;
          default:
          break;
        }
      }
    }
  }
  firstime = true;
}

function initBackMap()
{
    var move;
    if(ctrPt&&lvlMp){
      move=new esri.geometry.Point([parseFloat(ctrPt.split(";")[0]),parseFloat(ctrPt.split(";")[1])],new esri.SpatialReference({wkid:102100}));
      map.centerAndZoom(move,parseFloat(lvlMp));
    }
    ctrPt="";
    lvlMp="";        
    updateDataLayerTree(false);
}
function go2Region(pt,zm)
{
    move2=new esri.geometry.Point([parseFloat(pt.split(";")[0]),parseFloat(pt.split(";")[1])],new esri.SpatialReference({
        wkid:102100
    }));
    map.centerAndZoom(move2,parseFloat(zm));
//    map.centerAt(map.extent.getCenter());
}
function checkTaxElements(elements){
  var chkElements=elements.split(",");
  for(var i=0;i<chkElements.length;i++) {
    if(chkElements[i]!="") {
      $("#cFiltersList2").dynatree("getTree").getNodeByKey("taxio_"+chkElements[i]).select(true);
      $("#cFiltersList2").dynatree("getTree").getNodeByKey("taxio_"+chkElements[i]).getParent().getParent().expand(true);
      $("#cFiltersList2").dynatree("getTree").getNodeByKey("taxio_"+chkElements[i]).getParent().expand(true);
    }
  }
}
function checkTypeElements(elements){
  var chkElements=elements.split(",");
  for(var i=0;i<chkElements.length;i++) {    
    if(chkElements[i]!="") {
      $("#cFiltersList2").dynatree("getTree").getNodeByKey("accord_"+chkElements[i]).select(true);
    }
  }
}
function setBaseMap(bmId)
{
//    clearBaseSelection();
//    dojo.addClass("mapType"+bmId,"controls-selected");
    baseMP=bmId;
    basemapGallery.select(baseMP);    
//    setViewTree();
}
function clearBaseSelection()
{
    dojo.removeClass("mapType1","controls-selected");
    dojo.removeClass("mapType2","controls-selected");
    dojo.removeClass("mapType3","controls-selected");
}
function go2Loc(xMn,yMn,xMx,yMx){
    var setExt=new esri.geometry.Extent({
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
function createMapMenu(){
    ctxMenuForMap=new dijit.Menu({
        onOpen:function(box){
            currentLocation=getMapPointFromMenuPosition(box);
        }
    });
    ctxMenuForMap.addChild(new dijit.MenuItem({
        label:"Center and zoom here",
        onClick:function(evt){
            var centerPoint=new esri.geometry.Point(currentLocation.x,currentLocation.y,currentLocation.spatialReference);
            var tolvl=(map.getLevel()<10)?map.getLevel()+1:10;
            map.centerAndZoom(centerPoint,tolvl);
        }
    }));
    ctxMenuForMap.startup();
    ctxMenuForMap.bindDomNode(map.container);
}
function zoomToCtxt(){
    var tolvl=(map.getLevel()<10)?map.getLevel()+1:10;
    map.centerAndZoom(cPx,tolvl);
}
function zoomToOExt(){
    var tExt=new esri.geometry.Extent({
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
function getMapPointFromMenuPosition(box){
    var x=box.x,y=box.y;
    switch(box.corner){
        case"TR":
            x+=box.w;
            break;
        case"BL":
            y+=box.h;
            break;
        case"BR":
            x+=box.w;
            y+=box.h;
            break;
    }
    var screenPoint=new esri.geometry.Point(x-map.position.x,y-map.position.y);
    return map.toMap(screenPoint);
}

/**
 * @function getListingContentTree
 * @description this method create the diferents objects to display in each item of the tree
 * @argument {int} id it is the reference of a item on the map
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
**/
function getListingContentTree(id){
    var rt,ttl,cid;
    csvStore.fetchItemByIdentity({
        identity:id,
        onItem:function(item){
            var attributes=csvStore.getAttributes(item),data={};

            dojo.forEach(attributes,function(attr){
                data[attr]=csvStore.getValue(item,attr);
                ttl=attr;
            });
            ttl=csvStore.getValue(item,"Location");
            cid=csvStore.getValue(item,"CID");
            rt=esri.substitute(data,titleTemplate);
        }
    });    
    
    mapPTS=rt==="ccafs_sites"?cconmap.push({
        title: ttl, 
        key: id,
        url: './?p='+cid,
        hideCheckbox: true,
        unselectable: true,
        select: false,
        icon: '../../../../images/ccafs_sites-mini.png'
    }):"";
    mapPTS=rt==="video_testimonials"?vtonmap.push({
        title: ttl, 
        key: id,
        url: './?p='+cid,
        hideCheckbox: true,
        unselectable: true,
        select: false,
        icon: '../../../../images/video_testimonials-mini.png'
    //isLazy: true
    }):"";
    mapPTS=rt==="amkn_blog_posts"?bgonmap.push({
        title: ttl, 
        key: id,
        url: './?p='+cid,
        hideCheckbox: true,
        unselectable: true,
        select: false,
        icon: '../../../../images/amkn_blog_posts-mini.png'
    //isLazy: true
    }):"";
    mapPTS=rt==="biodiv_cases"?bdonmap.push({
        title: ttl, 
        key: id,
        url: './?p='+cid,
        hideCheckbox: true,
        unselectable: true,
        select: false,
        icon: '../../../../images/biodiv_cases-mini.png'
    //isLazy: true
    }):"";
    mapPTS=rt==="photo_testimonials"?ptonmap.push({
        title: ttl, 
        key: id,
        url: './?p='+cid,                        
        hideCheckbox: true,
        unselectable: true,
        select: false,
        icon: '../../../../images/photo_testimonials-mini.png'
    //isLazy: true
    }):"";
    mapPTS=rt==="ccafs_activities"?actnmap.push({
        title: ttl, 
        key: id,
        url: './?p='+cid,                        
        hideCheckbox: true,
        unselectable: true,
        select: false,
        icon: '../../../../images/ccafs_activities-mini.png'
      //isLazy: true
    }):"";
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
    var results=[];
    vtonmap=[];
    cconmap=[];
    bgonmap=[];
    bdonmap=[];
    ptonmap=[];
    actnmap=[];
    dojo.forEach(dataLayer.graphics,function(graphic){
        if(extent.contains(graphic.geometry)){
            results.push(getListingContentTree(graphic.attributes.id));
          } 
    });
    var onthemap=dijit.byId('onthemap');
    onthemap.attr("title","What&#39;s on the map ("+results.length+")");    
    var rootNode = $("#cFiltersList2").dynatree("getRoot");
    var childrenNodes = rootNode.getChildren();
    
    for(i = 0; i < childrenNodes.length; i++) {
        // clean array.
        if (childrenNodes[i].data.key !== 'accord_data_layer' && childrenNodes[i].data.key !== 'accord_filter_resource_theme') {
          childrenNodes[i].removeChildren();
        }
        // add children and update the number of records on it.
        switch(childrenNodes[i].data.key) {
            case 'accord_ccafs_sites':                
                childrenNodes[i].addChild(cconmap);
                childrenNodes[i].data.title = "CCAFS Sites ("+cconmap.length+")";
            break;
            case 'accord_video_testimonials':              
                childrenNodes[i].addChild(vtonmap);                
                childrenNodes[i].data.title = "Videos ("+vtonmap.length+")";                
            break;
            case 'accord_amkn_blog_posts':
                childrenNodes[i].addChild(bgonmap);
                childrenNodes[i].data.title = "Blog Posts ("+bgonmap.length+")";
            break;
            case 'accord_biodiv_cases':
                childrenNodes[i].addChild(bdonmap);               
                childrenNodes[i].data.title = "Agrobiodiversity Cases ("+bdonmap.length+")";
            break;
            case 'accord_photo_testimonials':
                childrenNodes[i].addChild(ptonmap);                
                childrenNodes[i].data.title = "Photo Sets ("+ptonmap.length+")";
            break;
            case 'accord_ccafs_activities':
                childrenNodes[i].addChild(actnmap);                
                childrenNodes[i].data.title = "Activities ("+actnmap.length+")";
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
function createDataLayersBranch () {
  var nodeDataLayer = $("#cFiltersList2").dynatree("getTree").getNodeByKey("accord_data_layer");
  var ly = '';
  var children = nodeDataLayer.getChildren();
  var totalLayers = 0;
  for (j = 0; j < children.length; j++) {
    soon = children[j];
    ly = soon.data.key.split("-");
    layer = new esri.layers.ArcGISDynamicMapServiceLayer(ly[2]);
    layer.id = ly[0];      
    totalLayers+=buildLayerListTree (layer,ly[0],ly[1],soon);
  }
}

function findPointsInExtent(extent){
    var results=[];
    vtonmap=[];
    cconmap=[];
    bgonmap=[];
    bdonmap=[];
    ptonmap=[];
    dojo.forEach(dataLayer.graphics,function(graphic){
        if(extent.contains(graphic.geometry)){
            results.push(getListingContent(graphic.attributes.id));
        }
    });
    var onthemap=dijit.byId('onthemap');
    onthemap.attr("title","What&#39;s on the map ("+results.length+")");
    dojo.byId("onmap_ccafs_sites").innerHTML="<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>"+cconmap.join("")+"<ul></tr></td></tbody></table>";
    dojo.byId("onmap_video_testimonials").innerHTML="<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>"+vtonmap.join("")+"<ul></tr></td></tbody></table>";
    dojo.byId("onmap_amkn_blog_posts").innerHTML="<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>"+bgonmap.join("")+"<ul></tr></td></tbody></table>";
    dojo.byId("onmap_biodiv_cases").innerHTML="<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>"+bdonmap.join("")+"<ul></tr></td></tbody></table>";
    dojo.byId("onmap_photo_testimonials").innerHTML="<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>"+ptonmap.join("")+"<ul></tr></td></tbody></table>";
    var ccTx=dijit.byId('accord_ccafs_sites');
    var vtTx=dijit.byId('accord_video_testimonials');
    var bpTx=dijit.byId('accord_amkn_blog_posts');
    var bcTx=dijit.byId('accord_biodiv_cases');
    var ptTx=dijit.byId('accord_photo_testimonials');
    ccTx.attr("title","Sites ("+cconmap.length+")");
    vtTx.attr("title","Videos ("+vtonmap.length+")");
    bpTx.attr("title","Blog Posts ("+bgonmap.length+")");
    bcTx.attr("title","Agrobiodiversity Cases ("+bdonmap.length+")");
    ptTx.attr("title","Photo Sets ("+ptonmap.length+")");
}
function setTrans(value){
    var cL=map.getLayer(visLyr);
    if(cL!=null)
    {
        cL.setOpacity(value);
    }
}
function findPointsInPolygon(extent,evt){
    var results=[];
    dojo.forEach(dataLayer.graphics,function(graphic){
        if(extent.contains(graphic.geometry)){
            results.push(getListingContent(graphic.attributes.id));
        }
    });
    cPx=new esri.geometry.Point(map.toMap(evt.screenPoint).x,map.toMap(evt.screenPoint).y,map.spatialReference);
    var ttContent="<span class='blockNoWrap'>At this location ("+results.length+") <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='zoomToCtxt();'><a>Zoom here</a></button> <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='cPop();'><a>Close</a></button></span>";
    ttContent+="<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>"+results.join("")+"<ul></tr></td></tbody></table>";
    hQuery.setContent(ttContent);
    dojo.style(hQuery.domNode,"opacity",1);
    dijit.popup.open({
        popup:hQuery,
        x:evt.pageX,
        y:evt.pageY
    });
}
function getItemsAtLocation(sPtX,sPtY,evt)
{
    var sPt1=new esri.geometry.Point(sPtX-20,sPtY+20);
    var sPt2=new esri.geometry.Point(sPtX+20,sPtY+20);
    var sPt3=new esri.geometry.Point(sPtX+20,sPtY-20);
    var sPt4=new esri.geometry.Point(sPtX-20,sPtY-20);
//    hoverLayer=new esri.layers.GraphicsLayer();    
//    hoverLayer.remove(polyGraphic);
    hoverLayer.clear();
    points=[map.toMap(sPt1),map.toMap(sPt2),map.toMap(sPt3),map.toMap(sPt4),map.toMap(sPt1)];
    var polygon=new esri.geometry.Polygon();
    polygon.addRing(points);
    polygon.spatialReference=new esri.SpatialReference({
        wkid:102100
    });
    var gs=new esri.symbol.SimpleFillSymbol().setStyle(esri.symbol.SimpleFillSymbol.STYLE_SOLID);
    polyGraphic=new esri.Graphic(polygon,gs);   
    hoverLayer.add(polyGraphic);  
    dojo.connect(hoverLayer,"onClick",function(){
      var results=[];      
      dojo.forEach(dataLayer.graphics,function(graphic){
          if(polygon.getExtent().contains(graphic.geometry)){
              results.push(getListingContent(graphic.attributes.id));
          }
      });
//      alert(results.length);
      cPx=new esri.geometry.Point(map.toMap(evt.screenPoint).x,map.toMap(evt.screenPoint).y,map.spatialReference);
      var ttContent="<span class='blockNoWrap'>At this location ("+results.length+") <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='zoomToCtxt();'><a>Zoom here</a></button> <button dojoType='dijit.form.Button' type='submit' class='checkCtrls amknButton' onClick='cPop();'><a>Close</a></button></span>";
      ttContent+="<table style='width:100%;'><tbody><tr><td><ul class='homebox-list zoom_in-list'>"+results.join("")+"<ul></tr></td></tbody></table>";
      hQuery.setContent(ttContent);
      dojo.style(hQuery.domNode,"opacity",1);
      dijit.popup.open({
          popup:hQuery,
          x:evt.pageX,
          y:evt.pageY
      });
//      dojo.connect(hQuery,"onMouseOut",cPop);
    });
//    findPointsInPolygon(polygon.getExtent(),evt);
}
var addedLayers=[];

/**function in charge of paint the list of layers
 * @function buildLayerList
 * @deprecated buildLayerListTree() replace it**/
function buildLayerList(layer,lID,layerName,single){
    addedLayers.push(layerName);
    layer.setVisibility(false);
    layer.setImageTransparency(true,false);
    var singleLyr=single==null?-1:single;
    var lyrH="";
    var checked="";
    var tmp="";
    var items=dojo.map(layer.layerInfos,function(info,index){
        checked=(((typeof vLyr!="undefined")&&vLyr!="")&&(vLyr.split("|")[0]==layerName)&&(vLyr.split("|")[2]==info.id))?" checked=\"checked\"":"";
        if(singleLyr==-1){
            bf=info.parentLayerId==-1?"<li class='l1'>":"<li class='l2'>";
            af=info.parentLayerId==-1?"</li>":"</li>";
            if((info.parentLayerId==-1&&info.subLayerIds==null)||(info.parentLayerId!=-1&&info.subLayerIds==null)){
                lyrH+=bf+"<input"+checked+" name='aLayer' type='radio' class='list_item_"+lID+"' id='"+info.id+"' onclick='updateLayerVisibility("+lID+", \""+layer.id+"\");' /><label for='"+info.id+"'>"+info.name+"</label>"+af;
            }else{
                lyrH+=bf+"<b>"+info.name+"</b>"+af;
            }
        }
        else{
            if(info.id==singleLyr){
                bf=info.parentLayerId==-1?"<li class='l1'>":"<li class='l2'>";
                af=info.parentLayerId==-1?"</li>":"</li>";
                lyrH+=bf+"<input"+checked+" name='aLayer' type='radio' class='list_item_"+lID+"' id='"+info.id+"' onclick='updateLayerVisibility("+lID+", \""+layer.id+"\");' /><label for='"+info.id+"'>"+info.name+"</label>"+af;
            }
        }
    });
    if(((typeof vLyr!="undefined")&&vLyr!="")&&fUd==false&&vLyr.split("|")[0]==layerName){
        fUd=true;
        visible=[];
        visible.push(vLyr.split("|")[2]);
        visLyr=layerName;
        layer.setVisibility(true);
        layer.setVisibleLayers(visible);
        dijit.byId('cFiltersList').selectChild(dijit.byId('accord_legend'));
        dojo.addClass(document.getElementById("layerbt_"+layerName),"sldMenu");
        map.centerAt(map.extent.getCenter());
    }
    return"<ul class='homebox-list zoom_in-list'>"+tmp+lyrH+"</ul>";
}

/**function in charge of paint the list of layers
 * @argument {esri.layers} layer description
 * @argument {String} layerName Layer's name
 * @argument {object} soon it is an object of a tree's branch (child)
 * @argument {int} single description
 * @return {void} 
 * @author Camilo Rodriguez email: c.r.sanchez@cgiar.org
**/
function buildLayerListTree(layer,layerName,single,soon) {
    addedLayers.push(layerName);
    layer.setVisibility(false);
    layer.setImageTransparency(true,false);
    single=single=='null'?null:single;
    var singleLyr=single==null?-1:single;   
    var child =[];
    var checked=false;
//    soon.data.hideCheckbox = false;
//    ly = soon.data.key.split("-");
    setTimeout(function(){
    for ($i=0;$i<layer.layerInfos.length;$i++) {
      ly = soon.data.key.split("-");
//    dojo.map(layer.layerInfos,function(info){
        if(singleLyr==-1){
            if ((ly[3] == 14 && layer.layerInfos[$i].id == 26) || (ly[3] == 14 && layer.layerInfos[$i].id == 25) || (ly[3] == 21 && layer.layerInfos[$i].id == 0)) {
              
            } else if((layer.layerInfos[$i].parentLayerId==-1&&layer.layerInfos[$i].subLayerIds==null)||(layer.layerInfos[$i].parentLayerId!=-1&&layer.layerInfos[$i].subLayerIds==null)){                
                child.push({
                  title: layer.layerInfos[$i].name,
                  key: layer.id+'|'+ly[3]+'|'+layer.layerInfos[$i].id,
//                  url: './?p='+cid,
//                  hideCheckbox: true,
                  select: checked,
                  icon: '../../../../images/map_icon.png'
                });
            }else{
              child.push({
                  title: "<h4>"+layer.layerInfos[$i].name+"</h4>",
//                  isFolder: true,
//                  key: layer.layerInfos[$i].id
                  icon: '../../../../images/data_layersM.png',
                  hideCheckbox: true,
                  unselectable: true,
//                  icon: '../../../../images/map_icon.png'
                });
              //Here comes the title or header layer's group
            }
        } else {
            if(layer.layerInfos[$i].id==singleLyr) {                
                child.push({
                  title: layer.layerInfos[$i].name,                  
                  key: layer.id+'|'+ly[3]+'|'+layer.layerInfos[$i].id,
//                  url: './?p='+cid,
//                  hideCheckbox: true,
                  select: checked,
                  icon: '../../../../images/map_icon.png'
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
      var vLyrArray = (typeof vLyr!=="undefined")?vLyr.split(","):new Array();
      for ($j=0;$j<vLyrArray.length;$j++) {
        if($("#cFiltersList2").dynatree("getTree").getNodeByKey(vLyrArray[$j]) != null) {
          $("#cFiltersList2").dynatree("getTree").getNodeByKey(vLyrArray[$j]).select(true);
          $("#cFiltersList2").dynatree("getTree").getNodeByKey(vLyrArray[$j]).getParent().expand(true);
          $("#cFiltersList2").dynatree("getTree").getNodeByKey(vLyrArray[$j]).getParent().getParent().expand(true);
        }
      }

      soon.data.title = soon.data.title+" ("+child.length+")";
      if (child.length === 0) soon.data.hideCheckbox = true;
    },1000);

    if(((typeof vLyr!="undefined")&&vLyr!="")&&fUd==false&&vLyr.split("|")[0]==layerName){
        fUd=true;
        visible=[];
        visible.push(vLyr.split("|")[2]);
        visLyr=layerName;
        layer.setVisibility(true);
        layer.setVisibleLayers(visible);
        dijit.byId('cFiltersList').selectChild(dijit.byId('accord_legend'));
        dojo.addClass(document.getElementById("layerbt_"+layerName),"sldMenu");
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
function updateLayerVisibilityTree(node,flag) {
    var ly = node.data.key.split("|");    
    if (flag) {
      unselectCheck(node);
      unselectCheckParents(node);  
    }
    lyrID = ly[0];
    lID = ly[1];
    if(map) var cLyr=map.getLayer(ly[0]);
    
//    (typeof visLyr!="undefined")?map.getLayer(visLyr).setVisibility(false):"";
//    (typeof visLyr!="undefined")?dojo.removeClass(document.getElementById(visLyr+"_label"),"sldMenu"):"";
//    (typeof visLyr!="undefined")?dojo.removeClass(document.getElementById("layerbt_"+visLyr),"sldMenu"):"";
    if(cLyr!=null) {
      cLyr.setVisibility(false);
        dijit.byId('tslider').setValue(cLyr.opacity*100);
    }
    visLyr=lyrID;
    vLyr="";    
    visible=[];
    visible.push(ly[2]);
//    dojo.forEach(inputs,function(input){
//        if(input.checked){
//            visible.push(input.id);
//            vLyr=lyrID+"|"+lID+"|"+input.id;
//        }
//    });
    if(visible.length===0){
        visible.push(-1);
    }
    if (flag && cLyr!=null) {
      (visible.length!=-1)?cLyr.setVisibility(true):cLyr.setVisibility(false);    
      (visible.length!=-1)?cLyr.setVisibleLayers(visible):"";
    }
    var deltLyr;
    clearTimeout(deltLyr);
    deltLyr=setTimeout(function(){
        map.centerAt(map.extent.getCenter());
        rLegend();
    },1000);
//    dojo.hasClass(document.getElementById("onthemap"),"dojoxExpandoClosed")?dijit.byId('onthemap').toggle():"";
//    dijit.byId('cFiltersList').selectChild(dijit.byId('accord_legend'));
}

function unselectCheck(node) {
  tmp = node.getNextSibling();
  while(tmp) {
    tmp.select(false);
    tmp = tmp.getNextSibling();
  }
  tmp = node.getPrevSibling();
  while(tmp) {
    tmp.select(false);
    tmp = tmp.getPrevSibling();
  }
}

function unselectCheckParents(node) {
  parent = node.getParent();
  tmp = parent.getNextSibling();
  while(tmp) {
    children = tmp.getChildren();
    if(children!==null) {
      for(var i=0, l=children.length; i<l; i++){
        children[i].select(false);
      }
    }
    tmp = tmp.getNextSibling();
  }
  tmp = parent.getPrevSibling();
  while(tmp) {
    children = tmp.getChildren();
    if(children!==null) {
      for(var i=0, l=children.length; i<l; i++){
        children[i].select(false);
      }
    }
    tmp = tmp.getPrevSibling();
  }
}

function updateLayerVisibility(lID,lyrID){
    var inputs=dojo.query(".list_item_"+lID),input;
    var cLyr=map.getLayer(lyrID);
    cLyr.setVisibility(false);
    (typeof visLyr!="undefined")?map.getLayer(visLyr).setVisibility(false):"";
    (typeof visLyr!="undefined")?dojo.removeClass(document.getElementById(visLyr+"_label"),"sldMenu"):"";
    (typeof visLyr!="undefined")?dojo.removeClass(document.getElementById("layerbt_"+visLyr),"sldMenu"):"";
    if(cLyr!=null)

    {
        dijit.byId('tslider').setValue(cLyr.opacity*100);
    }
    visLyr=lyrID;
    vLyr="";

    visible=[];
    dojo.forEach(inputs,function(input){
        if(input.checked){
            visible.push(input.id);
            vLyr=lyrID+"|"+lID+"|"+input.id;
        }
    });
    if(visible.length===0){
        visible.push(-1);
    }
    (visible.length!=-1)?cLyr.setVisibility(true):cLyr.setVisibility(false);
    (lID!=null)?dojo.addClass(document.getElementById(lyrID+"_label"),"sldMenu"):dojo.removeClass(document.getElementById(lyrID+"_label"),"sldMenu");
    (visible.length!=-1)?cLyr.setVisibleLayers(visible):"";
    var tpp=0;
    for(var al=0;al<addedLayers.length;al++)

    {
            if(dojo.hasClass(document.getElementById(addedLayers[al]+"_label"),"sldMenu")){
                tpp++;
            }
        }
    (tpp>0)?dojo.addClass(document.getElementById("rsLayers_label"),"sldMenu"):dojo.removeClass(document.getElementById("rsLayers_label"),"sldMenu");
    var deltLyr;
    clearTimeout(deltLyr);
    deltLyr=setTimeout(function(){
        map.centerAt(map.extent.getCenter());
        rLegend();
    },1000);
    dojo.hasClass(document.getElementById("onthemap"),"dojoxExpandoClosed")?dijit.byId('onthemap').toggle():"";
    dijit.byId('cFiltersList').selectChild(dijit.byId('accord_legend'));
}
function updateInitLyr(lID,lyrID,id){
    var cLyr=map.getLayer(lyrID);
    cLyr.setVisibility(false);
    (typeof visLyr!="undefined")?map.getLayer(visLyr).setVisibility(false):"";
    (typeof visLyr!="undefined")?dojo.removeClass(document.getElementById(visLyr+"_label"),"sldMenu"):"";
    visLyr=lyrID;
    vLyr="";
    visible=[];
    visible.push(id);
    vLyr=lyrID+"|"+lID+"|"+id;
    (visible.length!=-1)?cLyr.setVisibility(true):cLyr.setVisibility(false);
    (lID!=null)?dojo.addClass(document.getElementById(lyrID+"_label"),"sldMenu"):dojo.removeClass(document.getElementById(lyrID+"_label"),"sldMenu");
    (visible.length!=-1)?cLyr.setVisibleLayers(visible):"";
    var tpp=0;
    for(var al=0;al<addedLayers.length;al++)

    {
            if(dojo.hasClass(document.getElementById(addedLayers[al]+"_label"),"sldMenu")){
                tpp++;
            }
        }
    (tpp>0)?dojo.addClass(document.getElementById("rsLayers_label"),"sldMenu"):dojo.removeClass(document.getElementById("rsLayers_label"),"sldMenu");
    map.centerAt(map.extent.getCenter());
}
var mp={};

mp.lMap=function(){
    var lMapTimer;
    clearTimeout(lMapTimer);
    lMapTimer=setTimeout(function(){
        initMap();
    },500);
}
dojo.addOnLoad(function(){
    mp.lMap();
});
