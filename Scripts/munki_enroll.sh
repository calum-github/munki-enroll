#!/bin/sh 
 
## Munki Enroll - Rebooted!

# Munki Server URL
munki_enroll_url="http://munki.test.internal/munki-enroll/enroll.php"

# Target volume
target_volume="/Volumes/Macintosh\ HD"


# First lets get some location information - these are used for our directories in /manifests
region=`grep description /tmp/site_information.txt | cut -f3 -d ","`
school_name=`grep description /tmp/site_information.txt | cut -f2 -d ","`
building=`awk -F "," '{print $5}' /tmp/location_details.txt | cut -c 12-`
level=`awk -F "," '{print $6}' /tmp/location_details.txt | cut -c 9-`
room=`awk -F "," '{print $7}' /tmp/location_details.txt | cut -c 8-`

# Set the names of our actual manifest files
region_manifest="_Region_${region}"
school_manifest="_School_${school_name}"
building_manifest="_Building_${building}"
level_manifest="_Level_${level}"
room_manifest="_Room_${room}"


# build our standard client identifier using the wifi mac address and the suffix M - because...reasons
wifi_mac_address=`networksetup -listallhardwareports | awk '/Hardware Port: Wi-Fi/,/Ethernet/' | awk 'NR==3' | cut -d " " -f 3 | sed s/://g`
suffix="M"
hostname="${suffix}-${wifi_mac_address}"
# Build our full client identifier path minus our hostname
client_identifier_path="${region}/${school_name}/${building}/${level}/${room}/Clients/"

# Application paths
CURL="/usr/bin/curl"
DEFAULTS="/usr/bin/defaults"

#-----------------------------------------------------------------------------------------------------------------#

# Send off our configuration to our server and let it create the directories and manifests if they don't already exist
$CURL --max-time 5 --get \
    -d client_identifier_path="$client_identifier_path" \
    -d hostname="$hostname" \
    -d region_manifest="$region_manifest" \
    -d school_manifest="$school_manifest" \
    -d building_manifest="$building_manifest" \
    -d level_manifest="$level_manifest" \
    -d room_manifest="$room_manifest" \
    -d region="$region" \
    -d school_name="$school_name" \
    -d building="$building" \
    -d level="$level" \
    -d room="$room" \
    "$munki_enroll_url"


# Now set the ClientIdentifier in the ManagedInstalls plist
$DEFAULTS write $target_volume/Library/Preferences/ManagedInstalls ClientIdentifier "${client_identifier_path}/${hostname}"
 
exit 0