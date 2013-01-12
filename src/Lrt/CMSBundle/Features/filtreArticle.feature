# language: fr
Fonctionnalité: Filtre sur la liste des articles

Contexte: Je suis un administrateur qui filtre sur la liste des articles

    Soit je suis sur "login"
    Lorsque je remplis "Nom d'utilisateur :" avec "alexandre"
    Et je remplis "Mot de passe :" avec "test"
    Et je presse "Connexion"
    Alors je suis sur la page d'accueil
    Et je ne devrais pas voir "Exception detected!"
    Soit je suis "Admin"
    Et je suis "Articles"
    Alors je devrais voir "Liste des articles"

@filtre_user
Scénario: Je recherche un utilisateur par son login

    Lorsque je remplis le texte suivant:
        | Login |  alexandre  |
    Et je presse "Filtrer"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | alexandre | * | alexandre.seiller@longchamp-roller-team.com | admin | * | * |