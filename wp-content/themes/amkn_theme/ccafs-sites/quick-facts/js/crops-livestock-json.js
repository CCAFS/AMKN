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
              categories = [json[0].name_crop1, json[0].name_crop2, json[0].name_crop3, json[0].name_livestock1, json[0].name_livestock2],
              name = 'Main crops & livestock',
              data = [{
                  y: parseFloat(json[0].crop1),
                  color: greencolor
               }, {
                  y: parseFloat(json[0].crop2),
                  color: greencolor
               }, {
                  y: parseFloat(json[0].crop3),
                  color: greencolor
               }, {
                  y: parseFloat(json[0].livestock1),
                  color: greencolor
               }, {
                  y: parseFloat(json[0].livestock2),
                  color: greencolor
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
               text: 'Percent of households citing'
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
                       s = this.x + ':<b>' + this.y + '% households citing</b><br/>';
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
               data: data,
               color: greencolor
            }],
         exporting: {
            enabled: true
         }
      })
              .highcharts(); // return chart
   });