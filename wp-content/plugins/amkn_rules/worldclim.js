dojo.require("esri.tasks.gp");
dojo.require("dojo.parser");
dojo.require("dojo.data.ItemFileReadStore");
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
dojo.require("dijit.layout.TabContainer");
dojo.require("dijit.Menu");
dojo.require("dojox.layout.ExpandoPane");
dojo.require("dijit.Tooltip");
dojo.require("dojox.form.BusyButton");

var webserver = null,
    worldclimPath = null,
    marksimPath = null,
    gcm4dataPath = null,
    geoprocessorServer = null,
    ge = null,
    lang, title, copyright, developer, geocoder = null,
    userPlacemark = null,
    globePlacemark = null,
    terrainPlacemark = null,
    buildingsPlacemark = null,
    currentFile = null,
    arrayDATE = [],
    arraySRAD = [],
    arrayTMAX = [],
    arrayTMIN = [],
    arrayRAIN = [],
    imgRAIN = null,
    imgSRAD = null,
    imgTEMP = null,
    imgTMAX = null,
    imgTMIN = null,
    clouds_lyr = null,
    jsonStore = null,
    Place = null,
    NumRep = null,
    OutDir = null;

function setupconfig() {
    xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.open("GET", "/wp-content/plugins/amkn_rules/worldclim_config.xml", false);
    xmlhttp.send();
    xmlDoc = xmlhttp.responseXML;
    webserver = xmlDoc.getElementsByTagName("Webserver")[0].childNodes[0].nodeValue;
    worldclimPath = xmlDoc.getElementsByTagName("WorldClim")[0].childNodes[0].nodeValue;
    marksimPath = xmlDoc.getElementsByTagName("MarkSim")[0].childNodes[0].nodeValue;
    gcm4dataPath = xmlDoc.getElementsByTagName("GCM4data")[0].childNodes[0].nodeValue;
    geoprocessorServer = xmlDoc.getElementsByTagName("Geoprocessor")[0].childNodes[0].nodeValue;
    MarkSimGCMPathDescription = {
        PATH_TO_WORLDCLIM: worldclimPath,
        PATH_TO_MARKSIM: marksimPath,
        PATH_TO_GCM: gcm4dataPath
    }
}
function el(a) {
    return document.getElementById(a);
}
function init() {
    setupconfig();
    gp = new esri.tasks.Geoprocessor(geoprocessorServer);
    initYearofSimulation();
    initNumberofReplications();
}


function initYearofSimulation() {
    var a = document.forms.input_form.yearsimulation;
    if (document.forms.input_form.wcbaseline.checked) a.options[a.options.length] = new Option(1975, 1975);
    else for (var b = 2010; b <= 2095; b++) a.options[a.options.length] = new Option(b, b)
}
function initNumberofReplications() {
    for (var a = document.forms.input_form.numrep, b = 1; b <= 99; b++) a.options[a.options.length] = new Option(b, b)
}

function initFileListReplications() {
    var a = el("filelist"),
        b = "<div id='linktofile' class='filelist'>";
    a.options.length = 0;
    el("filelistlinks").innerHTML = b;
    for (var c = parseInt(document.forms.input_form.numrep.value), d = 1; d <= c; d++) if (d < 10) {
        a.options[a.options.length] = new Option("CLIM0" + d + "01", "CLIM0" + d + "01");
        b += "<a href=\"javascript:showClimateFileData('CLIM0" + d + "01');\">CLIM0" + d + "01</a> | "
    } else {
        a.options[a.options.length] = new Option("CLIM" + d + "01", "CLIM" + d + "01");
        b += "<a href=\"javascript:showClimateFileData('CLIM" + d + "01');\">CLIM" + d + "01</a> | "
    }
    el("filelistlinks").innerHTML = b
}

function get_scenario_value() {
    for (var a = 0; a < document.input_form.scenario.length; a++) if (document.input_form.scenario[a].checked) return document.input_form.scenario[a].value
}
function SelectAllInputboxText(a) {
    document.getElementById(a).focus();
    document.getElementById(a).select()
}

