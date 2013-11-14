<?php
  $GLOBALS['RESTmap'] = array();
  $GLOBALS['RESTmap']['GET'] = array('my-get' => 'my_get');
  $GLOBALS['RESTmap']['POST'] = array('my-post' => 'my_post');
  $GLOBALS['RESTmap']['PUT'] = array('my-put' => 'my_post');
  $GLOBALS['RESTmap']['DELETE'] = array('my-delete' => 'my_delete');

    // find the function/method to call
  $callback = NULL;
  if (preg_match('/php\/([^\/]+)/', $_SERVER['REQUEST_URI'], $m)) {
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
    
  function my_get() { 
    $tools = array();
    $tools['atlas_ccafs']['url'] = 'http://ccafs.cgiar.org/atlas-ccafs-sites';
    $tools['spatial_downscaling_methods']['url'] = 'http://ccafs.cgiar.org/spatial-downscaling-methods';
    $tools['food_security_case_maps']['url'] = 'http://ccafs.cgiar.org/food-security-case-maps';
    $tools['marksimgcm']['url'] = 'http://ccafs.cgiar.org/marksimgcm';
    $tools['initial_sites_ccafs_regions']['url'] = 'http://ccafs.cgiar.org/initial-sites-ccafs-regions';
    $tools['amkn']['url'] = 'http://ccafs.cgiar.org/explore-our-work-map';
    $tools['analogue']['url'] = 'http://ccafs.cgiar.org/tool-climate-analogue-tool';
    return $tools;  
  }
  function my_post() { }
  function my_put() { }
  function my_delete() { }
  //And adding them to the RESTmap:
?>