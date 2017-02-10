#!/bin/bash

wget --save-cookies cookies.txt --keep-session-cookies --post-data 'submit=Start%20session' --delete-after https://www.fried-air.com/merchant/login -O step1.txt
wget --load-cookies cookies.txt https://www.fried-air.com/merchant --post-data 'action=Directory%20Request%20' -O step2.txt
wget --load-cookies cookies.txt https://www.fried-air.com/merchant --post-data 'action=Transaction%20Request&issuer=INGBNL2A&service=0&language=en&expiration=PT5M&loa=loa2' -O step3.txt
wget --load-cookies cookies.txt https://www.fried-air.com/merchant --post-data 'action=Redirect%20to%20issuer...' --max-redirect=0 -O step4.txt

sudo cp hosts-manipulated /private/etc/hosts ; dscacheutil -flushcache

# Here comes the next code

sudo cp hosts-original /private/etc/hosts ; dscacheutil -flushcache
