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

      var color = '#95b3d7';
      var colors = Highcharts.getOptions().colors,
              categories = ["Radio","TV","Cellphone","Computer","Internet"],
              name = 'Tools/Assets',
              data = [{
                  y: parseFloat(json[0].radio),
                  color: color
                 
               }, {
                  y: parseFloat(json[0].tv),
                  color: color
                 
               }, {
                  y: parseFloat(json[0].cellph),
                  color: color
                  
               }, {
                  y: parseFloat(json[0].compu),
                  color: color
                  
               }, {
                  y: parseFloat(json[0].internet),
                  color: color
                  
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
               text: 'Percent of households with asset'
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