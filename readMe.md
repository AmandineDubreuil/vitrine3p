# Vitrine3p

Vitrine3p est un site internet promouvant des formations professionnelles. C'est un site vitrine dans lequel l'admin peut modifier les membres de son équipe et son catalogue de formation.

## Requirements

- PHP 8.2
- Symfony 6.3.5
- MySql

- EasyAdminBundle 4
- Vich_Uploader 2.2
- Liip_imagine 2.12


## Tokens

Tokens générés via JWT pour la vérification de l'adresse e-mail et la modification du mot de passe

## User

### Vérification adresse e-mail user

- Services JWTService.php et SendMailService.php
- dans config/package/messenger commenter # Symfony\Component\Mailer\Messenger\SendEmailMessage: async
- dans parameters de config/services.yaml mettre : app.jwtsecret: '%env(JWT_SECRET)%'
- dans env.local mettre le secret JWT
- dans env.local modifier le mailer : MAILER_DSN=smtp://localhost:1025

### Modification mdp et mdp oublié user

- Services JWTService.php et SendMailService.php

### Photos du catalogue et des membres de l'équipe

#### utilisation du bundle VichUploader pour le téléchargement des images

- dans parameters de config/services.yaml mettre :  
   - equipe_images: '/assets/uploads/equipe' - formation_images: '/assets/uploads/formation'
- dans config/packages/vich_uploader.yaml mettre les mappings
- paramétrer les entity avec un use Vich\UploaderBundle\Mapping\Annotation as Vich; #[ORM\Entity(repositoryClass: EquipesRepository::class)] #[Vich\Uploadable]
  //.... #[ORM\Column(length: 255, type:'string', nullable: true)]
  private ?string $attachment = null;

         #[Vich\UploadableField(mapping: 'equipe_images', fileNameProperty: 'attachment')]
         private ?File $attachmentFile = null;
            //...
            mettre les getter et setter qui vont bien

- dans les crud easyadmin, mettre la bonne configuration

#### utilisation du bundle liip imagine pour l'utilisation des images dans twig

- dans config/packages/liip_imagine.yaml définir les filter sets
- dans les templates, appeler les filter sets
  ex :
  `<img src="{{vich_uploader_asset(formation, 'attachmentFile') | imagine_filter('miniature')}}" alt="{{formation.titre}}">`

## Credits

Photos et images : Freepik

## License

MIT Licence
