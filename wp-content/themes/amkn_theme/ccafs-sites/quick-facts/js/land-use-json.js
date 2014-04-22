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


$(function () {
  if(json !=''){
    	
    	// Radialize the colors
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
		// Build the chart
        $('#container-chart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: ''
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '',
                data: [
                    ['Food',   parseFloat(json[0].food)],
                    ['Grazing', parseFloat(json[0].grazing)], 
                    ['Trees',       parseFloat(json[0].trees)],
                    ['Aquaculture',    parseFloat(json[0].aquaculture)],
                    ['Degraded',    parseFloat(json[0].degraded)],
                    ['Others', parseFloat(json[0].other)]
                ]
            }]
        });
      } else {
        $('#container-chart').append('NOT AVAILABLE');
      }
    });
    