# language: fr
Fonctionnalité: Ajouter une vidéo

Contexte: Je suis un administrateur qui veut ajouter une vidéo

Soit je suis sur "login"
Lorsque je remplis "username" avec "alexandre"
Et je remplis "Mot de passe :" avec "test"
Et je presse "Connexion"
Alors je suis "Mon Compte"
Et je suis "Vidéos"
Alors je devrais voir "Vidéos"

@new_event
Scénario: Je veux ajouter une vidéo
    Et je suis "Ajouter une vidéo"
    Lorsque je remplis le texte suivant:
        | lrt_videobundle_videotype_title         | Nouvelle video - test behat   |
        | lrt_videobundle_videotype_description   | is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged  |
        | lrt_videobundle_videotype_isPublished   | 0                              |
        | lrt_videobundle_videotype_isHighlighted | 0                              |
    Et je presse "Valider"