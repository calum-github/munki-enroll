# Munki Enroll Rebooted!

Expanding upon the work by Cody Eding. Munki Enroll is now able to very easily create manifests and directory structures in your manifests directory to help you manage a large scale Munki Deployment

## Why Munki Enroll Rebooted?

The original Munki Enroll, was great but my organisation has a very large distributed environment, so we needed to be able to apply applications to manifests in a very granular way.

We have the following structure of manifests and directories
../manifests/region_name/school_name/building_name/level_number/room_number/Clients/hostname-manifest

Now we certainly didn't want to have to create any of of those folders and manifests by hand.

## Enter Munki Enroll Rebooted.

At imaging time, we collect a bunch of information about a machine from user input and from AD search queries.
So we know exactly where the machine is being deployed.

Based upon this information, Munki Enroll checks to see if we already have a manifest for our machine.
If we don't then the php script will create the directories and manifests for us.
Each manifest includes the manifest of the enclosing folder.

So the hostname-manifest includes the room_number_manifest
The room_number_manifest includes the level_number_manifest and so on and so on.

### Wait, Doesn't Munki Do This Already?

Munki can target systems based on hostnames or serial numbers. However, each manifest must be created by hand. Munki Enroll allows us to create specific manifests automatically, and to allow them to contain a more generic manifest for large-scale software management.

## Installation

Munki Enroll requires PHP to be working on the webserver hosting your Munki repository.

Copy the "munki-enroll" folder to the root of your Munki repository (the same directory as pkgs, pkginfo, manifests and catalogs). 

That's it! Be sure to make note of the full URL path to the enroll.php file.

Also make sure that your webserver has write access to the manifests folder in order to create the folders and manifests

## Client Configuration

Edit the included munki_enroll.sh script to include the full URL path to the enroll.php file on your Munki repository.

	SUBMITURL="http://munki/munki-enroll/enroll.php"

The included munki_enroll.sh script can be executed in any number of ways (Terminal, ARD, DeployStudio workflow, LaunchAgent, etc.). Once the script is executed, the Client Identifier is switched to a unique identifier based on the system's hostname.

As you can see from the script, I pick up a lot of the information from a text file in /tmp
You will need to gather this information depending upon your own needs and environment

## Caveats

There is some pretty basic error checking, feel free to send a PR on any of the code if it can be done better or more efficiently

Your web server must have access to write to your Munki repository. I suggest combining SSL and Basic Authentication (you're doing this anyway, right?) on your Munki repository to help keep nefarious things out. To do this, edit the CURL command in munki_enroll.sh to include the following flag:

	--user "USERNAME:PASSWORD;" 

## License

Munki Enroll, like the contained CFPropertyList project, is published under the [MIT License](http://www.opensource.org/licenses/mit-license.php).
