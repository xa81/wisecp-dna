<?php

if (!defined("CORE_FOLDER")) {
    die();
}
/** @var $module DomainNameAPI */

try {
    $user = $module->getDNAUser();
} catch (Exception $e) {
    $user = [
        'result' => 'ERROR',
        'error'  => [
            'Code'    => $e->getCode(),
            'Details' => $e->getMessage(),
        ],
    ];
}

$resp = [
    'loggedin' => $user["result"] == "OK",
    'message'  => $user['error']["Code"] . " : " . $user['error']["Details"],
    'lo'       => $user
];

if ($user["result"] == "OK") {
    $balance_texts = [];
    foreach ($user['balances'] as $k => $v) {
        if ($v["balance"] > 0) {
            $balance_texts[] = $v["balance"] . " " . $v["currency"];
        }
    }
    $resp['message'] = '#' . $user['id'] . ' ' . $user['name'] . ' (' . implode(", ", $balance_texts) . ')';
}


echo Utility::jencode($resp);



