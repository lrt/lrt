# language: fr
Fonctionnalité: Demande d'inscription a la muette 23 Juin 2013.

Contexte: Non loggué - Inscription
    Soit je vais sur "/information/challenge-idf-competition-muette-2013"
    Alors je devrais voir "Le Challenge Piste de La Muette - Paris 16ème arrondissement"
    Et je suis "Inscription directement sur le site"

@new_inscription_competition
Scénario: Je suis Thomas et je m'inscris à la compétition
    Alors je devrais voir "Inscription - Challenge Piste de La Muette"
    Lorsque je remplis le texte suivant:
        | form_firstName   | Thomas                   |
        | form_lastName    | Andrei                   |
        | form_address     | 85 rue des champs        |
        | form_zipCode     | 75010                    |
        | form_city        | Paris                    |
        | form_birthday    | 01/10/1985               |
        | form_gender      | m                        |
        | form_phone       | 0658114422               |
        | form_email       | thomas.andrei@gmail.com  |
    Et je presse "Valider"
    Alors je devrais voir "Votre inscription a bien été prise en compte. A bientot"