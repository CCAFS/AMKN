<?php

require_once("../../../wp-config.php");
$api_key = get_option('trab_flickrAPIKey');
$user_id = get_option('trab_flickrUserID');

error_reporting(E_ALL);

function getFlickrRestServiceByMethod($postargs){
  // The POST URL and parameters
  $request =  'https://api.flickr.com/services/rest/';

  // Get the curl session object
  $session = curl_init($request);

  // Set the POST options.
  curl_setopt ($session, CURLOPT_POST, true);
  curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
  curl_setopt($session, CURLOPT_HEADER, true);
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);

  // Do the POST and then close the session
  
  $response = curl_exec($session);
//  $error = curl_error($session);
//  echo $error;
  curl_close($session);

  // Get HTTP Status code from the response
  $status_code = array();
//  echo $response."**";
  preg_match('/\d\d\d/', $response, $status_code);

  // Check for errors
  if (isset($status_code[0])){
  switch( $status_code[0] ) {
    case 200:
      // Success
      break;
    case 503:
      die('Your call to Yahoo Web Services failed and returned an HTTP status of 503. That means: Service unavailable. An internal problem prevented us from returning data to you.');
      break;
    case 403:
      die('Your call to Yahoo Web Services failed and returned an HTTP status of 403. That means: Forbidden. You do not have permission to access this resource, or are over your rate limit.');
      break;
    case 400:
      // You may want to fall through here and read the specific XML error
      die('Your call to Yahoo Web Services failed and returned an HTTP status of 400. That means:  Bad request. The parameters passed to the service did not match as expected. The exact error is returned in the XML response.');
      break;
    default:
      die('Your call to Yahoo Web Services returned an unexpected HTTP status of:' . $status_code[0]);
  }
  }

  // Get the XML from the response, bypassing the header
  if (!($xml = strstr($response, '<?xml'))) {
    $xml = null;
  }
  // Output the XML
  return $xml;
}
$output = "";
$xml = simplexml_load_string(getFlickrRestServiceByMethod("method=flickr.photosets.getList&api_key=".$api_key."&user_id=".$user_id));
$userXML =  simplexml_load_string(getFlickrRestServiceByMethod("method=flickr.people.getInfo&api_key=".$api_key."&user_id=".$user_id));
$photoSets = $xml->xpath("//rsp/photosets/photoset");
$userInfo = $userXML->xpath("//person");
header("Content-Type: application/rss+xml; charset=UTF-8");
ob_start ("ob_gzhandler");
$output = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
$output .= "<rss version='2.0' xmlns:dc='http://purl.org/dc/elements/1.1/' xmlns:geo='http://www.w3.org/2003/01/geo/wgs84_pos#' xmlns:georss='http://www.georss.org/georss' xmlns:woe='http://where.yahooapis.com/v1/schema.rng'>
              <channel>
                <title>".htmlspecialchars($userInfo[0]->realname)."Flickr Photo Sets</title>
                <link>".$userInfo[0]->photosurl."</link>
                <description>".htmlspecialchars($userInfo[0]->realname)."Flickr Photo Sets</description>";
$maxSets2Get = count($photoSets) > 100 ? 100 : count($photoSets);
for($i=0; $i < $maxSets2Get; $i++) {
  $arr = $photoSets[$i]->attributes();
  $primaryPhoto = $arr["primary"];
  $setID = $arr["id"];
  $xmlPhotos = simplexml_load_string(getFlickrRestServiceByMethod("method=flickr.photosets.getPhotos&api_key=".$api_key."&user_id=".$user_id."&photoset_id=".$setID."&extras=license,%20date_upload,%20date_taken,%20owner_name,%20icon_server,%20original_format,%20last_update,%20geo,%20tags,%20machine_tags,%20o_dims,%20views,%20media,%20path_alias,%20url_sq,%20url_t,%20url_s,%20url_m,%20url_o"));

  $updatesInSet = $xmlPhotos->xpath("//rsp/photoset/photo");
  $photosInSet = $xmlPhotos->xpath("//rsp/photoset/photo");
  $dateSecsUpdated = 0;
  $dateLastUpdated = "";
  $setGeoLat = "";
  $setGeoLon = "";
  $setWoeID = "";
  $primPhotoURL = "";
  $photoSetTitle = htmlspecialchars($photoSets[$i]->title);
  $photoSetDescription = htmlspecialchars($photoSets[$i]->description);
  foreach ($updatesInSet as $updateInSet) {
    $attPhoto = $updateInSet->attributes();
    if (intval($attPhoto["lastupdate"]) > $dateSecsUpdated) {
      $dateSecsUpdated = intval($attPhoto["lastupdate"]);
      $dateLastUpdated = date(DATE_RSS, intval($attPhoto["lastupdate"]));
      $setGeoLat = $attPhoto["latitude"];
      $setGeoLon = $attPhoto["longitude"];
      $setWoeID = $attPhoto["woeid"];
      $primPhotoURL = $attPhoto["url_m"];
    }
  }
  $output .= "<item>
                <title>".$photoSetTitle."</title>
                <link>http://www.flickr.com/photos/".$user_id."/sets/".$setID."/</link>
                <description>";
  foreach($photosInSet as $photoInSet) {	
    $arrPhoto = $photoInSet->attributes();
    $primaryPhotoInSet = $arrPhoto["isprimary"] == "1" ? "PRIMARY" : "NOTPRIMARY";       
    $output .= "&lt;div id=&quot;photoSetThumb&quot;&gt;
                    &lt;a rel=&quot;lightbox[".$setID."]&quot; title=&quot;".htmlspecialchars($arrPhoto["title"])."&quot;  href=&quot;".$arrPhoto["url_m"]."&quot;&gt;
                    &lt;img src=&quot;".$arrPhoto["url_t"]."&quot; /&gt;
                    &lt;/a&gt;
                &lt;/div&gt;";
  }
    $output .= "</description>
        <pubDate>".$dateLastUpdated."</pubDate>
        <guid isPermaLink='false'>tag:flickr.com,2004:/".$user_id."/sets/".$setID."</guid>
        <georss:point>".$setGeoLat." ".$setGeoLon."</georss:point>
        <geo:lat>".$setGeoLat."</geo:lat>
        <geo:long>".$setGeoLon."</geo:long>
        <woe:woeid>".$setWoeID."</woe:woeid>
        <dc:galleryThumb>".$primPhotoURL."</dc:galleryThumb>
    </item>";
}
$output .= "</channel>
</rss>";
  echo $output;
  $file = fopen($user_id.".xml","w+");
  fwrite($file,$output);
  fclose($file); 
?>