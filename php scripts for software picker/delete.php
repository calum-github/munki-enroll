<?php


$additionals = $_GET["additionals"];

if ( file_exists( '../manifests/' . $additionals ) )
    {
        echo "Note: The additionals manifest EXISTS! We should DELETE it";
        unlink( '../manifests/' . $additionals );

    }
else
    echo "Note: The additionals manifest does NOT EXIST, nothing to do.. ";
?>
