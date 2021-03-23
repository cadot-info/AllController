#!/bin/bash

#si pas d'arguments on install

if [ $# = 0 ]; then
    echo -n "You can install:\n -install=> install AllController \n -entity=> entity name\n -crud=> crud name \n "
fi
if [ "$1" = "install" ]; then
    #Installation des fichiers
    mkdir temp_AllC
    cd temp_AllC
    wget https://github.com/eldinomick/AllController/archive/refs/heads/master.zip
    unzip master.zip
    cd AllController-master
    cp AllController.php ../../src/Controller/.
    mkdir ../../src/Twig -p
    cp ObjetPropertiesExtension.php ../../src/Twig/.
    cp all ../../templates/. -R

    cd ../..
    rm temp_AllC -R
fi
if [ "$1" = "entity" ]; then
    # install a entity
    nom="$2"
    min=$(echo "$nom" | tr '[:upper:]' '[:lower:]')
    echo -n "Install the entity $2 Y/N : (respect capitalize)"
    read ouinon
    if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then
        #add Repository
        sed -i 's/namespace\sApp\\Controller;/namespace App\\Controller;\nuse App\\Repository\\'$2'Repository;/' src/Controller/AllController.php
        #add in construct
        sed -i 's/public\sfunction __construct(/protected $'$min';\n $this\-\>'$min' = $'$min'; \n public function __construct('$2'Repository $'$min',/' src/Controller/AllController.php
        echo -n "\n>>>>Edit the AppController and fix error\n\n"
    elif
        [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]
    then
        echo "Ok, bye! "
    else
        echo "Il faut taper Y ou N!! Pas $ouinon"
    fi
fi
if [ "$1" = "crud" ]; then
    nom="$2"
    min=$(echo "$nom" | tr '[:upper:]' '[:lower:]')
    rm src/Controller/$2Controller.php
    rm src/Form/$2Type.php
    rm templates/$min -R
    php bin/console make:crud $2
    rm templates/$min -R
    rm src/Controller/$2Controller.php
fi
