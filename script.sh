#!/bin/bash

cd $1/front/ochope/src/services/
sed -i 's/A_REMPLACER/3.228.147.122\/back/g' *

cd $1/back/public/
sed -i 's/A_REMPLACER/back/g' .htaccess


cd $1/front/ochope/
sudo rm -r nodes_modules/ dist/ package-lock.json
npm install
npm run build

exit "0"
