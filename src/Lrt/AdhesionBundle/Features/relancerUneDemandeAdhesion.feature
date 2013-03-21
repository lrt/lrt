# language: fr
Fonctionnalité: Relancer une demande d'adhésion

Contexte: Je suis un administrateur et je voudrais relancer une demande d'adhésion

    Soit je suis sur "login"
    Lorsque je remplis "username" avec "julien"
    Et je remplis "password" avec "test"
    Et je presse "Connexion"
    Alors je suis "Adhérents"
    Et je devrais voir "Adhérents"

@adhesion
Scénario: Je relance une nouvelle demande d'adhésion
    Et je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | * | nicolas | durand | nicolas.durand@gmail.com | * | * | * |
    Soit je clique sur le lien "Relancer" contenu dans la ligne "4" du tableau "tListeUsers"
    Alors je devrais voir "Votre relance a été envoyé."

@adhesion
Scénario: Je relance une nouvelle demande d'adhésion le jour même de son adhésion
    Et je devrais voir les lignes suivantes dans le tableau "tListeUsers" :
        | * | marcel | michel | marcel.michel@gmail.com | * | * | * |
    Soit je clique sur le lien "Relancer" contenu dans la ligne "6" du tableau "tListeUsers"
    Alors je devrais voir "Votre demande de relance doit être supérieur à la date de la demande."