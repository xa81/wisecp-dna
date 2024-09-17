<?php
if (!defined("CORE_FOLDER")) {
    die();
}
/** @var $module DomainNameAPI */

/** @var $module DomainNameAPI */

$user = $module->getDNAUser();

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
    $resp['message'] = '#'.$user['id'].' '.$user['name'].' ('.implode(", ", $balance_texts).')';
}


echo Utility::jencode($resp);



