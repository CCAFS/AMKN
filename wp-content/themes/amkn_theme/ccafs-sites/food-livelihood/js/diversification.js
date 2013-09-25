 var pdi = (function() {
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
      var color = ['#c3d69b','#77933c','#4f6228'];
      var colors = Highcharts.getOptions().colors,
              categories = ["1-4 Products","5-8 Products","9 or more products"],
              name = 'Products',
              data = [{
                  y: parseFloat(pdi[0].from1to4),
                  color: color[0]
               }, {
                  y: parseFloat(pdi[0].from5to8),
                  color: color[1]
               }, {
                  y: parseFloat(pdi[0].more9),
                  color: color[2]
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
      var chart = $('#container-chart1').highcharts({
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
               text: 'Production diversification'
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
                  color: color,
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
   
   
   
    var sdi = (function() {
      var json = null;
      $.ajax({
         'async': false,
         'global': false,
         'url': $('#url-site2').text(),
         'dataType': "json",
         'success': function(data) {
            json = data;
         }
      });
      return json;
   })();
   
   $(function() { 
      var color = ['#e6b9b8','#d99694','#953735','#632523'];
      var colors = Highcharts.getOptions().colors,
              categories = ["No Products","1-2 Products","3-5 Products","6 or more products"],
              name = 'Products',
              data = [{
                  y: parseFloat(sdi[0].none),
                  color: color[0]
               },{
                  y: parseFloat(sdi[0].from1to2),
                  color: color[1]
               }, {
                  y: parseFloat(sdi[0].from3to5),
                  color: color[2]
               }, {
                  y: parseFloat(sdi[0].more6),
                  color: color[3]
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
      var chart = $('#container-chart2').highcharts({
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
               text: 'Production diversification'
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