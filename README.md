# Camagru
Camagru est un projet d'initiation au web realise sans aucun framework    
Ce site permet de personnaliser des photos en y superposant des miniatures a la maniere d'un photo collage    
Un espace utilisateur est a mettre en place avec certaines consignes    
Pour plus d'informations le sujet est disponible en pdf sur le repo  

## Deploiement
Pour deployer et tester le site, un docker-compose est disponible, toujours sur le repo  
Il faudra donc installer docker et entrer la commande suivante dans le repertoire docker  
```
docker-compose up
```
Ensuite, pour le bon fonctionnement du site, il faudra creer les tables a l'aide du script de setup  
Dans le repertoire config, entrez la commande
```
php setup.php
```

## Utilisation
Une fois le deploiement effectue, vous pourrez acceder en localhost au site via le port 8008 et a phpmyadmin via le port 8080  
La base de donnee est accessible sur le port 3306, le mot de passe `root` est `rootpass`  
