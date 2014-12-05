<?php

// Munki Enroll Rebooted!
// Version 1.0
// Calum Hunter
// 5-Dec-2014
// Expanded upon the work by Cody Eding
// github.com/edingc

// Import CFProperlist so we can create Plists
require_once( 'cfpropertylist-1.1.2/CFPropertyList.php' );

// Get the variables passed by the enroll script
$client_identifier_path = $_GET["client_identifier_path"];
$hostname = $_GET["hostname"];
$region_manifest = $_GET["region_manifest"];
$school_manifest = $_GET["school_manifest"];
$building_manifest = $_GET["building_manifest"];
$level_manifest = $_GET["level_manifest"];
$room_manifest = $_GET["room_manifest"];
$region = $_GET["region"];
$school_name = $_GET["school_name"];
$building = $_GET["building"];
$level = $_GET["level"];
$room = $_GET["room"];

// Check if a manifest already exists for this machine, if not then create one and also create
// the directory structure to support it ie. ../manifests/$region/$school_name/$building/$level/$room/Clients/hostname-manifest
if ( file_exists( '../manifests/' . $client_identifier_path . $hostname ) )
    {
        echo "###-EXISTS-### Computer manifest already exists. Bailing out here.";
    }
else
    {
        echo "###-CREATED-### Computer manifest does not exist. Creating manifest and directory structure as needed.";
        
        if ( !is_dir( '../manifests/' . $client_identifier_path ) )
            {
                mkdir( '../manifests/' . $client_identifier_path, 0755, true );
            }

// Now we need to create the computers manifest inside the Clients folder
// We also tell it to include the Room manifest
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
    }

// Lets check to see if the Room manifest exists, if not create it
if ( file_exists( "../manifests/$region/$school_name/$building/$level/$room/$room_manifest" ) )
    {
        echo "###-EXISTS-### Room manifest already exists, no need to create it.";
    }
else
    {
        echo "###-CREATED-### Room manifest NOT present, creating it now.";
        // Create the new manifest for the Room
        $plist = new CFPropertyList();
        $plist->add( $dict = new CFDictionary() );
        // Add the manifest to production catalog
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
        // Add parent manifest ie. Level manifest
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( "$region/$school_name/$building/$level/$level_manifest" ) );
        // Save the new plist
        $plist->saveXML( "../manifests/$region/$school_name/$building/$level/$room/$room_manifest" );
    }

// Lets check to see if the Level manifest exists, if not create it
if ( file_exists( "../manifests/$region/$school_name/$building/$level/$level_manifest" ) )
    {
        echo "###-EXISTS-### Level manifest already exists, no need to create it.";
    }
else
    {
        echo "###-CREATED-### Level manifest NOT present, creating it now.";
        // Create the new manifest for the Level
        $plist = new CFPropertyList();
        $plist->add( $dict = new CFDictionary() );
        // Add the manifest to production catalog
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
        // Add parent manifest ie. Building manifest
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( "$region/$school_name/$building/$building_manifest" ) );
        // Save the new plist
        $plist->saveXML( "../manifests/$region/$school_name/$building/$level/$level_manifest" );
    }

// Lets check to see if the Building manifest exists, if not create it
if ( file_exists( "../manifests/$region/$school_name/$building/$building_manifest" ) )
    {
        echo "###-EXISTS-### Building manifest already exists, no need to create it.";
    }
else
    {
        echo "###-CREATED-### Building manifest NOT present, creating it now.";
        // Create the new manifest for the Room
        $plist = new CFPropertyList();
        $plist->add( $dict = new CFDictionary() );
        // Add the manifest to production catalog
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
        // Add parent manifest ie. School manifest
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( "$region/$school_name/$school_manifest" ) );
        // Save the new plist
        $plist->saveXML( "../manifests/$region/$school_name/$building/$building_manifest" );
    }

// Lets check to see if the School manifest exists, if not create it
if ( file_exists( "../manifests/$region/$school_name/$school_manifest" ) )
    {
        echo "###-EXISTS-### School manifest already exists, no need to create it.";
    }
else
    {
        echo "###-CREATED-### School manifest NOT present, creating it now.";
        // Create the new manifest for the Room
        $plist = new CFPropertyList();
        $plist->add( $dict = new CFDictionary() );
        // Add the manifest to production catalog
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
        // Add parent manifest ie. School manifest
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( "$region/$region_manifest" ) );
        // Save the new plist
        $plist->saveXML( "../manifests/$region/$school_name/$school_manifest" );
    }

// Lets check to see if the Region manifest exists, if not create it
if ( file_exists( "../manifests/$region/$region_manifest" ) )
    {
        echo "###-EXISTS-### Region manifest already exists, no need to create it.";
    }
else
    {
        echo "###-CREATED-### Region manifest NOT present, creating it now.";
        // Create the new manifest for the Room
        $plist = new CFPropertyList();
        $plist->add( $dict = new CFDictionary() );
        // Add the manifest to production catalog
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
        // Add parent manifest ie. School manifest
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( "_Global" ) );
        // Save the new plist
        $plist->saveXML( "../manifests/$region/$region_manifest" );
    }

?>