function changeWorldClimYear(a) {
    var b = document.forms.input_form.yearsimulation;
    if (a.checked) {
        b.options.length = 0;
        b.options[0] = new Option(1975, 1975)
    } else {
        b.options.length = 0;
        for (a = 2010; a <= 2095; a++) b.options[b.options.length] = new Option(a, a)
    }
}

function RunModel() {
    el("td_results").style.display = "none";
    el("wcResults").style.display = "none";
    el("wcNoResults").style.display = "none";

    var a = parseFloat(document.forms.input_form.latitude.value),
        b = parseFloat(document.forms.input_form.longitude.value);
    parseFloat(document.forms.input_form.altitude.value);
    var c = document.forms.input_form.place.value,
        d = document.forms.input_form.model.value,
        e = get_scenario_value(),
        f = document.forms.input_form.yearsimulation.value,
        g = document.forms.input_form.wcbaseline.checked;
    console.log(g);
    f = g ? "1975" : f;
    g = document.forms.input_form.numrep.value;
    var k = document.forms.input_form.seed.value;
    if (e != "a1" && e != "a2" && e != "b1") alert("Please select a valid Scenario");
    else if (isNaN(a) || isNaN(b)) alert("Please enter a valid number for Latitude or Longitude");
    else if (c == null || c == "") alert("Please enter a valid name for Place");
    else {
        if (c) for (i = 0; i < c.length; i++) if (c.charAt(i) === "\\" || c.charAt(i) === "/" || c.charAt(i) === ":" || c.charAt(i) === "*" || c.charAt(i) === "?" || c.charAt(i) === '"' || c.charAt(i) === "<" || c.charAt(i) === ">" || c.charAt(i) === "|") {
            alert("A place name can't contain any of the following characters:\n \\ / : * ? \" < > |");
            return
        }

        initFileListReplications();
        //el("runmodel").innerHTML = "<img src='"+document.getElementById("loadingImg").src+"' />";
        //dijit.byId("BtnRun").set("disabled", "disabled");
        computeMarkSimGCMService(a, b, c, d, e, f, g, k)
    }
}

function updateModelSelected() {
    switch (document.forms.input_form.model.value) {
    case "bcc":
        el("modeldescript").innerHTML = "Furevik, T., et al. 2003. Description and evaluation of the Bergen climate model: ARPEGE coupled with MICOM. Clim. Dyn., 21, 27\u201351";
        break;
    case "cnr":
        el("modeldescript").innerHTML = "D\u00e9qu\u00e9, M., et al. 1994. The ARPEGE/IFS atmosphere model: a contribution to the French community climate modeling. Clim. Dynam. 10, 249-266.";
        break;
    case "csi":
        el("modeldescript").innerHTML = "Gordon et al. 2002. The CSIRO Mk3 Climate System Model, <a href='http://www.cmar.csiro.au/e-print/open/gordon_2002a.pdf' target='_new'>www.dar.csiro.au/ publications/ Gordon_2002a.pdf</a>";
        break;
    case "ech":
        el("modeldescript").innerHTML = "Roeckner, E., et al. 2003. The Atmospheric General Circulation Model ECHAM5. Part I: Model Description. MPI Report 349, Max Planck Institute for Meteorology, Hamburg, Germany, 127 pp.";
        break;
    case "had":
        el("modeldescript").innerHTML = "Gordon, C., et al., 2000. The simulation of SST, sea ice extents and ocean heat transports in a version of the Hadley Centre coupled model without flux adjustments. Clim. Dyn., 16, 147\u2013168.";
        break;
    case "inm":
        el("modeldescript").innerHTML = "Institute for Numerical Mathematics, Moscow, Russia. Diansky & Volodin, 2002. Izvestia Atmospheric and Oceanic Physics V.38, N6, 824-840.";
        break;
    case "mir":
        el("modeldescript").innerHTML = "K-1 Model Developers, 2004. K-1 Coupled Model (MIROC) Description. K-1 Technical Report 1, Hasumi, H., Emori, S. (Eds.), Center for Climate System Research, University of Tokyo, Tokyo, Japan, <a href='http://www.ccsr.u-tokyo.ac.jp/kyosei/hasumi/MIROC/tech-repo.pdf' target='_new'>http://www.ccsr.u-tokyo. ac.jp/kyosei/hasumi/ MIROC/tech-repo.pdf.</a>";
        break;
    case "avr":
        el("modeldescript").innerHTML = "Ensemble mean for CNRM-CM3, CSIRO-Mk3_5, ECHam5 and MIROC3.2. Note. The other three models were fitted to different time slices and could not be included.";
        break;
    default:
        console.log("Model not found");
        el("modeldescript").innerHTML = ""
    }
}
function showHideResults() {
    var a = el("td_results");
    a.style.display = a.style.display == "" ? "none" : ""
}

