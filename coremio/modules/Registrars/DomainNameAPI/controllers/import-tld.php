<?php
if (!defined("CORE_FOLDER")) {
    die();
}
if (!Filter::isPOST()) {
    return false;
}
/** @var $module DomainNameAPI */

$LANG  = $module->lang;

$onlytlds = Filter::POST("onlytlds");

$selected_tlds = [];
if(is_array($onlytlds)) {
    $selected_tlds = $onlytlds;
}

$apply = $module->apply_import_tlds($selected_tlds);

if ($apply) {
    echo Utility::jencode([
        'status'  => "successful",
        'message' => $LANG["success4"]
    ]);
} else {
    echo Utility::jencode([
        'status'  => "error",
        'message' => $LANG["error10"]
    ]);
}
