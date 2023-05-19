[![TR](https://github.com/domainreseller/wisecp-dna/assets/118720541/3ae7f50e-2763-4bf9-8060-c3dd3e321ff9)](README.md)
TR | [![EN](https://github.com/domainreseller/wisecp-dna/assets/118720541/654290e2-e8a0-40f8-b816-59fe7ae94418)](README-EN.md)
EN | [![AZ](https://github.com/domainreseller/wisecp-dna/assets/118720541/c5b30741-8f16-4f89-901e-37d63e9376a7)](README-AZ.md)
AZ | [![DE](https://github.com/domainreseller/wisecp-dna/assets/118720541/c2416f16-08c2-433e-b22b-f8b72c979090)](README-DE.md)
DE | [![FR](https://github.com/domainreseller/wisecp-dna/assets/118720541/a5e20dc0-d47e-4ce7-bd97-6d4ba80ddc18)](README-FR.md)
FR | [![AR](https://github.com/domainreseller/wisecp-dna/assets/118720541/8e4b474b-2be3-4323-99ff-f2e90aa4142d)](README-AR.md)
AR | [![NL](https://github.com/domainreseller/wisecp-dna/assets/118720541/ed7fe0e5-3775-40f3-bd71-c974de88a50d)](README-NL.md)
NL 

# Handleiding voor het gebruik van de Domainnameapi-module

Deze module is een API-integratie voor domeinnamen voor WiseCP.

## Vereisten

- WiseCP versie 3 of hoger is vereist.
- PHP versie 7.4 of hoger is vereist.
- De PHP Soap-extensie moet geactiveerd zijn.

## Installatie

1. Plaats de "coremio" map uit de gedownloade map binnen de WiseCP-installatiemap (Bijvoorbeeld: /home/wisecp/public_html). Plaats de bestanden `.gitignore`, `README.md` en `LICENSE` niet.
2. Controleer of de mapstructuur correct is (Bijvoorbeeld: /home/wisecp/public_html/coremio/modules/Registrars/DomainNameApi/DomainNameApi.php).
3. Ga naar het beheerderspaneel van WiseCP.
4. Ga naar het menu Producten/Diensten en selecteer "Domeinregistratie".
5. Klik op de installatiestap.

![Screenshot van de installatie](https://github.com/domainreseller/wisecp-dna/assets/118720541/0cc8cca1-980e-4ae2-928a-28a809da87eb)

### Informatie voor resellergebruiker

1. Voer de gebruikersnaam en wachtwoord van de reseller in.
2. Klik op de knop "Opslaan".

### Verbinding testen

1. Klik op de knop "Verbinding testen" om te controleren of de verbinding succesvol tot stand is gebracht.

## Importeren van domein TLD's

1. Klik op het tabblad "TLD's importeren" om de domeinnaamextensies te importeren.
2. Alle extensies worden succesvol geïmporteerd.

## Importeren van domeinnamen

1. Klik op het tabblad "Importeren" om de domeinnamen te bekijken.
2. U ziet een lijst met beschikbare domeinen. Selecteer het domein dat u wilt importeren en wijs het toe aan de gewenste klant, en klik vervolgens op de knop "Importeren".

Dat is alles! U kunt nu de Domainnameapi-module succesvol gebruiken in WiseCP.