function showClimateFileData(a) {
    el("info").innerHTML = "<img src='images/loading.gif'/> <h2>Loading...</h2>";
    currentFile = a;
    OutDir && OutDir != "" ? clientSideInclude("ifarchWTG", "/wp-content/plugins/amkn_rules/arc_gis.php?"+OutDir + "/" + a + ".WTG") : console.log("Output Directory was not found!")
}
function showClimateFileChart() {}
function onChangeSelectClimateFile() {
    var a = el("filelist").value;
    showClimateFileData(a)
}

function showChart(a) {
    el("info").innerHTML = "<img src='images/loading.gif'/> <h2>Loading...</h2>";
    switch (a) {
    case "RAIN":
        el("info").innerHTML = imgRAIN;
        break;
    case "TEMP":
        el("info").innerHTML = imgTEMP;
        break;
    case "TMAX":
        el("info").innerHTML = imgTMAX;
        break;
    case "TMIN":
        el("info").innerHTML = imgTMIN;
        break;
    case "SRAD":
        el("info").innerHTML = imgSRAD;
        break;
    default:
        el("info").innerHTML = "<img src='images/loading.gif'/> <h2>Loading...</h2>"
    }
}

function createChartRAIN() {
    var a = [];
    for (i = 0; i < arrayRAIN.length; i++) a.push(Math.round(arrayRAIN[i]));
    var b = "<img id='imgChartRain' src=\"";
    b += "http://chart.apis.google.com/chart?chxt=x,y,x&amp;chs=550x270&amp;chco=0B0B61&amp;";
    b += "chdl=RAIN(mm)&amp;chg=10,20&amp;";
    b += "chxr=1,0," + numberRound(arrayRAIN.max(), 10) + ",10&amp;cht=lc&amp;";
    b += "chds=0," + numberRound(arrayRAIN.max(), 10) + "&amp;";
    b += "chtt=Daily+Rainfall+(" + currentFile + ".WTG)| Replication+" + currentFile.substring(4, 6) + "&amp;";
    b += "chts=0B0B61,15&amp;";
    b += "chxl=0:|1|20|40|60|80|100|120|140|160|200|220|240|260|280|300|320|340|365|";
    b += "2:||Time (days)|&amp;";
    b += "chxs=2,424242,13,0,t&amp;";
    b += "chf=bg,s,EFEFEF&amp;";
    var c = numberRound(arrayRAIN.max(), 10);
    a = "chd=" + simpleEncode(a, c);
    b += a + '"';
    b += "/>";
    if (el("rdRAIN").checked) el("info").innerHTML = b;
    imgRAIN = b
}

function createChartSRAD() {
    var a = [];
    for (i = 0; i < arraySRAD.length; i++) a.push(Math.round(arraySRAD[i]));
    var b = "<img id='imgChartSRad' src=\"";
    b += "http://chart.apis.google.com/chart?chxt=x,y,x&amp;chs=550x270&amp;chco=FE9A2E&amp;";
    b += "chdl=SRAD(MJ/m2)&amp;chg=9.090909,33&amp;";
    b += "chxr=1,0," + numberRound(arraySRAD.max(), 10) + ",10&amp;cht=lc&amp;";
    b += "chds=0," + numberRound(arraySRAD.max(), 10) + "&amp;";
    b += "chtt=Radiation+(" + currentFile + ".WTG)| Replication+" + currentFile.substring(4, 6) + "&amp;";
    b += "chts=FE9A2E,15&amp;";
    b += "chxl=0:|1|20|40|60|80|100|120|140|160|200|220|240|260|280|300|320|340|365|";
    b += "2:||Jan||Feb||Mar||Apr||May||Jun||Jul||Aug||Sep||Oct||Nov||Dec|&amp;";
    b += "chxs=2,424242,13,0,t&amp;";
    b += "chf=bg,s,EFEFEF&amp;";
    var c = numberRound(arraySRAD.max(), 10);
    a = "chd=" + simpleEncode(a, c);
    b += a + '"';
    b += "/>";
    if (el("rdSRAD").checked) el("info").innerHTML = b;
    imgSRAD = b
}

