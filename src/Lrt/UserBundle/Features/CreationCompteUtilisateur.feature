# language: fr
Fonctionnalité: Création de compte utilisateur

Contexte: Non loggué
    Soit je suis sur "register"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Nom d'utilisateur :   | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | c##15klmdf            |
            | Vérification :        | c##15klmdf            |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Nom d'utilisateur"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Nom d'utilisateur :   | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | c##iiKLmdf            |
            | Vérification :        | c##iiKLmdf            |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Nom d'utilisateur"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Nom d'utilisateur :   | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | cdd15KLmdf            |
            | Vérification :        | cdd15KLmdf            |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Nom d'utilisateur"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Nom d'utilisateur :   | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | C##15KLMDF            |
            | Vérification :        | C##15KLMDF            |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Nom d'utilisateur"

@new
Scénario: Je crée un compte avec un mauvais mot de passe
    Lorsque je remplis le texte suivant:
            | Nom d'utilisateur :   | francoislefrançais    |
            | Adresse e-mail :      | francois@puregaz.com  |
            | Mot de passe :        | C##15lm               |
            | Vérification :        | C##15lm               |

    Et je presse "Enregistrer"
    Alors je devrais voir "Ce mot de passe n'est pas valide, il doit contenir 8 carractères"
    Alors je devrais voir "Nom d'utilisateur"
