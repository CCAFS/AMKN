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
    $tools[0]['url'] = 'http://ccafs.cgiar.org/atlas-ccafs-sites';
    $tools[0]['imageUrl'] = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/site%20atlas.png?itok=sw2xVua2';
    $tools[0]['title'] = 'Atlas of CCAFS sites';
    $tools[0]['drescription'] = 'Browse colorful maps of CCAFS research sites in three regions: East Africa, West Africa and South Asia';
    
    $tools[1]['url'] = 'http://ccafs.cgiar.org/spatial-downscaling-methods';
    $tools[1]['imageUrl'] = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/scaling.jpg?itok=bHV0ZRiV';
    $tools[1]['title'] = 'Spatial Downscaling Methods';
    $tools[1]['drescription'] = 'Includes differents Statical downscaling methods, Pattern Scaling MarkSim Weather Generator and Dynamical Downscaling RCMs PRECIS';
    
    $tools[2]['url'] = 'http://ccafs.cgiar.org/food-security-case-maps';
    $tools[2]['imageUrl'] = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/food_security_case.jpg?itok=B3u44aBz';
    $tools[2]['title'] = 'Food Security CASE Maps';
    $tools[2]['drescription'] = 'Interactive Climate, Agriculture, and Socio-Economic maps from IFPRI and StatPlanet';
    
    $tools[3]['url'] = 'http://ccafs.cgiar.org/marksimgcm';
    $tools[3]['imageUrl'] = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/marksim.jpg?itok=gzREmp8L';
    $tools[3]['title'] = 'MarkSimGCM';
    $tools[3]['drescription'] = 'MarkSimGCM is a stochastic weather generating tool, which uses the well-known MarkSim application, which generates simulated daily weather data specifically designed for use in the tropics, including rainfall, maximum and minimum temperatures and solar radiation.';
    
    $tools[4]['url'] = 'http://ccafs.cgiar.org/initial-sites-ccafs-regions';
    $tools[4]['imageUrl'] = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/site%20portfolio_grab.jpg?itok=GQyWkHPg';
    $tools[4]['title'] = 'Core Sites in the CCAFS Regions';
    $tools[4]['drescription'] = 'This portfolio includes brief descriptions of CCAFS core sites in East Africa, West Africa and South Asia, including coordinates of the sampling frames baseline surveys.';
    
    $tools[5]['url'] = 'http://ccafs.cgiar.org/explore-our-work-map';
    $tools[5]['imageUrl'] = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/amkn-ccafs_sites-large.jpg?itok=dfTzFseX';
    $tools[5]['title'] = 'Explore our work on a map!';
    $tools[5]['drescription'] = 'The Adaptation and Mitigation Knowledge Network lets you explore data from our research on climate change, agriculture and food security, alongside related multimedia such as video interviews with farmers and photos and blogs from field work.';
    
    $tools[6]['url'] = 'http://ccafs.cgiar.org/tool-climate-analogue-tool';
    $tools[6]['imageUrl'] = 'http://ccafs.cgiar.org/sites/default/files/styles/large/public/analogues_climate_durban.jpg?itok=C-XTBjTX';
    $tools[6]['title'] = 'Climate Analogues';
    $tools[6]['drescription'] = 'Climate Analogues deliver a glimpse of future climates, by identifying and mapping spatial and temporal analogue sites across the globe based on multiple climate projections.';
    
    return $tools;  
  }
  function my_post() { }
  function my_put() { }
  function my_delete() { }
  //And adding them to the RESTmap:
?>