<?php

// example usage for the PHP client library for pubsubhubbub
// as defined at http://code.google.com/p/pubsubhubbub/
// written by Josh Fraser | joshfraser.com | josh@eventvue.com
// Released under Apache License 2.0

include("publisher.php");

// process form
// if ($_POST['sub']) {
    
//     $hub_url = "http://pubsubhubbub.appspot.com/publish"; //$_POST['hub_url'];
    $hub_url = "http://markbil.superfeedr.com/";
    $topic_url = "http://theedge.checkinsystem.net/API/feed/loc.php"; //$_POST['topic_url'];
    
    // check that a hub url is specified
    if (!$hub_url) {
        echo "Please specify a hub url.<br /><br /><a href='http://theedge.checkinsystem.net/API/checkin_submit_manual.php'>back</a>";
        exit();
    }
    // check that a topic url is specified
    if (!$topic_url) {
        echo "Please specify a topic url to publish.<br /><br /><a href='http://theedge.checkinsystem.net/API/checkin_submit_manual.php'>back</a>";
        exit();
    }         
    
    // $hub_url = "http://pubsubhubbub.appspot.com/publish";
    $p = new Publisher($hub_url);
    if ($p->publish_update($topic_url)) {
        echo "<br /><br /><i>$topic_url</i> was successfully published to <i>$hub_url</i><br /><br />";
    } else {
        echo "ooops...";
        print_r($p->last_response());
    }

// }

// else { 
//     // display a primitive form for testing
//     echo "<form action='publisher_example.php' method='POST'>";
//     echo "hub url: <input name='hub_url' type='text' value='http://pubsubhubbub.appspot.com/publish' size='50'/><br />";
//     echo "topic url: <input name='topic_url' type='text' value='http://theedge.checkinsystem.net/API/feed/loc.php' size='50' /><br />";
//     echo "<input name='sub' type='submit' value='Publish' /><br />";
//     echo "</form>";   
// }


?>