<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$callback = $_GET["callback"];
?>
<?php echo $callback;?>({
    "folders": [],
    "services": [{
        "name": "AMKN/Photos",
        "type": "MapServer"
    }, {
        "name": "AMKN/Videos",
        "type": "MapServer"
    }]
});