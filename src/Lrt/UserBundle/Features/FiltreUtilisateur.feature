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
    Et je suis "Liste"
    Alors je devrais voir "Gestion des utilisateurs"

@filtre_user
Scénario: Je recherche un utilisateur par son login

    Lorsque je remplis le texte suivant:
        | Login |  alexandre  |
    Et je presse "afficher"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | alexandre | * | alexandre.seiller@longchamp-roller-team.com | admin | * | * |

@filtre_user
Scénario: Je recherche un utilisateur par son email

    Lorsque je remplis le texte suivant:
        | Email |  julien.morelle@longchamp-roller-team.com  |
    Et je presse "afficher"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | julien | * | julien.morelle@longchamp-roller-team.com | admin | * | * |

@filtre_user
Scénario: Je recherche un utilisateur par son nom

    Lorsque je remplis le texte suivant:
        | Nom |  dubosc  |
    Et je presse "afficher"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | jeremy | * | jeremy.dubosc@longchamp-roller-team.com | admin | * | * |

@filtre_user
Scénario: Je recherche tous les administrateurs

    Lorsque je remplis le texte suivant:
        | Type |  ROLE_ADMIN  |
    Et je presse "afficher"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | alexandre | * | alexandre.seiller@longchamp-roller-team.com | admin | * | * |
    Et je ne devrais pas voir les lignes suivantes dans le tableau "tListeUsers" :
        | test | * | test@longchamp-roller-team.com | * | non activé | * |