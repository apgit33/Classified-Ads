# Classified Ads

Projet de petites annonces


## Équipe
+ Front : [Arnaud](https://github.com/Arnaud1709)
+ Back : [Adrien Paturot](https://github.com/apgit33)


## Fonctionnalités

+ Poster une annonce
+ Lister les annonces
+ Modifier une annonce
+ Supprimer une annonce


### Cycle pour poster une annonce

+ Sur la page listant les annonces afficher un lien permettant de publier une annonce	
+ Lorsque la personne arrive sur le formulaire permettant de poster une annonce elle devra saisir	
    + Adresse mail
	+ Nom
	+ Prénom
	+ Téléphone
	+ Catégorie de l'annonce : Immobilier, Auto-Moto, Emploi, Animaux, Services, Vacances, Affaires pro, Autres
    + Image de mise en avant de l'annonce (optionnel)
    + Texte de l'annonce
    + Captcha
+ Lorsque la personne poste son annonce, elle reçois un mail dans lequel il y a un lien demandant de confirmer la publication de l'annonce.
+ Dans ce même courriel, il doit y avoir un lien permettant de modifier l'annonce.
+ Une fois confirmé alors l'annonce est publiée sur la page d'annonce et l'utilisateur reçoit un courriel lui permettant supprimer l'annonce. 	
+ Lorsque l'annonce est mise en ligne il ne doit plus être possible de la modifier avec le lien du premier courriel


### Cycle pour poster une annonce

+ Au chargement de la page d'accueil on voit les dix premières annonces. Lorsque l'ascenseur est en bas de la liste, on affiche les dix annonces suivantes
+ Pour les annonces n'ayant pas d'image afficher une image par défaut	
+ Sous l'annonce on propose de télécharger l'annonce en PDF	
		


### Bonus

+ Infinite scroll pour l'affichage des annonces
+ Faire un beau courriel avec la librairie MJML		
+ Tâche cron qui supprime les annonces qui sont en attente de publication à n+2 jours de la date de création	
+ Tâche cron qui supprime les annonces qui sont publiées à n+15 jours de la date de création. Envoyer un mail à la personne de la suppression de son annonce	


**Les formulaires seront validés par JS**

## Technos

+ Composer 
+ PHP POO
+ TWIG pour le rendu frontend
+ SASS(optionnel)
+ GIT
+ JS
+ HTML
+ CSS
+ Librairie PHP pour les PDF
+ AltoRouteur pour le routeur
	
## Remarque
+ On ne veut pas de pattern MVC, on reste en programmation objet POO simple
+ Pensez à crypter les accès de validation et modification

## Initialisation
+ Changer l'initialisation du Swift_SmtpTransport par celui de votre choix dans la class "Mail.php#22"
+ Faire de même pour la clef Captcha correspondant à celle de votre api google dans "treatement/form.php#102"