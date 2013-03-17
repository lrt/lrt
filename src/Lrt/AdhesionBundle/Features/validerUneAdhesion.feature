# language: fr
Fonctionnalité: Valider une demande d'adhésion

Contexte: Je suis un administrateur et je voudrais valider une demande d'adhésion

    Soit je suis sur "login"
    Lorsque je remplis "username" avec "julien"
    Et je remplis "password" avec "test"
    Et je presse "Connexion"
    Alors je suis "Mon Compte"
    Et je suis "Adhérents"
    Alors je devrais voir "Adhérents"

@adhesion
Scénario: Je rejette une nouvelle demande d'adhésion
    Et je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | * | brigitte | durand | brigitte.durand@gmail.com | * | * | * |
    Soit je clique sur le lien "Valider" contenu dans la ligne "3" du tableau "tListeUsers"
    Alors je devrais voir "La demande d'adhésion a été validé."