#!/bin/bash

for i in `head -1 activationcodes.txt`;
do
/usr/sbin/plesk bin license -i $i;
done

for j in `tail -n +2 activationcodes.txt`;
do
/usr/sbin/plesk bin license -i $j -additional-key true;
done
