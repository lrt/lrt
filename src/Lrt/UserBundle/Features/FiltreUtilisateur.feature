# language: fr
Fonctionnalité: filtre sur les utilisateurs

@filtre_user
Scénario: Je recherche tous les utilisateurs à valider
    Soit je suis sur "login"
    Lorsque je remplis "Nom d'utilisateur :" avec "alexandre"
    Et je remplis "Mot de passe :" avec "test"
    Et je presse "Connexion"
    Alors je suis sur la page d'accueil
    Et je ne devrais pas voir "Exception detected!"
    Soit je suis "Admin"
    Et je suis "Utilisateurs"
    Alors je devrais voir "Gestion des utilisateurs"

    Lorsque je remplis le texte suivant:
        | Login |  alexandre  |
    Et je presse "afficher"
    Alors je devrais voir les lignes suivantes dans le tableau "records_list" :
        | alexandre seiller | * | admin | * | * |