<?php

require_once( 'cfpropertylist-1.1.2/CFPropertyList.php' );

// Get the variables passed by the enroll script
// Here we get the path of the clients manifest
// ie ../manifests/$client_identifier
// which is ../manifests/$region/$school_name/$building/$level/$room/Clients
// We have the hostname which will be the name of the clients actual manifest
$client_identifier_path = $_GET["client_identifier_path"];
$hostname = $_GET["hostname"];
//
// Here need to get the names of the manifests for each folder
// ie. The manifest that exists in the directory called $school_name 
// is called $school_manifest
$region_manifest = $_GET["region_manifest"];
$school_manifest = $_GET["school_manifest"];
$building_manifest = $_GET["building_manifest"];
$level_manifest = $_GET["level_manifest"];
$room_manifest = $_GET["room_manifest"];
//
// Here we need to get the names of the directories inside manifests
$region = $_GET["region"];
$school_name = $_GET["school_name"];
$building = $_GET["building"];
$level = $_GET["level"];
$room = $_GET["room"];

// Check if manifest already exists for this machine, if not then create
// The directory structure to support it ie. ../manifests/$region/$school_name/$building/$level/$room/Clients
 if ( file_exists( '../manifests/' . $client_identifier_path . $hostname ) )
    {
        echo "Computer manifest already exists. Bailing out here.";
    }
else
    {
        echo "Computer manifest does not exist. Creating directory structure as needed";
        
        if ( !is_dir( '../manifests/' . $client_identifier_path ) )
            {
                mkdir( '../manifests/' . $client_identifier_path, 0755, true );
            }

// Now we need to create the computers manifest inside the Clients folder
        $plist = new CFPropertyList();
        $plist->add( $dict = new CFDictionary() );
      
        // Add manifest to production catalog by default
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
        
        // Add parent manifest to included_manifests to achieve waterfall effect
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( "$region/$school_name/$building/$level/$room/$room_manifest" ) );
        
        // Save the newly created plist
        $plist->saveXML( '../manifests/' . $client_identifier_path . $hostname );

        // 


















        
    }

?>