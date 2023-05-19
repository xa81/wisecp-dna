[[TR ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/3ae7f50e-2763-4bf9-8060-c3dd3e321ff9)]](README.md)
| [[EN ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/654290e2-e8a0-40f8-b816-59fe7ae94418)]](README-EN.md)
| [[AZ ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/c5b30741-8f16-4f89-901e-37d63e9376a7)]](README-AZ.md)
| [[DE  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/c2416f16-08c2-433e-b22b-f8b72c979090)]](README-DE.md)
 | [[FR  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/a5e20dc0-d47e-4ce7-bd97-6d4ba80ddc18)]](README-FR.md)
 | [[AR  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/8e4b474b-2be3-4323-99ff-f2e90aa4142d)]](README-AR.md)
 | [[NL  ![](https://github.com/domainreseller/wisecp-dna/assets/118720541/ed7fe0e5-3775-40f3-bd71-c974de88a50d)]](README-NL.md) 

# Anleitung zur Verwendung des Domainnameapi-Moduls

Dieses Modul ist eine Integration von 'domainnameapi.com' für WiseCP.


## Voraussetzungen

- WiseCP Version 3 oder höher wird benötigt.
- PHP Version 7.4 oder höher wird benötigt.
- Die PHP Soap-Erweiterung muss aktiviert sein.

## Installation

1. Kopieren Sie den Ordner "coremio" aus dem heruntergeladenen Ordner in das WiseCP-Installationsverzeichnis (Beispiel: /home/wisecp/public_html). Kopieren Sie die Dateien `.gitignore`, `README.md` und `LICENSE` nicht.
2. Stellen Sie sicher, dass die Ordnerstruktur korrekt ist (Beispiel: /home/wisecp/public_html/coremio/modules/Registrars/DomainNameApi/DomainNameApi.php).
3. Gehen Sie zum WiseCP-Verwaltungspanel.
4. Gehen Sie zum Menü Produkte/Dienstleistungen und wählen Sie "Domainregistrierung".
5. Klicken Sie auf den Installations-Schritt.

![Screenshot der Installation](https://github.com/domainreseller/wisecp-dna/assets/118720541/0cc8cca1-980e-4ae2-928a-28a809da87eb)

### Informationen für den Wiederverkäuferbenutzer

1. Geben Sie den Benutzernamen und das Passwort des Wiederverkäufers ein.
2. Klicken Sie auf die Schaltfläche "Speichern".

### Verbindungstest

1. Klicken Sie auf die Schaltfläche "Verbindung testen", um zu überprüfen, ob die Verbindung erfolgreich hergestellt wurde.

## Importieren von Domain-TLDs

1. Klicken Sie auf die Registerkarte "TLDs importieren", um die Domainnamenserweiterungen zu importieren.
2. Alle Erweiterungen werden erfolgreich importiert.

## Importieren von Domainnamen

1. Klicken Sie auf die Registerkarte "Importieren", um die Domainnamen anzuzeigen.
2. Sie sehen eine Liste der verfügbaren Domains. Wählen Sie die Domain aus, die Sie importieren möchten, und weisen Sie sie dem gewünschten Kunden zu, und klicken Sie dann auf die Schaltfläche "Importieren".

Das war's! Sie können das Domainnameapi-Modul jetzt erfolgreich in WiseCP verwenden.
