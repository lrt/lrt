# language: fr
Fonctionnalité: filtre sur les utilisateurs

Contexte: Je suis un administrateur qui recherche des utilisateurs

    Soit je suis sur "login"
    Lorsque je remplis "Nom d'utilisateur :" avec "alexandre"
    Et je remplis "Mot de passe :" avec "test"
    Et je presse "Connexion"
    Alors je suis sur la page d'accueil
    Et je ne devrais pas voir "Exception detected!"
    Soit je suis "Admin"
    Et je suis "Utilisateurs"
    Alors je devrais voir "Liste des utilisateurs"

@filtre_user
Scénario: Je recherche un utilisateur par son login

    Lorsque je remplis le texte suivant:
        | userbundle_userfiltertype_login |  alexandre  |
    Et je presse "Filtrer"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | alexandre | * | * | admin | * | * |

@filtre_user
Scénario: Je recherche un utilisateur par son email

    Lorsque je remplis le texte suivant:
        | userbundle_userfiltertype_email |  julien.morelle@longchamp-roller-team.com  |
    Et je presse "Filtrer"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | julien | * | * | admin | * | * |

@filtre_user
Scénario: Je recherche un utilisateur par son nom

    Lorsque je remplis le texte suivant:
        | userbundle_userfiltertype_nom |  dubosc  |
    Et je presse "Filtrer"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | jeremy | * | * | admin | * | * |

@filtre_user
Scénario: Je recherche tous les administrateurs

    Lorsque je remplis le texte suivant:
        | userbundle_userfiltertype_type |  ROLE_ADMIN  |
    Et je presse "Filtrer"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | alexandre | * | * | admin | * | * |
    Et je ne devrais pas voir les lignes suivantes dans le tableau "tListeUsers" :
        | test | * | * | * | non activé | * |