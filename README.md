# CpanelDynDNS

##About

Simple script to update the ip redirect for a subdomain hosted via CPanel.
Usage is if a user does NOT have access to WHM for the server, but wishes to point a subdomain to their local IP address - for example if they want to connect to their machine via remote desktop(or similar) over the internet without needing to remember the IP address of their local machine.

This could also be done in combination with another script that just goes to https://domain.com/updateIP.php.

##User guide

Only file needed is the updateIP.php
* Create a subdomain via the standard CPanel UI and assign any IP address
* Edit the 5 variables at the top: domain, subdomain, CpanelUserName, CpanelPassword, and CpanelURL
* Renaming file is recomended
* Upload the php file to your webserver.
* Browse the location
* IP address is now updated to your current address

Tested on PHP 5.6 & with CPanel 86

##Roadmap

Future work to be done involves:
* Replace the calling to CPanel with a single function instead (readability)
* Require https to be used.
* Page to get some security - currently just visiting the page will update the IP address without any prompts
* Allow the ttl to be custom set via the http get
* Allow the ip to be set via http get
* Allow the subdomain to be changed from the default
* Allow creating of new subdomains
* Create a log file of all the changes
