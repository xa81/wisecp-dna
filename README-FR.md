[[TR ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/3ae7f50e-2763-4bf9-8060-c3dd3e321ff9)]](README.md)
| [[EN ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/654290e2-e8a0-40f8-b816-59fe7ae94418)]](README-EN.md)
| [[AZ ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/c5b30741-8f16-4f89-901e-37d63e9376a7)]](README-AZ.md)
| [[DE  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/c2416f16-08c2-433e-b22b-f8b72c979090)]](README-DE.md)
 | [[FR  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/a5e20dc0-d47e-4ce7-bd97-6d4ba80ddc18)]](README-FR.md)
 | [[AR  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/8e4b474b-2be3-4323-99ff-f2e90aa4142d)]](README-AR.md)
 | [[NL  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/ed7fe0e5-3775-40f3-bd71-c974de88a50d)]](README-NL.md)

# Guide d'utilisation du module Domainnameapi

Ce module est une intégration de 'domainnameapi.com' pour WiseCP.


## Prérequis

- WiseCP version 3 ou supérieure est requise.
- PHP version 7.4 ou supérieure est requise.
- L'extension PHP Soap doit être activée.

## Installation

1. Copiez le dossier "coremio" contenu dans le dossier que vous avez téléchargé à l'intérieur du dossier d'installation de WiseCP (Exemple : /home/wisecp/public_html). Ne copiez pas les fichiers `.gitignore`, `README.md` et `LICENSE`.
2. Assurez-vous que la structure du dossier est correcte (Exemple : /home/wisecp/public_html/coremio/modules/Registrars/DomainNameApi/DomainNameApi.php).
3. Accédez au panneau d'administration de WiseCP.
4. Accédez au menu Produits/Services et sélectionnez "Enregistrement de domaine".
5. Cliquez sur l'étape d'installation.

![Capture d'écran de l'installation](https://github.com/domainreseller/wisecp-dna/assets/118720541/0cc8cca1-980e-4ae2-928a-28a809da87eb)

### Informations de l'utilisateur revendeur

1. Entrez le nom d'utilisateur et le mot de passe du revendeur.
2. Cliquez sur le bouton "Enregistrer".

### Test de la connexion

1. Cliquez sur le bouton "Tester la connexion" pour vérifier si la connexion a été établie avec succès.

## Importation des TLD de domaine

1. Cliquez sur l'onglet "Importer les TLD" pour importer les extensions de noms de domaine.
2. Toutes les extensions seront importées avec succès.

## Importation des noms de domaine

1. Cliquez sur l'onglet "Importer" pour afficher les noms de domaine.
2. Vous verrez une liste des domaines disponibles. Sélectionnez le domaine que vous souhaitez importer et associez-le au client souhaité, puis cliquez sur le bouton "Importer".

C'est tout ! Vous pouvez maintenant utiliser le module Domainnameapi avec succès dans WiseCP.
