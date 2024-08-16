# tikerama_api
Dans le contexte d'une billetterie événementielle, une API permet à des partenaires, tels que des points de vente, d'accéder aux données de manière simple et sécurisée. Les partenaires peuvent passer des commandes, recevoir des tickets, et consulter la liste des événements.

#le fonctionnalites principales
De consulter la liste des événements en cours : Pagination incluse.
De consulter la liste des types de tickets disponibles pour un événement donné.
De créer une intention de commande.
De valider une intention de commande : La réponse inclura une URL pour télécharger les tickets de la commande.
De consulter toutes les commandes effectuées par le client (utilisateur de l’API) : Pagination incluse et modification de la base de données pour intégrer cette fonctionnalité.
Page WEB
En plus de l’API, il faudra créer une page web simple permettant aux utilisateurs de faire une demande d'accès à l'API. Les utilisateurs devront fournir leurs informations personnelles : nom, prénom, entreprise, adresse email, ville, et adresse. Proposer une nouvelle table et une modification de la base de données pour cette fonctionnalité.  Après la soumission du formulaire, les identifiants nécessaires pour utiliser l'API seront envoyés par email (vous devez impérativement mettre en place cette fonctionnalité d'envoi d'email).

#fonctionnalites supplémentaires
CRUD pour les Event, TicketType, Ticket, OrderIntent, Client et autres fonctions de Lecture de donnees

#documentation de l'api
La documentation a ete faite avec knuckleswtf (scribe), elle est accessible a l'adresse suivante: 127.0.0.1:8000/docs (si le serveur est démarrer en local sur le port 8000)

#l'envoi des mail
Il faut configurer le fichier avec les informations de votre compte mail, pour etre l'expéditeur du mail.

