# language: fr
Fonctionnalité: Création de compte utilisateur

Contexte: Non loggué
    Soit je suis sur "register"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Username :            | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | c##15klmdf            |
            | Vérification :        | c##15klmdf            |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Username"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Username :            | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | c##iiKLmdf            |
            | Vérification :        | c##iiKLmdf            |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Username"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Username :            | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | cdd15KLmdf            |
            | Vérification :        | cdd15KLmdf            |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Username"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Username :            | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | C##15KLMDF            |
            | Vérification :        | C##15KLMDF            |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Username"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Username :            | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | C##15lm               |
            | Vérification :        | C##15lm               |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Username"

@new
Scénario: Je suis François et je crée un compte avec un mot de passe OK et je ne peux pas me loguer car le compte est inactif
    Lorsque je remplis le texte suivant:
            | Username :            | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | c##15KLmdf            |
            | Vérification :        | c##15KLmdf            |

    Et je presse "Enregistrer"
    Alors ne devrais pas voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je ne devrais pas voir "Username"

    Soit je suis sur "login"
    Lorsque je remplis "Nom d'utilisateur :" avec "francoislefrançais"
    Et je remplis "Mot de passe :" avec "c##15KLmdf"
    Et je presse "Connexion"
    Alors je suis sur "login"
    Et je ne devrais pas voir "francois@puregaz.com"
    