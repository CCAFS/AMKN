var fUd = false;
function addDataLayers()
{
    var imageParams = new esri.layers.ImageParameters();
    imageParams.transparent = true;
    var aglyr19 = new esri.layers.ArcGISDynamicMapServiceLayer("http://gismap.ciat.cgiar.org/ArcGISServer/rest/services/CCAFS/ccafs_climate/MapServer", {
        imageParameters:imageParams
    });
    aglyr19.id = "aglyr19";
    legendLayers.push({
        layer:aglyr19,
        title:''
    });

    if (aglyr19.loaded) {
        var layer19 = new dijit.TooltipDialog({
            content: buildLayerList(aglyr19, "19", "aglyr19", null)
        });
        dojo.connect(aglyr19,"onUpdateStart",showLoading);
        dojo.connect(aglyr19,"onUpdateEnd",hideLoading);     
        var layerbutton19 = new dijit.form.DropDownButton({
            label: "Layers",
            id: "aglyr19",
            dropDown: layer19
        });

        layerbutton19.openDropDown();
        layerbutton19.closeDropDown();
    
        dojo.byId("layerbt_19").appendChild(layebutton19.domNode);
        //dojo.place("<br />", dojo.byId("layercontainer_19"), "after");
        alert("cc");
    }
    else {
        dojo.connect(aglyr19, "onLoad", function(){
            var layer19 = new dijit.TooltipDialog({
                content: buildLayerList(aglyr19, "19", "aglyr19", null)
            });   
            dojo.connect(aglyr19,"onUpdateStart",showLoading);
            dojo.connect(aglyr19,"onUpdateEnd",hideLoading);        
            var layerbutton19 = new dijit.form.DropDownButton({
                label: "Layers",
                id: "aglyr19",
                dropDown: layer19
            });
            layerbutton19.openDropDown();
            layerbutton19.closeDropDown();

            dojo.byId("layerbt_19").appendChild(layerbutton19.domNode);
        //dojo.place("<br />", dojo.byId("layercontainer_19"), "after"); 
        });  
        alert("cc");
  
    }


    var aglyr15 = new esri.layers.ArcGISDynamicMapServiceLayer("http://gismap.ciat.cgiar.org/ArcGISServer/rest/services/GCP/GCPAtlas/MapServer", {
        imageParameters:imageParams
    });
    aglyr15.id = "aglyr15";
    legendLayers.push({
        layer:aglyr15,
        title:''
    });

    if (aglyr15.loaded) {
        var layer15 = new dijit.TooltipDialog({
            content: buildLayerList(aglyr15, "15", "aglyr15", null)
        });
        dojo.connect(aglyr15,"onUpdateStart",showLoading);
        dojo.connect(aglyr15,"onUpdateEnd",hideLoading);     
        var layerbutton15 = new dijit.form.DropDownButton({
            label: "Layers",
            id: "aglyr15",
            dropDown: layer15
        });

        layerbutton15.openDropDown();
        layerbutton15.closeDropDown();
    
        dojo.byId("layerbt_15").appendChild(layebutton15.domNode);
        //dojo.place("<br />", dojo.byId("layercontainer_15"), "after");
        alert("cc");
    }
    else {
        dojo.connect(aglyr15, "onLoad", function(){
            var layer15 = new dijit.TooltipDialog({
                content: buildLayerList(aglyr15, "15", "aglyr15", null)
            });   
            dojo.connect(aglyr15,"onUpdateStart",showLoading);
            dojo.connect(aglyr15,"onUpdateEnd",hideLoading);        
            var layerbutton15 = new dijit.form.DropDownButton({
                label: "Layers",
                id: "aglyr15",
                dropDown: layer15
            });
            layerbutton15.openDropDown();
            layerbutton15.closeDropDown();

            dojo.byId("layerbt_15").appendChild(layerbutton15.domNode);
        //dojo.place("<br />", dojo.byId("layercontainer_15"), "after"); 
        });  
        alert("cc");
  
    }


    var aglyr18 = new esri.layers.ArcGISDynamicMapServiceLayer("http://gismap.ciat.cgiar.org/ArcGISServer/rest/services/CCAFS/crop_adaptation/MapServer", {
        imageParameters:imageParams
    });
    aglyr18.id = "aglyr18";
    legendLayers.push({
        layer:aglyr18,
        title:''
    });

    if (aglyr18.loaded) {
        var layer18 = new dijit.TooltipDialog({
            content: buildLayerList(aglyr18, "18", "aglyr18", null)
        });
        dojo.connect(aglyr18,"onUpdateStart",showLoading);
        dojo.connect(aglyr18,"onUpdateEnd",hideLoading);     
        var layerbutton18 = new dijit.form.DropDownButton({
            label: "Layers",
            id: "aglyr18",
            dropDown: layer18
        });

        layerbutton18.openDropDown();
        layerbutton18.closeDropDown();
    
        dojo.byId("layerbt_18").appendChild(layebutton18.domNode);
        //dojo.place("<br />", dojo.byId("layercontainer_18"), "after");
        alert("cc");
    }
    else {
        dojo.connect(aglyr18, "onLoad", function(){
            var layer18 = new dijit.TooltipDialog({
                content: buildLayerList(aglyr18, "18", "aglyr18", null)
            });   
            dojo.connect(aglyr18,"onUpdateStart",showLoading);
            dojo.connect(aglyr18,"onUpdateEnd",hideLoading);        
            var layerbutton18 = new dijit.form.DropDownButton({
                label: "Layers",
                id: "aglyr18",
                dropDown: layer18
            });
            layerbutton18.openDropDown();
            layerbutton18.closeDropDown();

            dojo.byId("layerbt_18").appendChild(layerbutton18.domNode);
        //dojo.place("<br />", dojo.byId("layercontainer_18"), "after"); 
        });  
        alert("cc");
  
    }


    legend = new esri.dijit.Legend({
        map:map,
        layerInfos:legendLayers
    },"legendDiv");
}
function addInitLayers()
{
    if(((typeof vLyr != "undefined") && vLyr != "") && fUd==false && vLyr.split("|")[0]=="aglyr19"){
        fUd=true;
        updateInitLyr(vLyr.split("|")[1], vLyr.split("|")[0], vLyr.split("|")[2]);
    }
    if(((typeof vLyr != "undefined") && vLyr != "") && fUd==false && vLyr.split("|")[0]=="aglyr15"){
        fUd=true;
        updateInitLyr(vLyr.split("|")[1], vLyr.split("|")[0], vLyr.split("|")[2]);
    }
    if(((typeof vLyr != "undefined") && vLyr != "") && fUd==false && vLyr.split("|")[0]=="aglyr18"){
        fUd=true;
        updateInitLyr(vLyr.split("|")[1], vLyr.split("|")[0], vLyr.split("|")[2]);
    }
     
}