# Vitrine3p

Vitrine3p est un site internet promouvant des formations professionnelles. C'est un site vitrine dans lequel l'admin peut modifier les membres de son équipe et son catalogue de formation.

## Requirements

- PHP 8.2
- Symfony 6.3.5
- MySql

- EasyAdminBundle 4

## Tokens

Tokens générés via JWT pour la vérification de l'adresse e-mail et la modification du mot de passe

## User

### Vérification adresse e-mail user
- Services JWTService.php et SendMailService.php
- dans config/package/messenger commenter   # Symfony\Component\Mailer\Messenger\SendEmailMessage: async
- dans parameters de config/services.yaml mettre : app.jwtsecret: '%env(JWT_SECRET)%'
- dans env.local mettre le secret JWT
- dans env.local modifier le mailer : MAILER_DSN=smtp://localhost:1025

### Modification mdp et mdp oublié user
- Services JWTService.php et SendMailService.php

### Photos du catalogue et des membres de l'équipe
- utilisation d'un service PictureService.php
- dans parameters de config/services.yaml mettre : images_directory: '%kernel.project_dir%/public/assets/uploads/'

## Formations

### Description d'une formation avec CKEditor5

- télécharger le dossier sur https://ckeditor.com/ckeditor-5/download/?null-addons= 
- l'installer dans public/assets/ckeditor5
- créer un fichier ckeditor.js dans assets/js
- mise en forme de la toolbar et des textes des headings dans ckeditor.js
- dans formationType.php mettre le champs description en HiddenType
- dans formation/edit.html.twig, créer le formulaire, mettre une div avec "editor" en id
- dans formation/edit.html.twig, créer un block js avec lien vers ckeditor.js du dossier ckeditor5 et du dossier js
- pour que la mise en forme apparaisse, mettre {{ formation.description | raw  }} dans formation show 

## Credits

Photos et images : Freepik

## License

MIT Licence