function createChartTEMP() {
    var a = [],
        b = [];
    for (i = 0; i < arrayTMAX.length; i++) a.push(Math.round(arrayTMAX[i] + Math.abs(numberRound(arrayTMIN.min(), 10))));
    for (i = 0; i < arrayTMIN.length; i++) b.push(Math.round(arrayTMIN[i] + Math.abs(numberRound(arrayTMIN.min(), 10))));
    var c = "<img id='imgChartTemp' src=\"";
    c += "http://chart.apis.google.com/chart?chxt=x,y,x&amp;chs=550x270&amp;chco=FF0000,5FB404&amp;cht=lc&amp;";
    c += "chdl=TMAX(C) | TMIN(C)&amp;chg=10,20,1,5&amp;";
    c += "chxr=1," + numberRound(arrayTMIN.min(), 10) + "," + numberRound(arrayTMAX.max(), 10) + ",10&amp;";
    c += "chds=" + numberRound(b.min(), 10) + "," + numberRound(a.max(), 10) + "&amp;";
    c += "chtt=Temperature+(" + currentFile + ".WTG)| Replication+" + currentFile.substring(4, 6) + "&amp;";
    c += "chts=000000,15&amp;";
    c += "chxl=0:|1|20|40|60|80|100|120|140|160|200|220|240|260|280|300|320|340|365|";
    c += "2:||Time (days)|&amp;";
    c += "chxs=2,424242,13,0,t&amp;";
    c += "chf=bg,s,EFEFEF&amp;";
    var d = numberRound(a.max(), 10);
    a = simpleEncode(a, d);
    b = simpleEncode(b, d);
    b = "chd=" + a + "," + b.substring(2);
    c += b + '"';
    c += "/>";
    if (el("rdTEMP").checked) el("info").innerHTML = c;
    imgTEMP = c
}

function createChartTMAX() {
    var a = "<img id='imgChartTMax' src=\"";
    a += "http://chart.apis.google.com/chart?chxt=x,y,x&amp;chs=550x270&amp;chco=FF0000&amp;";
    a += "chdl=TMAX(C)&amp;chg=9.090909,33&amp;";
    a += "chxr=1," + numberRound(arrayTMAX.min(), 10) + "," + numberRound(arrayTMAX.max(), 10) + ",10&amp;cht=lc&amp;";
    a += "chds=" + numberRound(arrayTMAX.min(), 10) + "," + numberRound(arrayTMAX.max(), 10) + "&amp;";
    a += "chtt=Maximun+Temperature+(" + currentFile + ".WTG)| Replication+" + currentFile.substring(4, 6) + "&amp;";
    a += "chts=FF0000,15&amp;";
    a += "chxl=0:|1|20|40|60|80|100|120|140|160|200|220|240|260|280|300|320|340|365|";
    a += "2:||Time (days)|&amp;";
    a += "chxs=2,424242,13,0,t&amp;";
    a += "chf=bg,s,EFEFEF&amp;";
    var b = "chd=t:";
    for (i = 0; i < arrayTMAX.length; i++) b += i != arrayTMAX.length - 1 ? arrayTMAX[i] + "," : arrayTMAX[i];
    a += b + '"';
    a += "/>";
    if (el("rdTMAX").checked) el("info").innerHTML = a;
    imgTMAX = a
}

