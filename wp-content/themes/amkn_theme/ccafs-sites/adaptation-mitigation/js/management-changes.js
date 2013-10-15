var json = (function() {
   var json = null;
   $.ajax({
      'async': false,
      'global': false,
      'url': $('#url-site').text(),
      'dataType': "json",
      'success': function(data) {
         json = data;
      }
   });
   return json;
})();

//var myJSONData = '[{"id":"3","bms_id":"ke01","source":"http:\/\/dvn.iq.harvard.edu\/dvn\/dv\/CCAFSbaseline\/faces\/study\/StudyPage.xhtml?globalId=hdl:1902.1\/BHS-20102011","product_name":"Maize","description":"Earlier planting"},{"id":"10","bms_id":"ke01","source":"http:\/\/dvn.iq.harvard.edu\/dvn\/dv\/CCAFSbaseline\/faces\/study\/StudyPage.xhtml?globalId=hdl:1902.1\/BHS-20102011","product_name":"Sorghum","description":"Earlier land preparation"},{"id":"13","bms_id":"ke01","source":"http:\/\/dvn.iq.harvard.edu\/dvn\/dv\/CCAFSbaseline\/faces\/study\/StudyPage.xhtml?globalId=hdl:1902.1\/BHS-20102011","product_name":"Beans","description":"None"},{"id":"14","bms_id":"ke01","source":"http:\/\/dvn.iq.harvard.edu\/dvn\/dv\/CCAFSbaseline\/faces\/study\/StudyPage.xhtml?globalId=hdl:1902.1\/BHS-20102011","product_name":"Goats","description":"None"},{"id":"15","bms_id":"ke01","source":"http:\/\/dvn.iq.harvard.edu\/dvn\/dv\/CCAFSbaseline\/faces\/study\/StudyPage.xhtml?globalId=hdl:1902.1\/BHS-20102011","product_name":"Chickens","description":"None"}]';
//console.log("<pre>" +  JSON.stringify(json, null, 4) +  "</pre>");
var parsed = JSON.parse(JSON.stringify(json, null, 4), function(k, v) {
    this.y =1;
    if (k === "product_name") 
        this.name = v; 
        return v;
});

$(function() {
    $('#container-chart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: '',
            align: 'center',
            verticalAlign: 'middle',
            y: 40
        },
        tooltip: {
            shared: true,
            useHTML: true,
            pointFormat: '{point.description}'
        },
        legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: -50,
                    style: {
                        fontWeight: 'bold',
                        color: 'white',
                        textShadow: '0px 1px 2px black'
                    }
                },
                center: ['50%', '50%']
            }
        },
        series: [{
                type: 'pie',
                name: '',
                innerSize: '50%',
                data:  parsed 
            }]
    });
});
    