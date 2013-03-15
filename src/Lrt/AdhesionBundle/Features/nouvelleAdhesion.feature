# language: fr
Fonctionnalité: Faire une demande d'adhésion

Contexte: Non loggué - Adhésion
Soit je vais sur "/adhesion/new"

@adhesion
Scénario: Je crée une nouvelle demande d'adhésion
    Lorsque je remplis le texte suivant:
        | adhesion_firstName   | Thomas                   |
        | adhesion_lastName    | Andrei                   |
        | adhesion_address     | 85 rue des champs        |
        | adhesion_zipCode     | 75010                    |
        | adhesion_city        | Paris                    |
        | adhesion_birthday    | 01/10/1985               |
        | adhesion_gender      | m                        |
        | adhesion_phone       | 0658114422               |
        | adhesion_email       | thomas.andrei@gmail.com  |
    Et je presse "Valider"
    Alors je devrais voir "Modifier"
    Et je devrais voir "Confirmer"
    
    Alors je suis "Confirmer"
    Alors je devrais voir "Votre demande a bien été enregistré"

@adhesion
Scénario: Je crée une nouvelle demande d'adhésion
    Lorsque je remplis le texte suivant:
        | adhesion_firstName   | Sylvain                  |
        | adhesion_lastName    | LaRotule                 |
        | adhesion_address     | 78 rue des champs        |
        | adhesion_zipCode     | 75010                    |
        | adhesion_city        | Paris                    |
        | adhesion_birthday    | 18/09/1989               |
        | adhesion_gender      | m                        |
        | adhesion_phone       | 0651134425               |
        | adhesion_email       | sylvain.andrei92@gmail.com |
    Et je presse "Valider"
    Alors je devrais voir "Modifier"
    Et je devrais voir "Confirmer"

    Alors je suis "Confirmer"
    Alors je devrais voir "Votre demande a bien été enregistré"

@adhesion
Scénario: Je crée une nouvelle demande d'adhésion et modifie une donnée
    Lorsque je remplis le texte suivant:
        | adhesion_firstName   | Pascal                   |
        | adhesion_lastName    | Dubreuil                 |
        | adhesion_address     | 19 rue de dunkerque      |
        | adhesion_zipCode     | 75010                    |
        | adhesion_city        | Paris                    |
        | adhesion_birthday    | 18/09/1989               |
        | adhesion_gender      | m                        |
        | adhesion_phone       | 0651134425               |
        | adhesion_email       | pascal.dubreuil@gmail.com |
    Et je presse "Valider"
    Alors je devrais voir "Modifier"
    Et je devrais voir "Confirmer"

    Alors je suis "Modifier"
    Lorsque je remplis le texte suivant:
        | adhesion_firstName   | Pascal                   |
        | adhesion_lastName    | Dubreuil                 |
        | adhesion_address     | 19 rue de dunkerque      |
        | adhesion_zipCode     | 75009                    |
        | adhesion_city        | Paris                    |
        | adhesion_birthday    | 18/09/1989               |
        | adhesion_gender      | m                        |
        | adhesion_phone       | 0651134425               |
        | adhesion_email       | pascal.dubreuil@gmail.com |
    Et je presse "Valider"
    
    Alors je suis "Confirmer"
    Alors je devrais voir "Votre demande a bien été enregistré"