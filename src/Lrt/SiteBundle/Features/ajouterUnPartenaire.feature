# language: fr
Fonctionnalité: Ajouter un partenaire

Contexte: Je suis un administrateur qui veut ajouter un evenement

Soit je suis sur "login"
Lorsque je remplis "username" avec "alexandre"
Et je remplis "Mot de passe :" avec "test"
Et je presse "Connexion"
Alors je suis "Mon Compte"
Et je suis "Partenaires"
Alors je devrais voir "Liste des partenaires"

@new_event
Scénario: Je veux ajouter un partenaire
    Et je vais sur "/partner/new"
    Lorsque je remplis le texte suivant:
        | lrt_sitebundle_partnertype_name         | Nouveau partenaire behat   |
        | lrt_sitebundle_partnertype_description  | is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged            |
        | lrt_sitebundle_partnertype_website      | http://www.mypartner.fr    |
    Et je presse "Valider"