<!DOCTYPE html 
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Listing calendar contents</title>
    <style>
    body {
      font-family: Verdana;      
    }
    li {
      border-bottom: solid black 1px;      
      margin: 10px; 
      padding: 2px; 
      width: auto;
      padding-bottom: 20px;
    }
    h2 {
      color: red; 
      text-decoration: none;  
    }
    span.attr {
      font-weight: bolder;  
    }
    </style>    
  </head>
  <body>
    <?php
    $userid = 'zj.aken%40googlemail.com';
    $magicCookie = 'cookie';
    
    // build feed URL
    $feedURL = "http://www.google.com/calendar/feeds/$userid/private-$magicCookie/basic";
    
    // read feed into SimpleXML object
    $sxml = simplexml_load_file($feedURL);
    
    // get number of events
    $counts = $sxml->children('http://a9.com/-/spec/opensearchrss/1.0/');
    $total = $counts->totalResults; 
    ?>
    <h1><?php echo $sxml->title; ?></h1>
    <?php echo $total; ?> event(s) found.
    <p/>
    <ol>
    <?php    
    // iterate over entries in category
    // print each entry's details
    foreach ($sxml->entry as $entry) {
      $title = stripslashes($entry->title);
      $summary = stripslashes($entry->summary);
      
      echo "<li>\n";
      echo "<h2>$title</h2>\n";
      echo "$summary <br/>\n";
      echo "</li>\n";
    }
    ?>
    </ol>
  </body>
</html> 