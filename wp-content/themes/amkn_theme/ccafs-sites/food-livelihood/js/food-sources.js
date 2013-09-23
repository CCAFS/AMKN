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
var shortage = [];
var noShortage = [];
shortage[0] = parseFloat(json[0].jan);
shortage[1] = parseFloat(json[0].feb);
shortage[2] = parseFloat(json[0].mar);
shortage[3] = parseFloat(json[0].apr);
shortage[4] = parseFloat(json[0].may);
shortage[5] = parseFloat(json[0].jun);
shortage[6] = parseFloat(json[0].jul);
shortage[7] = parseFloat(json[0].ago);
shortage[8] = parseFloat(json[0].sep);
shortage[9] = parseFloat(json[0].oct);
shortage[10] = parseFloat(json[0].nov);
shortage[11]= parseFloat(json[0].dec);

shortage.forEach(function(entry) {
   noShortage.push(100-entry); 
});

$(function () {
        $('#container-chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul','Ago','Sep','Oct','Nov','Dec']
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    stacking: 'percent'
                }
            },
                series: [{
                color: '#4f81bd',      
                name: 'Shortage',
                data: shortage
            }, {
                color: '#00b050',
                name: 'No shortage',
                data: noShortage
            }]
        });
    });
    