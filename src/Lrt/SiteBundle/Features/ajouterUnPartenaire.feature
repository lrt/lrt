# language: fr
Fonctionnalité: Ajouter un partenaire

Contexte: Je suis un administrateur qui veut ajouter un partenaire

    Soit je suis sur "login"
    Lorsque je remplis "username" avec "alexandre"
    Et je remplis "password" avec "test"
    Et je presse "Connexion"
    Alors je suis "Partenaires"
    Et je devrais voir "Partenaires"

@partner
Scénario: Je veux ajouter un partenaire
    Et je suis "Ajouter un partenaire"
    Lorsque je remplis le texte suivant:
        | lrt_sitebundle_partnertype_name         | Nouveau partenaire behat   |
        | lrt_sitebundle_partnertype_description  | is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged            |
        | lrt_sitebundle_partnertype_website      | http://www.mypartner.fr    |
    Et j' attache le fichier "image.jpeg" à "lrt_sitebundle_partnertype_picture"
    Et je presse "Valider"