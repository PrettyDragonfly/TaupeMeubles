#TaupeMeubles

Pour passer à une version PHP plus récente il faut :
- Aller modifier la version dans le fichier docker-compose.yml (par exemple : image: php:7.2-apache)

Après ça des problèmes liés à mysqli vont apparaître sur la page principale

Pour résoudre ces problèmes il faut faire : 
- sudo docker ps -a 
- récupérer l'ID du containeur php-apache qui tourne sous la nouvelle version
- sudo docker exec -ti <ID> sh (exemple : sudo docker exec -ti 626c9b550e9e sh)
- docker-php-ext-install mysqli
- docker-php-ext-enable mysqli (normalement il s'active automatique donc cette commande peut etre innutile)
- apachectl restart (commande aussi potentiellement innutile)
  
 Voilà !!! Retourner sur la page et actualiser (si besoins refaire un docker-compose up -d)
 Désolé pour les fautes d'orthographes :)
  
 
