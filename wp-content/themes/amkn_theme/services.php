<?php
  $GLOBALS['RESTmap'] = array();
  $GLOBALS['RESTmap']['GET'] = array('get' => 'dataGet');
  $GLOBALS['RESTmap']['POST'] = array('my-post' => 'my_post');
  $GLOBALS['RESTmap']['PUT'] = array('my-put' => 'my_post');
  $GLOBALS['RESTmap']['DELETE'] = array('my-delete' => 'my_delete');

    // find the function/method to call
  $callback = NULL;
  if (preg_match('/DataAndTools\/([^\/]+)/', $_SERVER['REQUEST_URI'], $m)) {
    if (isset($GLOBALS['RESTmap'][$_SERVER['REQUEST_METHOD']][$m[1]])) {
      $callback = $GLOBALS['RESTmap'][$_SERVER['REQUEST_METHOD']][$m[1]];
    }
  }

  if (is_callable($callback)) {
    // get the request data
    $data = NULL;
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $data = $_GET;
    } else if ($tmp = file_get_contents('php://input')) {
        $data = json_decode($tmp);
    }
    // execute the function/method and return the results
    header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
    header('Content-Type: text/plain');
    print json_encode(call_user_func($callback, $data));
  } else {
    header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
//         print "404 page here";
    exit;
  }
    
  function dataGet() {
    $tools = array();
    $obj = new stdClass();
    $obj->title = 'Atlas of CCAFS sites';
    $obj->description = 'Browse colorful maps of CCAFS research sites in three regions: East Africa, West Africa and South Asia';
    $obj->imageUrl = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/site%20atlas.png?itok=sw2xVua2';
    $obj->url = 'http://ccafs.cgiar.org/atlas-ccafs-sites';
    $tools[0] = $obj;
    
    $obj = new stdClass();
    $obj->title = 'Spatial Downscaling Methods';
    $obj->description = 'Includes differents Statical downscaling methods, Pattern Scaling MarkSim Weather Generator and Dynamical Downscaling RCMs PRECIS';    
    $obj->imageUrl = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/scaling.jpg?itok=bHV0ZRiV';
    $obj->url = 'http://ccafs.cgiar.org/spatial-downscaling-methods';
    $tools[1] = $obj;
    
    $obj = new stdClass();
    $obj->title = 'Food Security CASE Maps';
    $obj->description = 'Interactive Climate, Agriculture, and Socio-Economic maps from IFPRI and StatPlanet';        
    $obj->imageUrl = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/food_security_case.jpg?itok=B3u44aBz';
    $obj->url = 'http://ccafs.cgiar.org/food-security-case-maps';
    $tools[2] = $obj;
    
    $obj = new stdClass();
    $obj->title = 'MarkSimGCM';
    $obj->description = 'MarkSimGCM is a stochastic weather generating tool, which uses the well-known MarkSim application, which generates simulated daily weather data specifically designed for use in the tropics, including rainfall, maximum and minimum temperatures and solar radiation.';    
    $obj->imageUrl = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/marksim.jpg?itok=gzREmp8L';
    $obj->url = 'http://ccafs.cgiar.org/marksimgcm';
    $tools[3] = $obj;
    
    $obj = new stdClass();    
    $obj->title = 'Core Sites in the CCAFS Regions';
    $obj->description = 'This portfolio includes brief descriptions of CCAFS core sites in East Africa, West Africa and South Asia, including coordinates of the sampling frames baseline surveys.';    
    $obj->imageUrl = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/site%20portfolio_grab.jpg?itok=GQyWkHPg';
    $obj->url = 'http://ccafs.cgiar.org/initial-sites-ccafs-regions';
    $tools[4] = $obj;
    
    $obj = new stdClass();    
    $obj->title = 'Explore our work on a map!';
    $obj->description = 'The Adaptation and Mitigation Knowledge Network lets you explore data from our research on climate change, agriculture and food security, alongside related multimedia such as video interviews with farmers and photos and blogs from field work.';    
    $obj->imageUrl = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/amkn-ccafs_sites-large.jpg?itok=dfTzFseX';
    $obj->url = 'http://ccafs.cgiar.org/explore-our-work-map';
    $tools[5] = $obj;
    
    $obj = new stdClass();    
    $obj->title = 'Climate Analogues';
    $obj->description = 'Climate Analogues deliver a glimpse of future climates, by identifying and mapping spatial and temporal analogue sites across the globe based on multiple climate projections.';    
    $obj->imageUrl = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/analogues_climate_durban.jpg?itok=C-XTBjTX';
    $obj->url = 'http://ccafs.cgiar.org/tool-climate-analogue-tool';
    $tools[6] = $obj;
    
    return $tools;  
  }
  function my_post() { }
  function my_put() { }
  function my_delete() { }
  //And adding them to the RESTmap:
?>