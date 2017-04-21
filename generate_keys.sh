#!/bin/sh

rm activationcodes.txt -f
#echo > activationcodes.txt

for i in `cat licenses`;

do

echo $i;

echo > payload

echo \{ >> payload
echo \"ownerId\"\ :\ 701737563\,>>payload
echo  \"items\"\ :\ \[ >>payload
echo     \{>>payload
echo       \"item\"\ :\ \"$i\">>payload
echo     \}>>payload
echo   \]>>payload
echo \}\;>>payload;

curl -v -Li -X POST \
--user "LOGIN:PASSWORD" \
-H "Content-Type: application/json; charset=UTF-8" \
 "https://ka.demo.plesk.com:7050/jsonrest/business-partner/30/keys?return-key-state=true" \
-d@payload >> activation.txt

done


grep -i Code activation.txt |awk -F\" '{print $16}' >>activationcodes.txt

rm activation.txt  -f
rm payload -f
