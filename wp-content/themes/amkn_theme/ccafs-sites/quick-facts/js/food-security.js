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

$(function() {

      var greencolor = '#5cab5c';
      var colors = Highcharts.getOptions().colors,
              categories = ["More than 6 hunger months/year","5-6 hunger months/","3-4 hunger months/","1-2 hunger months/","Food all year/No hungry period"],
              name = 'Periods',
              data = [{
                  y: parseFloat(json[0].more_6)
                 
               }, {
                  y: parseFloat(json[0].from5to6)
                 
               }, {
                  y: parseFloat(json[0].from3to4)
                  
               }, {
                  y: parseFloat(json[0].from1to2)
                  
               }, {
                  y: parseFloat(json[0].none)
                  
               }];

      function setChart(name, categories, data, color) {
         chart.xAxis[0].setCategories(categories, false);
         chart.series[0].remove(false);
         chart.addSeries({
            name: name,
            data: data,
            color: color || 'white'
         }, false);
         chart.redraw();
      }

      var chart = $('#container-chart').highcharts({
         chart: {
            type: 'column'
         },
         title: {
            text: ''
         },
         subtitle: {
            text: ''
         },
         xAxis: {
            categories: categories
         },
         yAxis: {
            title: {
               text: 'Percent of household reportings'
            }
         },
         plotOptions: {
            column: {
               cursor: 'pointer',
               point: {
                  events: {
                     click: function() {
                        var drilldown = this.drilldown;
                        if (drilldown) { // drill down
                           setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                        } else { // restore
                           setChart(name, categories, data);
                        }
                     }
                  }
               },
               dataLabels: {
                  enabled: true,
                  color: colors[0],
                  style: {
                     fontWeight: 'bold'
                  },
                  formatter: function() {
                     return this.y + '%';
                  }
               }
            }
         },
         tooltip: {
            formatter: function() {
               var point = this.point,
                       s = this.x + ':<b>' + this.y + '% </b><br/>';
               if (point.drilldown) {
                  s += 'Click to view ' + point.category + ' versions';
               } else {
                  s += '';
               }
               return s;
            }
         },
         series: [{
               name: name,
               data: data
               
            }],
         exporting: {
            enabled: true
         }
      })
              .highcharts(); // return chart
   });