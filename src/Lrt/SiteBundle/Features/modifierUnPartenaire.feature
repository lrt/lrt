# language: fr
Fonctionnalité: Modifier un partenaire

Contexte: Je souhaite modifier un partenaire

    Soit je suis sur "login"
    Lorsque je remplis "username" avec "julien"
    Et je remplis "password" avec "test"
    Et je presse "Connexion"
    Alors je suis "Mon Compte"
    Et je suis "Partenaires"
    Alors je devrais voir "Partenaires"

@partner
Scénario: Je veux modifier un partenaire
    Et je devrais voir les lignes suivantes dans le tableau "tListePartners" :
        | Nouveau partenaire behat | * | * | * |
    Soit je clique sur le lien "Modifier" contenu dans la ligne "6" du tableau "tListePartners"
    Lorsque je remplis le texte suivant:
        | lrt_sitebundle_partnertype_name         | Nouveau partenaire behat2   |
        | lrt_sitebundle_partnertype_description  | is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged            |
        | lrt_sitebundle_partnertype_website      | http://www.mypartner.fr    |
    Et je presse "Modifier"