[![TR](https://github.com/domainreseller/wisecp-dna/assets/118720541/3ae7f50e-2763-4bf9-8060-c3dd3e321ff9)](README.md)
TR | [![EN](https://github.com/domainreseller/wisecp-dna/assets/118720541/654290e2-e8a0-40f8-b816-59fe7ae94418)](README-EN.md)
EN | [![AZ](https://github.com/domainreseller/wisecp-dna/assets/118720541/c5b30741-8f16-4f89-901e-37d63e9376a7)](README-AZ.md)
AZ | [![DE](https://github.com/domainreseller/wisecp-dna/assets/118720541/c2416f16-08c2-433e-b22b-f8b72c979090)](README-DE.md)
DE | [![FR](https://github.com/domainreseller/wisecp-dna/assets/118720541/a5e20dc0-d47e-4ce7-bd97-6d4ba80ddc18)](README-FR.md)
FR | [![AR](https://github.com/domainreseller/wisecp-dna/assets/118720541/8e4b474b-2be3-4323-99ff-f2e90aa4142d)](README-AR.md)
AR | [![NL](https://github.com/domainreseller/wisecp-dna/assets/118720541/ed7fe0e5-3775-40f3-bd71-c974de88a50d)](README-NL.md)
NL 

# README for Domainnameapi Module

This module is an API integration for domain names in WiseCP.

## Requirements

- WiseCP version 3 or higher is required.
- PHP version 7.4 or higher is required.
- PHP Soap extension must be enabled.

## Installation

1. Copy the "coremio" folder from the downloaded package into the folder where WiseCP is installed (e.g., /home/wisecp/public_html). Do not include the `.gitignore`, `README.md`, and `LICENSE` files.
2. Ensure that the folder structure is correct. For example: /home/wisecp/public_html/coremio/modules/Registrars/DomainNameApi/DomainNameApi.php.
3. Go to the WiseCP admin panel.
4. Navigate to Products/Services menu and select "Domain Registration".
5. Click on the "Installation" step.

![Installation Screen](https://github.com/domainreseller/wisecp-dna/assets/118720541/0cc8cca1-980e-4ae2-928a-28a809da87eb)

### Reseller User Credentials

1. Enter the reseller username and password.
2. Click the "Save" button.

### Test Connection

1. Click the "Test Connection" button to check if the connection is successfully established.

## Importing Domain TLDs

1. Click on the "Import TLDs" tab to import the domain name extensions.
2. All the extensions will be imported successfully.

## Importing Domain Names

1. Click on the "Import" tab to import the domain names.
2. You will see a list of domains. Select the domain you want to import and assign it to the desired customer. Then click the "Import" button.

That's it! You can now successfully use the Domainnameapi module in WiseCP.

