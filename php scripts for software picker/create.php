<?php

// Import CFPropertyList so we can do stuff
require_once( 'cfpropertylist-1.1.2/CFPropertyList.php' );


// Get some variables that are passed to us.
$client_identifier_path = $_GET["client_identifier_path"];
$hostname = $_GET["hostname"];
$additionals = $_GET["additionals"];

// Now we need to create the additional software manifest inside the Clients folder
        
		// create a new plist
        $plist = new CFPropertyList();
        // give it a dictionary
        $plist->add( $dict = new CFDictionary() );
      	// add a new array with the key catalogs
        $dict->add( 'catalogs', $array = new CFArray() );
        // add a string to our new catalogs array called production
        $array->add( new CFString( 'production' ) );
        // add a new array called managed_installs
        $dict->add( 'managed_installs', $array = new CFArray() );
        // Save the newly created plist
        $plist->saveXML( '../manifests/' . $additionals );
   
    
?>
