# language: fr
Fonctionnalité: Ajouter un article

Contexte: Je suis un administrateur qui veut ajouter un article

Soit je suis sur "login"
Lorsque je remplis "Nom d'utilisateur :" avec "alexandre"
Et je remplis "Mot de passe :" avec "test"
Et je presse "Connexion"
Alors je suis sur la page d'accueil
Et je ne devrais pas voir "Exception detected!"
Soit je suis "Admin"
Et je suis "Articles"
Alors je devrais voir "Liste des articles"

@new_article
Scénario: Je veux ajouter un article
    Et je suis "Ajouter un article"
    Lorsque je remplis le texte suivant:
        | lrt_cmsbundle_articletype_title        | Nouvelle article du site behat    |
        | lrt_cmsbundle_articletype_content      | is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.  |
        | lrt_cmsbundle_articletype_status       | IMMEDIATE            |
        | lrt_cmsbundle_articletype_isPublic     | 1            |
        | lrt_cmsbundle_articletype_category     | 1            |
    Et je presse "Valider"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeArticles" :
        | * | Nouvelle article du site behat | * | Actualités | * | *   |