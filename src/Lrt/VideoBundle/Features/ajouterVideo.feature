# language: fr
Fonctionnalité: Ajouter une vidéo

Contexte: Je suis un utilisateur qui veut ajouter une vidéo

    Soit je suis sur "login"
    Lorsque je remplis "username" avec "alexandre"
    Et je remplis "Mot de passe :" avec "test"
    Et je presse "Connexion"
    Et je ne devrais pas voir "Exception detected!"
    Et je devrais voir "Videos"
    Et je suis "Toutes les vidéos"
    Alors je devrais voir "Liste des vidéos"

@new_video
Scénario: Je voudrais ajouter une vidéo
    Et je suis "Ajouter une vidéo"
    Lorsque je remplis le texte suivant:
            | lrt_videobundle_videotype_title          | Video Behat    |
            | lrt_videobundle_videotype_description    | Video ajouté par Behat  |
            | lrt_videobundle_videotype_isPublished    | 0            |
    Et je presse "Valider"
    Alors je devrais voir "Description"
    Alors je devrais voir "Video ajouté par Behat"
    Et je suis "Retour à la liste"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeVideos" :
        | * | * | Non publié | * | * |