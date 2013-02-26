# language: fr
Fonctionnalité: Faire une demande d'adhésion

Contexte: Non loggué - Adhésion
Soit je vais sur "/user/adhesion/new"

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
        | adhesion_email       | sylvain.andreï92@gmail.com |
    Et je presse "Valider"