#!/bin/bash

for i in `cat extensions`;
do
	/usr/sbin/plesk bin extension --install-url $i;
done
