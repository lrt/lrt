# language: fr
Fonctionnalité: Ajouter un article

Contexte: Je suis un administrateur qui veut ajouter un article

    Soit je suis sur "login"
    Lorsque je remplis "username" avec "alexandre"
    Et je remplis "Mot de passe :" avec "test"
    Et je presse "Connexion"
    Alors je suis "Mon Compte"
    Et je suis "Articles"
    Alors je devrais voir "Articles"

@new_article
Scénario: Je veux ajouter un article
    Et je suis "Ajouter un article"
    Lorsque je remplis le texte suivant:
        | lrt_cmsbundle_articletype_title        | Nouvelle article du site behat    |
        | lrt_cmsbundle_articletype_content      | is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.  |
        | lrt_cmsbundle_articletype_status       | 2            |
        | lrt_cmsbundle_articletype_isPublic     | 1            |
        | lrt_cmsbundle_articletype_category     | 1            |
    Et j' attache le fichier "image.jpeg" à "lrt_cmsbundle_articletype_picture"
    Et je presse "Valider"