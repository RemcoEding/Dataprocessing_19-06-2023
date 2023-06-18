Stap 1: downloaden
Download de zip: dataprocessing van github en pak deze uit                          
Zoek Xampp op internet op, download en installeer Xampp                                       
Zoek composer op internet op, download en installeer composer                                     
Zoek node.js op internet op, download en installeer node.js					    
Herstart pc

Stap 2: bestanden
Open xampp en start Apache en MySQL
Open de admin panel van MySQL
Maak een nieuwe database aan genaamd world, in de admin panel van MySQL
Importeer de world.sql, welke in de uitegepakte github map staat, naar de database world.    

Maak een map aan genaamd Dataprocessing in C:/xampp/htdocs
Navigeer hierna in cmd en voer het volgende commando uit:
composer require slim/slim:"4.*"

Plaats in de map C:/xampp/htdocs/Dataprocessing de puclic map en de src map vanuit de gedownloade github map
Plaats in de map C:/xampp/htdocs/Dataprocessing/vendor de inhoud van de vendor map vanuit de gedownloade github map (bin, composer, container, justingrainbow, league, nikic, pimple, psr, slim en autoload.php)

Maak een map aan genaamd vue in C:/xampp/htdocs/Dataprocessing
Navigeer in CMD naar deze map

Voer onderstaande commands uit
npm install -g @vue/cli
npm i -g @vue/cli-init
vue init webpack vcountrys
	-name vcountrys
	-simple country manager
	-Remco Eding
	-Runtime+compiler
	-cue router yes
	-Es lint no
	-unit test no
	- e2e test no
	-Test use npm
npm install --safe d3 vue-recource xml2js

Navigeer in de verkenner naar vue\vcountrys en vervang hierin de bestaande index.html voor de index.html vanuit de gedownloade github map
Kopieer de components map, app.vue en main.js vanuit de gedownloade github map en vervang de bestaande documenten in C:/xampp/htdocs/Dataprocessing/vue/vcountrys/src

Voer het commando npm run dev uit in C:/xampp/htdocs/Dataprocessing/vue/vcountrys

Stap 3:
Navigeer in de browser naar localhost:8080
