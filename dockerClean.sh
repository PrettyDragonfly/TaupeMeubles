#!/bin/bash

#faut executer ça dans le dossier du projet
#Attention ça supprime TOUTES les images donc si vous avez des images pour d'autres projets 

sudo docker-compose down
sudo docker prune -a
sudo docker rmi $(sudo docker images -a -q) -f
sudo docker-compose up -d --build