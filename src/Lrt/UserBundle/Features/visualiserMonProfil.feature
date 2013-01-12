# language: fr
Fonctionnalité: Profil d'un utilisateur

Contexte: Je suis un utilisateur et je voudrais voir mon profil

    Soit je suis sur "login"
    Lorsque je remplis "Nom d'utilisateur :" avec "alexandre"
    Et je remplis "Mot de passe :" avec "test"
    Et je presse "Connexion"
    Alors je suis sur la page d'accueil
    Et je ne devrais pas voir "Exception detected!"
    Soit je suis "Admin"

@profile_user
Scénario: Je voudrais modifier mon profil

