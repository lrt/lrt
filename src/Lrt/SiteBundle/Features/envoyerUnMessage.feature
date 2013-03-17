# language: fr
Fonctionnalité: Envoyer un message sur la page de contact

Contexte: Je souhaite envoyer un message depuis la page de contact

Soit je vais sur "/contact"

@contact
Scénario: J'envoie un nouveau message
    Lorsque je remplis le texte suivant:
        | contact_name     | Behat               |
        | contact_email    | behat@gmail.com     |
        | contact_subject  | Question behat ?    |
        | contact_body     | is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged  |
    Et je presse "Envoyer"
    #Et je devrais voir "Votre email a été envoyé."