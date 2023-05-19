<div align="center">  
  <a href="README.md"   >   TR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/TR.png" alt="TR" height="20" /></a>  
  <a href="README-EN.md"> | EN <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/US.png" alt="EN" height="20" /></a>  
  <a href="README-AZ.md"> | AZ <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AZ.png" alt="AZ" height="20" /></a>  
  <a href="README-DE.md"> | DE <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/DE.png" alt="DE" height="20" /></a>  
  <a href="README-FR.md"> | FR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/FR.png" alt="FR" height="20" /></a>  
  <a href="README-AR.md"> | AR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AR.png" alt="AR" height="20" /></a>  
  <a href="README-NL.md"> | NL <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/NL.png" alt="NL" height="20" /></a>  
</div>

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
