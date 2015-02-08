<?php

// Import CFPropertyList so we can do stuff
require_once( 'cfpropertylist-1.1.2/CFPropertyList.php' );


// This script adds a given software title to the additionals manifest
// the additionals manifest is added as an included manifest of the client's manifest

// Where is the additionals manifest?
$additionals = $_GET["additionals"];

// What is the name of the software title you want me to add?
$software_name = $_GET["software_name"];


// Open up our additionals plist
$plist = new CFPropertyList( '../manifests/' . $additionals );

// Lets start at the root ie the first dict      	
$root = $plist->getValue(true);

// managed_installs is our array we want to get loaded, managed_installs should already be
// in here as its created by the create.php script
$managed_installs = $root->get( 'managed_installs' );

// Now we are working with our managed_installs array
// Add a new string to the array, in this case its our software title name
$managed_installs->add( new CFString( $software_name ) );
        
// Save the updated created plist
$plist->saveXML( '../manifests/' . $additionals );

// Boom! WE KNOW PHP! Ha!
    
?>
