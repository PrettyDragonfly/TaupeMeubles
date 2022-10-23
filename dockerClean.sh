#!/bin/bash

#faut executer ça dans le dossier du projet

sudo docker-compose down
sudo docker prune -a
sudo docker rmi $(sudo docker images -a -q) -f
sudo docker-compose up -d --build