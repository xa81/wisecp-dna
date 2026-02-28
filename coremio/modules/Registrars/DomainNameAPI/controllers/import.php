<?php

if (!defined("CORE_FOLDER")) {
    die();
}
/** @var $module DomainNameAPI */

$lang = $module->lang;
$data = Filter::POST("data");

if (!$data || !is_array($data)) {
    return false;
}

$results = $module->import_domain($data);

if (!empty($results)) {
    die(Utility::jencode([
        'status'  => "error",
        'message' => $lang["error9"],
        'data'    => $results,
    ]));
}


echo Utility::jencode([
    'status'  => "successful",
    'message' => $lang["success3"],
]);
