if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
var output = '<?xml version="1.0" encoding="UTF-8"?>\n';
output += '<rss xmlns:georss="http://www.georss.org/georss" xmlns:ccafs="http://localhost/AMKN/wp-content/plugins/activitiesImporter/TypeActivities" version="2.0">\n';
output += '<channel><title>Planing and Reporting</title><link>http://activities.ccafs.cgiar.org</link><description></description>\n';
xmlhttp.open("GET","origen.xml",false);
xmlhttp.send();
xmlDoc=xmlhttp.responseXML;
activities = xmlDoc.getElementsByTagName("activity");
for (var i=0, len=activities.length; i<len; i++) {
  output += '<item>\n';
  output += '<title>'+activities[i].getElementsByTagName("title")[0].childNodes[0].data+'</title>\n';
  output += '<link>'+activities[i].getElementsByTagName("publicURL")[0].childNodes[0].data+'</link>\n';
  output += '<description>'+activities[i].getElementsByTagName("description")[0].childNodes[0].data+'</description>\n';
  output += '<ccafs:id>'+activities[i].getElementsByTagName("id")[0].childNodes[0].data+'</ccafs:id>\n';
  if (activities[i].getElementsByTagName("startDate")[0].childNodes[0])
    output += '<ccafs:startDate>'+activities[i].getElementsByTagName("startDate")[0].childNodes[0].data+'</ccafs:startDate>\n';
  if (activities[i].getElementsByTagName("endDate")[0].childNodes[0]) 
    output += '<ccafs:endDate>'+activities[i].getElementsByTagName("endDate")[0].childNodes[0].data+'</ccafs:endDate>\n';
  output += '<ccafs:milestone>'+activities[i].getElementsByTagName("milestone")[0].childNodes[0].data+'</ccafs:milestone>\n';
  output += '<ccafs:theme>'+getTheme(activities[i].getElementsByTagName("milestone")[0].childNodes[0].data)+'</ccafs:theme>\n';

  cont = activities[i].getElementsByTagName("leader");
  for (var j=0, lenj=cont.length; j<lenj; j++) {          
    output += '<ccafs:leaderName>'+cont[j].getElementsByTagName("name")[0].childNodes[0].data+'</ccafs:leaderName>\n';
    output += '<ccafs:leaderAcronym>'+cont[j].getElementsByTagName("acronym")[0].childNodes[0].data+'</ccafs:leaderAcronym>\n';
  }

  cont = activities[i].getElementsByTagName("contactPersons")[0].getElementsByTagName("contactPerson");
  for (var j=0, lenj=cont.length; j<lenj; j++) {
    output += '<ccafs:contactName>'+cont[j].getElementsByTagName("name")[0].childNodes[0].data+'</ccafs:contactName>\n';
    if (cont[j].getElementsByTagName("email")[0].childNodes[0])
      output += '<ccafs:contactEmail>'+cont[j].getElementsByTagName("email")[0].childNodes[0].data+'</ccafs:contactEmail>\n';
  }

  output += '<ccafs:locationIsGlobal>'+activities[i].getElementsByTagName("locations")[0].getElementsByTagName("isGlobal")[0].childNodes[0].data+'</ccafs:locationIsGlobal>\n';       
  cont = activities[i].getElementsByTagName("countryLocations")[0].getElementsByTagName("country");
  for (var j=0, lenj=cont.length; j<lenj; j++) {
    output += '<ccafs:countryLocationIso2>'+cont[j].getElementsByTagName("iso2")[0].childNodes[0].data+'</ccafs:countryLocationIso2>\n';
    output += '<ccafs:countryLocationName>'+cont[j].getElementsByTagName("name")[0].childNodes[0].data+'</ccafs:countryLocationName>\n';
  }

  cont = activities[i].getElementsByTagName("ccafsSite");
  for (var j=0, lenj=cont.length; j<lenj; j++) {          
    output += '<ccafs:ccafsSiteName>'+cont[j].getElementsByTagName("name")[0].childNodes[0].data+'</ccafs:ccafsSiteName>\n';
    output += '<ccafs:ccafsSitePoint>'+cont[j].getElementsByTagName("latitude")[0].childNodes[0].data+' '+cont[j].getElementsByTagName("longitude")[0].childNodes[0].data+'</ccafs:ccafsSitePoint>\n';
  }

  cont = activities[i].getElementsByTagName("otherSite");
  for (var j=0, lenj=cont.length; j<lenj; j++) {          
    output += '<ccafs:otherSiteName>'+cont[j].getElementsByTagName("country")[0].getElementsByTagName("name")[0].childNodes[0].data+'</ccafs:otherSiteName>\n';
    output += '<ccafs:otherSiteIso2>'+cont[j].getElementsByTagName("country")[0].getElementsByTagName("iso2")[0].childNodes[0].data+'</ccafs:otherSiteIso2>\n';
    output += '<ccafs:otherSitePoint>'+cont[j].getElementsByTagName("latitude")[0].childNodes[0].data+' '+cont[j].getElementsByTagName("longitude")[0].childNodes[0].data+'</ccafs:otherSitePoint>\n';
  }

  cont = activities[i].getElementsByTagName("keyword");
  for (var j=0, lenj=cont.length; j<lenj; j++) {          
    output += '<ccafs:keyword>'+cont[j].childNodes[0].data.trim()+'</ccafs:keyword>\n';          
  }
  
  output += '<ccafs:budget>'+activities[i].getElementsByTagName("budget")[0].getElementsByTagName("usd")[0].childNodes[0].data.replace(',','')+'</ccafs:budget>\n';
  if (activities[i].getElementsByTagName("startDate")[0].childNodes[0])
    output += '<ccafs:startDateFilter>'+dateFormat(activities[i].getElementsByTagName("startDate")[0].childNodes[0].data)+'</ccafs:startDateFilter>\n';
  if (activities[i].getElementsByTagName("endDate")[0].childNodes[0]) 
    output += '<ccafs:endDateFilter>'+dateFormat(activities[i].getElementsByTagName("endDate")[0].childNodes[0].data)+'</ccafs:endDateFilter>\n';
  output += '</item>\n';
}
output += '</channel>\n';
output += '</rss>';
document.pas.dataxml.value = output;
document.pas.submit();

function getTheme(mile) {
  theme = mile.split('.');
  if (theme[0] == '4'){
    return theme[0]+'.'+theme[1];
  } else {
    return theme[0];
  }
}

function dateFormat(date) {
  date = date.split('/');
  return date[2]+date[0]+date[1];
}

