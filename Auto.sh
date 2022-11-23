#!/bin/bash
#Script Develop for Ing.Kenny Ortiz




wget https://github.com/kenny2223/Auto_Generator/blob/main/Auto.tar.gz?raw=true -O Auto.tar.gz

tar -xvzf Auto.tar.gz

cd Auto


#make the menu.xml
cat << EOF > menu.xml 
<?xml version="1.0" encoding="UTF-8"?>
<module>
<menulist>
<menuitem parent="" module="no" link="" menuid="Generator" desc="Generator" order="23" />
<menuitem parent="Generator" module="yes" link="" menuid="Auto" desc="Auto_Generator" order="1"/>
</menulist>
</module>
EOF

issabel-menumerge ./menu.xml
rm -f ./menu.xml

#Copy  all modules to /var/www/html/modules/ de isabell
cp -r ./Modulos/* /var/www/html/modules/

cd ..

rm -rf A*





































