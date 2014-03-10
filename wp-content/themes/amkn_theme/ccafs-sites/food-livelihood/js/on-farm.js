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
   
var sell = [];
var cons = []; 
var prod = []; 
sell[0] = parseFloat(json[0].sell_food);
sell[1] = parseFloat(json[0].sell_cash);
sell[2] = parseFloat(json[0].sell_fruit);
sell[3] = parseFloat(json[0].sell_veg);
sell[4] = parseFloat(json[0].sell_fodd);
sell[5] = parseFloat(json[0].sell_lglive);
sell[6] = parseFloat(json[0].sell_smlive);
sell[7] = parseFloat(json[0].sell_liveprod);
sell[8] = parseFloat(json[0].sell_fish);
sell[9] = parseFloat(json[0].sell_timb);
sell[10] = parseFloat(json[0].sell_fuel);
sell[11] = parseFloat(json[0].sell_char);
sell[12] = parseFloat(json[0].sell_honey);
sell[13] = parseFloat(json[0].sell_manure);

cons[0] = parseFloat(json[0].cons_food);
cons[1] = parseFloat(json[0].cons_cash);
cons[2] = parseFloat(json[0].cons_fruit);
cons[3] = parseFloat(json[0].cons_veg);
cons[4] = parseFloat(json[0].cons_fodd);
cons[5] = parseFloat(json[0].cons_lglive);
cons[6] = parseFloat(json[0].cons_smlive);
cons[7] = parseFloat(json[0].cons_liveprod);
cons[8] = parseFloat(json[0].cons_fish);
cons[9] = parseFloat(json[0].cons_timb);
cons[10] = parseFloat(json[0].cons_fuel);
cons[11] = parseFloat(json[0].cons_char);
cons[12] = parseFloat(json[0].cons_honey);
cons[13] = parseFloat(json[0].cons_manure);

prod[0] = parseFloat(json[0].prod_food);
prod[1] = parseFloat(json[0].prod_cash);
prod[2] = parseFloat(json[0].prod_fruit);
prod[3] = parseFloat(json[0].prod_veg);
prod[4] = parseFloat(json[0].prod_fodd);
prod[5] = parseFloat(json[0].prod_lglive);
prod[6] = parseFloat(json[0].prod_smlive);
prod[7] = parseFloat(json[0].prod_liveprod);
prod[8] = parseFloat(json[0].prod_fish);
prod[9] = parseFloat(json[0].prod_timb);
prod[10] = parseFloat(json[0].prod_fuel);
prod[11] = parseFloat(json[0].prod_char);
prod[12] = parseFloat(json[0].prod_honey);
prod[13] = parseFloat(json[0].prod_manure);



$(function () {
        $('#container-chart').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Manure/compost', 'Honey', 'Charcoal', 'Fuel wood', 'Timber','Fish','Livestock products','Small livestock','Large livestock','Fodder','Vegetables','Fruit','Cash crops', 'Food/Cereal crops'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '% of households',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                },
                series: {
                pointPadding: 1,
                groupPadding: 0.95,
                borderWidth: 0, 
                shadow: false
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Selling',
                data: sell.reverse()
            }, {
                name: 'Consuming',
                data: cons.reverse()
            }, {
                name: 'Producing',
                data: prod.reverse()
            }]
        });
    });
