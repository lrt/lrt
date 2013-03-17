# language: fr
Fonctionnalité: Ajouter un evenement

Contexte: Je suis un administrateur qui veut ajouter un evenement

Soit je suis sur "login"
Lorsque je remplis "username" avec "alexandre"
Et je remplis "password" avec "test"
Et je presse "Connexion"
Alors je suis "Mon Compte"
Et je suis "Calendrier"
Alors je devrais voir "Evènements"

@new_event
Scénario: Je veux ajouter un évènement
  Et je suis "Ajouter un évènement"
  Lorsque je remplis le texte suivant:
      | lrt_calendarbundle_eventtype_title         | Nouvelle évènement du site behat   |
      | lrt_calendarbundle_eventtype_dateDeb       | 27/02/2013                         |
      | lrt_calendarbundle_eventtype_dateEnd       | 27/02/2013                         |
      | lrt_calendarbundle_eventtype_place         | Paris                              |
      | lrt_calendarbundle_eventtype_website       | http://www.myevent.com             |
      | lrt_calendarbundle_eventtype_description   | is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged            |
  Et je presse "Valider"