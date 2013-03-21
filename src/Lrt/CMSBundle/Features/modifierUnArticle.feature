# language: fr
Fonctionnalité: Modifier un article

Contexte: Je souhaite modifier un article

    Soit je suis sur "login"
    Lorsque je remplis "username" avec "alexandre"
    Et je remplis "password" avec "test"
    Et je presse "Connexion"
    Alors je suis "Articles"
    Et je devrais voir "Articles"

@edit_article
Scénario: Je veux modifier un article
    Et je suis "Nouvelle article du site behat"
    Lorsque je remplis le texte suivant:
        | lrt_cmsbundle_articletype_title        | Nouvelle article du site behat 2   |
        | lrt_cmsbundle_articletype_content      | is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.  |
        | lrt_cmsbundle_articletype_status       | 3            |
        | lrt_cmsbundle_articletype_isPublic     | 1            |
        | lrt_cmsbundle_articletype_category     | 1            |
    Et je presse "Valider"