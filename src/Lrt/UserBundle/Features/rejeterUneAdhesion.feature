# language: fr
Fonctionnalité: Rejeter une demande d'adhésion

Contexte: Je suis un administrateur et je voudrais rejeter une demande d'adhésion

    Soit je suis sur "login"
    Lorsque je remplis "username" avec "julien"
    Et je remplis "Mot de passe :" avec "test"
    Et je presse "Connexion"
    Alors je suis "Mon Compte"
    Et je suis "Adhérents"
    Alors je devrais voir "Adhérents"

@adhesion
Scénario: Je rejette une nouvelle demande d'adhésion
    Et je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | john | doe | john.doe@gmail.com | * | * | * |
    Soit je clique sur le lien "Rejeter" contenu dans la ligne "1" du tableau "tListeUsers"
    Alors je devrais voir "La demande d'adhésion a été rejeté."