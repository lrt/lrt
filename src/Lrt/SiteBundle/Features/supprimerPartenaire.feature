# language: fr
Fonctionnalité: Retirer un partenaire de la liste

Contexte: Je souhaite retirer de la liste un partenaire
    
    Soit je suis sur "login"
    Lorsque je remplis "username" avec "julien"
    Et je remplis "password" avec "test"
    Et je presse "Connexion"
    Alors je suis "Mon Compte"
    Et je suis "Partenaires"
    Alors je devrais voir "Partenaires"

@partner
Scénario: Je veux retirer un partenaire
    Et je devrais voir les lignes suivantes dans le tableau "tListePartners" :
        | Nouveau partenaire behat2 | * | * | * |
    Soit je clique sur le lien "Corbeille" contenu dans la ligne "6" du tableau "tListePartners"
    Alors je devrais voir "Partenaire retirer de la liste avec succès."