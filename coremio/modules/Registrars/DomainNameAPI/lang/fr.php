<?php

return [
    'name'                 => 'DomainNameAPI',
    'description'          => 'With Domainnameapi.com, one of the popular domain name registrars, all domain name transactions can be made instantaneously through the domain API. To do this, define your domainnameapi.com client account information in the following fields.',
    'importTldButton'      => 'Importer plus de 750 extensions',
    'fields'               => [
        'balance'    => "Équilibre",
        'username'   => 'Reseller Utilisateur',
        'password'   => 'Reseller Mot de passe',
        'test-mode'  => 'Test Mode',
        'privacyFee' => 'WhoIS Protection Fee',
        'adp'        => 'Update pricing automatically',
        'importTld'  => 'Import Extensions',
        'api-v2'     => "Utilisez la nouvelle version",
        'resellerid' => "ID du revendeur",
    ],
    'desc'                 => [
        'privacyFee'  => '<br>Ask for a fee for whois protection service.',
        'test-mode'   => 'Activate to process in test mode',
        'adp'         => 'Automatically pulls pricing daily and the price is set at the profit rate',
        'importTld-1' => 'Automatically import all extensions',
        'importTld-2' => 'All domain extensions and costs registered on the API will be imported collectively.',
    ],
    'tabDetail'            => 'API Information',
    'tabImport'            => 'Import',
    'testButton'           => 'Tester la connexion',
    'importNote'           => 'You can easily transfer the domain names that are already registered in provider\'s system. The imported domain names are created as an addon, domain names that are currently registered in system are marked green.',
    'importStartButton'    => 'Import',
    'saveButton'           => "Enregistrer les param\xc3\xa8tres",
    'error1'               => 'API information is not available',
    'error2'               => 'Domain and extension information are not present',
    'error3'               => 'An error occurred while retrieving the contact ID',
    'error4'               => 'Failed to get status information',
    'error5'               => 'The transfer information could not be retrieved',
    'error6'               => 'After you have processed the API provider, you can activate the status of the order',
    'error7'               => 'PHP Soap is not installed on your server. Contact your hosting provider for more information.',
    'error8'               => 'Please enter the API information',
    'error9'               => 'The import operation failed',
    'error10'              => 'An error has occurred',
    'success1'             => "R\xc3\xa9glages saved successfully",
    'success2'             => 'Connection test succeeded',
    'success3'             => 'Import completed successfully',
    'success4'             => 'Extensions were successfully imported',
    'headerImport'         => "Les noms de domaine suivants seront importés",
    'noImportDomains'      => "Aucun nom de domaine trouvé à importer.",
    'importQuestion'       => " domaine sera importé. Êtes-vous sûr?",
    'yes'                  => "Oui",
    'no'                   => "Non",
    'importProcessing'     => "Le processus d'importation est en cours...",
    'process'              => 'Processus',
    'importFinished'       => 'Processus d\'importation terminé.',
    'okey'                 => 'D\'accord',
    'tabImportTld'         => 'Importer les extensions',
    'importTldNote'        => 'Vous pouvez choisir et importer les extensions et les coûts enregistrés dans l\'API collectivement. Tous les calculs de tarification sont en USD. Pour désactiver la synchronisation automatique, sélectionnez l\'option Excl(Exclude)',
    'tld'                  => 'Extension',
    'dna'                  => 'DNA?',
    'cost'                 => 'Coût',
    'current'              => 'Vente',
    'margin'               => 'Profit',
    'register'             => 'Enregistrer',
    'renew'                => 'Renouveler',
    'transfer'             => 'Transférer',
    'noTldSelected'        => 'Aucun TLD sélectionné',
    'noTldSelectedDesc'    => 'Veuillez sélectionner un TLD à importer',
    'numofTLDSelected'     => ' vous synchronisez l\'extension, êtes-vous sûr?',
    'numofTLDSynced'       => 'Synchronisation des extensions terminée',
    'numofTLDSyncedTxt'    => 'Le processus a été complété avec succès',
    'numofTLDNotSynced'    => 'Erreur',
    'numofTLDNotSyncedTxt' => 'Une erreur est survenue. Veuillez réessayer.',
    'stillProcessing'      => 'Le processus est toujours en cours...',

];