function createChartTMIN() {
    var a = "<img id='imgChartTMin' src=\"";
    a += "http://chart.apis.google.com/chart?chxt=x,y,x&amp;chs=550x270&amp;chco=5FB404&amp;";
    a += "chdl=TMIN(C)&amp;chg=9.090909,33&amp;";
    a += "chxr=1," + numberRound(arrayTMIN.min(), 10) + "," + numberRound(arrayTMIN.max(), 10) + ",10&amp;cht=lc&amp;";
    a += "chds=" + numberRound(arrayTMIN.min(), 10) + "," + numberRound(arrayTMIN.max(), 10) + "&amp;";
    a += "chtt=Minimun+Temperature+(" + currentFile + ".WTG)| Replication+" + currentFile.substring(4, 6) + "&amp;";
    a += "chts=5FB404,15&amp;";
    a += "chxl=0:|1|20|40|60|80|100|120|140|160|200|220|240|260|280|300|320|340|365|";
    a += "2:||Time (days)|&amp;";
    a += "chxs=2,424242,13,0,t&amp;";
    a += "chf=bg,s,EFEFEF&amp;";
    var b = "chd=t:";
    for (i = 0; i < arrayTMIN.length; i++) b += i != arrayTMIN.length - 1 ? arrayTMIN[i] + "," : arrayTMIN[i];
    a += b + '"';
    a += "/>";
    if (el("rdTMIN").checked) el("info").innerHTML = a;
    imgTMIN = a
}
function numberRound(a, b) {
    var c = 0;
    return c = a > 0 ? Math.ceil(a / b) * b : Math.ceil(a / b) * b - b
}
$(function () {
    $("#tabs").tabs()
});

function clientSideInclude(a, b) {
    var c = false;
    if (window.XMLHttpRequest) try {
        c = new XMLHttpRequest
    } catch (d) {
        c = false
    } else if (window.ActiveXObject) try {
        c = new ActiveXObject("Msxml2.XMLHTTP")
    } catch (e) {
        try {
            c = new ActiveXObject("Microsoft.XMLHTTP")
        } catch (f) {
            c = false
        }
    }
    var g = document.getElementById(a);
    if (g) if (c) {
        c.open("GET", b, false);
        c.send(null);
        processData(c.responseText);
        el("ifarchWTG").src = b;
        el("TitleFileClim").innerHTML = "<strong>(" + currentFile + ".WTG)</strong>"
    } else g.innerHTML = "Sorry, your browser does not support XMLHTTPRequest objects. This page requires Internet Explorer 5 or better for Windows, or Firefox for any system, or Safari. Other compatible browsers may also exist.";
    else alert("Bad id " + a + "passed to clientSideInclude.You need a div or span element with this id in your page.")
}
function display_column() {}

function processData(a) {
    el("info").innerHTML = "<img src='images/loading.gif'/> <h2>Loading...</h2>";
    arrayDATE = [];
    arraySRAD = [];
    arrayTMAX = [];
    arrayTMIN = [];
    arrayRAIN = [];
    var b = a.split("\n");
    for (a = 4; a < b.length; a++) {
        var c = eliminarDatosNulos(b[a].split(" "));
        if (c.length >= 4) {
            var d = c[0].trim();
            arrayDATE.push(d);
            d = c[1].trim();
            arraySRAD.push(parseFloat(d));
            d = c[2].trim();
            arrayTMAX.push(parseFloat(d));
            d = c[3].trim();
            arrayTMIN.push(parseFloat(d));
            c = c[4].trim();
            arrayRAIN.push(parseFloat(c))
        }
    }
    createChartRAIN();
    createChartSRAD();
    createChartTEMP()
}
function eliminarDatosNulos(a) {
    var b = [];
    for (i = 0; i < a.length; i++) a[i].trim() != "" && b.push(a[i]);
    return b
}
String.prototype.trim = function () {
    return this.replace(/^\s*/, "").replace(/\s*$/, "")
};
String.prototype.ltrim = function () {
    return this.replace(/^\s+/, "")
};
String.prototype.rtrim = function () {
    return this.replace(/\s+$/, "")
};
String.prototype.fulltrim = function () {
    return this.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g, "").replace(/\s+/g, " ")
};
String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1)
};
Array.prototype.max = function () {
    for (var a = this[0], b = this.length, c = 1; c < b; c++) if (this[c] > a) a = this[c];
    return a
};
Array.prototype.min = function () {
    for (var a = this[0], b = this.length, c = 1; c < b; c++) if (this[c] < a) a = this[c];
    return a
};
$(document).ready(function () {
    $(".rss-popup a").hover(function () {
        $(this).next("em").stop(true, true).animate({
            opacity: "show",
            top: "60"
        }, "slow")
    }, function () {
        $(this).next("em").animate({
            opacity: "hide",
            top: "60"
        }, "fast")
    })
});
$(function () {
//    $("#BtnRun").button();
    $("#radioCharts").buttonset()
});
var simpleEncoding = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

