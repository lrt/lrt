# language: fr
Fonctionnalité: filtre sur les utilisateurs

Contexte: Je suis un administrateur qui recherche des utilisateurs

    Soit je suis sur "login"
    Lorsque je remplis "username" avec "alexandre"
    Et je remplis "password" avec "test"
    Et je presse "Connexion"
    Alors je suis "Utilisateurs"
    Et je devrais voir "Utilisateurs"

#@filtre_user
#Scénario: Je recherche un utilisateur par son login
#
#    Lorsque je remplis le texte suivant:
#        | userbundle_userfiltertype_login |  alexandre  |
#    Et je presse "Filtrer"
#    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
#        | * | alexandre | * | * | * | * | * | * |

@filtre_user
Scénario: Je recherche un utilisateur par son email

    Lorsque je remplis le texte suivant:
        | userbundle_userfiltertype_email |  julien.morelle@longchamp-roller-team.com  |
    Et je presse "Filtrer"
    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | * | * | * | julien.morelle@longchamp-roller-team.com | * | * | * | * |

#@filtre_user
#Scénario: Je recherche un utilisateur par son nom
#
#    Lorsque je remplis le texte suivant:
#        | userbundle_userfiltertype_nom |  dubosc  |
#    Et je presse "Filtrer"
#    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
#        | * | * | dubosc | * | * | * | * | * |

#@filtre_user
#Scénario: Je filtre la liste des utilisateurs par status (actif)
#
#    Lorsque je remplis le texte suivant:
#        | userbundle_userfiltertype_status |  1  |
#    Et je presse "Filtrer"
#    Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
#        | * | alexandre | seiller | * | * | * | * | * |
#    Et je ne devrais pas voir les lignes suivantes dans le tableau "tListeUsers" :
#        | * | nicolas | durand | * | * | * | * | * |

#@filtre_user
#Scénario: Je recherche tous les administrateurs
#
#   Lorsque je remplis le texte suivant:
#       | userbundle_userfiltertype_type |  ROLE_ADMIN  |
#   Et je presse "Filtrer"
#   Alors je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
#       | * | alexandre | seiller | * | * | * | * | * |
#   Et je ne devrais pas voir les lignes suivantes dans le tableau "tListeUsers" :
#       | * | nicolas | durand | * | * | * | * | * |