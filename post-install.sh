#!/bin/bash

/usr/sbin/plesk bin ip_ban --enable

for i in `cat jails`;
do
/usr/sbin/plesk bin ip_ban --enable-jails $i;
done