function simpleEncode(a, b) {
    for (var c = ["s:"], d = 0; d < a.length; d++) {
        var e = a[d];
        !isNaN(e) && e >= 0 ? c.push(simpleEncoding.charAt(Math.round((simpleEncoding.length - 1) * e / b))) : c.push("_")
    }
    return c.join("")
}
var EXTENDED_MAP = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-.",
    EXTENDED_MAP_LENGTH = EXTENDED_MAP.length;

function extendedEncode(a, b) {
    var c = "e:";
    i = 0;
    for (len = a.length; i < len; i++) {
        var d = new Number(a[i]),
            e = Math.floor(EXTENDED_MAP_LENGTH * EXTENDED_MAP_LENGTH * d / b);
        if (e > EXTENDED_MAP_LENGTH * EXTENDED_MAP_LENGTH - 1) c += "..";
        else if (e < 0) c += "__";
        else {
            d = Math.floor(e / EXTENDED_MAP_LENGTH);
            e = e - EXTENDED_MAP_LENGTH * d;
            c += EXTENDED_MAP.charAt(d) + EXTENDED_MAP.charAt(e)
        }
    }
    return c
}
function getFormattedName(a) {
    a = a.replace(/[\/\\<>"'&*:?|()]/g, "-");
    a = a.trim();
    a = a.replace(/ /gi, "_");
    if (a.length >= 25) a = a.substring(0, 25);
    return a
}

function getFileDirectory(a) {
    return a.indexOf("/") == -1 ? a.substring(0, a.lastIndexOf("\\")) : a.substring(0, a.lastIndexOf("/"))
}

function computeMarkSimGCMService(a, b, c, d, e, f, g, k) {
    var h = MarkSimGCMPathDescription.PATH_TO_WORLDCLIM,
        j = MarkSimGCMPathDescription.PATH_TO_MARKSIM,
        l = MarkSimGCMPathDescription.PATH_TO_GCM;
    Place = c = getFormattedName(c);
    NumRep = g;
    gp.submitJob({
        WorldClim_30_arc_sec_file: h,
        Path_for_MarSim_data: j,
        Path_for_GCM_data: l,
        Place_Name: c,
        Model: d,
        Scenario: e,
        Year_of_Simulation: f,
        Seed: k,
        Number_of_Replications: g,
        Site_Latitude: a,
        Site_Longitude: b,
        Return_Code: 999
    }, completeCallback, statusCallback)
}

function statusCallback(a) {
    if (a.jobStatus == "esriJobFailed") {
        console.log("Processing Job Failed. Please try again...");
        alert("Processing Job Failed. Please try again...")
    }
}

function completeCallback(a) {
    gp.getResultData(a.jobId, "Return_Code", function (b) {
        var c = b.value.toString();
    dijit.byId("BtnRun").resetTimeout();    
       
        if (b.value.toString() != "Process finished successfully") {
                    el("wcNoResults").style.display = "block";
        }else {
        gp.getResultData(a.jobId, "Summary", displayResult);
        }
    })
}

function displayResult(a) {

    el("wcResults").style.display = "block";
    el("wcNoResults").style.display = "none";
    
    if (a = a.value.url) {
        if (a.substring(0, 16) == "c:arcgisserver") a = a.replace("c:arcgisserver", "http://gismap.ciat.cgiar.org");
        a = getFileDirectory(a);
        OutDir = a + "/" + Place;
        a = a + "/" + Place + ".zip";
        el("btnDownload").innerHTML = "<h3>Data with (" + NumRep + ") replications in a zip file. Click on the icon to start download</h3><a href='" + a + "'><img src='http://gismap.ciat.cgiar.org/MarkSimGCM/images/zip-icon.jpg' style='width:80;border:0;margin:0;'></a>";
        el("td_results").style.display = "";
        currentFile = "CLIM0101";
        showClimateFileData("CLIM0101");
        el("shResults").style.display = "";
        
    } else {
        console.log("Require URL to jsonStore Failed");
    }

}
dojo.addOnLoad(init);