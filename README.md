# Adopte un compagnon

## Guide de mise en ligne

### Qu'est ce que c'est ?

**Adopte un Compagnon** est le site que j'ai choisi de réaliser pour mon passage de titre Développeur web et web mobile niveau 5.

Il s'agit d'une plateforme dédiées aux associations de défense et de protection animale. Elles peuvent s'inscrire et bénéficier d'un espace personnalisé où elles pourront :
- créer et diffuser les profils des animaux à adopter,
- consulter les demandes d'adoptions,
- gérer ses propres informations.

Les futurs adoptants peuvent parcourir le site, consulter les profils des animaux et associations et contacter l'association de l'animal qu'ils souhaitent adopter. Ils peuvent également trier les résultats de recherche avec un filtre.
 
Enfin l'admin du site à son propre backoffice afin de gérer les utilisateurs.



### Pré-requis ?

    Symfony 7.1.4
    Node.js v20.17.0
    Next.js v14.2.6


### Guide d’installation 

1. Cloner le projet via le lien git :
   `git clone https://github.com/Salome-Bx/adopte-un-compagnon-back/`

2. Ouvrir le terminal, séléctionner le dossier créé en local adopte-un-compagnon-back grâce à cd :
   `cd adopte-un-compagnon-back`

3. Installer composer grâce à la commande :
   `composer install`
   
5. Modifier les accès à la base de données dans le fichier .env 

6. Créer un fichier de migration avec la commande :
  `doctrine:make:migration`

7. Créer la base de données en faisant migrer la base de données avec :
   `doctrine:migration:migrate`

8. Lancer le serveur Symfony :
   `symfony server:start`



### Mise en ligne

#### Serveur O2Switch

1. Se connecter au backoffice de votre compte.

2. Dans "Autorisation SSH", ajouter l'IP à la liste des IPs autorisées à se connecter en SSH au serveur.

3. Ajouter un domaine en le faisant pointer vers le dossier public. 
    
4. Génèrer un certificat SSL dans "Let's Encrypt".

5. Créer une base de données avec son utilisateur associé.
    
6. Dans "Sélectionner une version de PHP" activer la version 8.2 (Symfony).


#### Préparation du site

1. Créer un dossier dédiée à la PROD.

2. Modifier le fichier nelmio_cors.yaml et mettre l'url du site front dans les CORS.

3. Mettre les informations de connexion à la BDD dans le fichier .env.

4. Executer la commande `composer dump-env prod` afin de créer le dossier .env.local.php

5. Mettre dans le dossier PROD les fichiers suivants :

* assets
* bin
* config
* migrations
* public
* src
* templates
* .env.local.php
* composer.json
* composer.lock
* importmap.php
* symfony.lock

6. Installer les dépendances sans les packages de développement avec la commande :
   `composer install --no-dev --optimize-autoloader`

7. Effacer le cache avec `php bin/console cache:clear --env=prod`.
   Puis préparer le cache pour l'environnement de production avec la commande `symfony console cache:warmup --env=prod`.

8. Créer le fichier de configuration .htaccess avec la commande `composer require symfony/apache-pack`

9. Installer l'application FileZilla et se connecter sur le serveur O2Switch en utilisant ses identifiants.

10. Téleverser les fichiers sur le serveur dans le fichier dédié au site.












    
