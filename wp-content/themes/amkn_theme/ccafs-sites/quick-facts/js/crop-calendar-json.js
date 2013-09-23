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

var rowsData = [];
json.forEach(function(entry) {
   var currentYear = new Date().getFullYear();
   var name = entry.name;
   var startSowing = new Date(entry.start_date_sowing);
   var startHarvesting = new Date(entry.start_date_harvesting);
   var endSowing = new Date(entry.end_date_sowing);
   var endHarvesting = new Date(entry.end_date_harvesting);
   //Add row to array rowsData
   if (startSowing <= endSowing) {
      rowsData.push([name, 'Sowing', startSowing, endSowing]);
   } else {
      rowsData.push([name, 'Sowing', new Date(endSowing.getFullYear(), 0, 1), endSowing]);
      rowsData.push([name, 'Sowing', startSowing, new Date(endSowing.getFullYear(), 11, 30)]);
   }
   if (startHarvesting <= endHarvesting) {
      rowsData.push([name, 'Harvesting', startHarvesting, endHarvesting]);
   } else {
      rowsData.push([name, 'Harvesting', new Date(endHarvesting.getFullYear(), 0, 1), endHarvesting]);
      rowsData.push([name, 'Harvesting', startHarvesting, new Date(endHarvesting.getFullYear(), 11, 30)]);
   }

});




google.setOnLoadCallback(drawChart);
function drawChart() {

   var container = document.getElementById('container-chart');
   var chart = new google.visualization.Timeline(container);


   var dataTable = new google.visualization.DataTable();
   dataTable.addColumn({type: 'string', id: 'Position'});
   dataTable.addColumn({type: 'string', id: 'Name'});
   dataTable.addColumn({type: 'date', id: 'Start'});
   dataTable.addColumn({type: 'date', id: 'End'});
   dataTable.addRows(rowsData);
   var options = {
      colors: ['#ffcc33', '#80c65a'],
      timeline: {rowLabelStyle: {fontSize: 12, color: '#603913'},
         barLabelStyle: {fontSize: 11},
         groupByRowLabel: true
      }
   };
   /* Change the format of the date column, used in chart, but not chart range filter */
   var formatter = new google.visualization.DateFormat({pattern: "dd.MM"});
   formatter.format(dataTable, 0);
   chart.draw(dataTable, options);
}