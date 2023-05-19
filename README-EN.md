<div align="center">  
  <a href="README.md"   >   TR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/TR.png" alt="TR" height="20" /></a>  
  <a href="README-EN.md"> | EN <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/US.png" alt="EN" height="20" /></a>  
  <a href="README-AZ.md"> | AZ <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AZ.png" alt="AZ" height="20" /></a>  
  <a href="README-DE.md"> | DE <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/DE.png" alt="DE" height="20" /></a>  
  <a href="README-FR.md"> | FR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/FR.png" alt="FR" height="20" /></a>  
  <a href="README-AR.md"> | AR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AR.png" alt="AR" height="20" /></a>  
  <a href="README-NL.md"> | NL <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/NL.png" alt="NL" height="20" /></a>  
</div>

# README for Domainnameapi Module

This module is an integration of 'domainnameapi.com' for WiseCP.


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

