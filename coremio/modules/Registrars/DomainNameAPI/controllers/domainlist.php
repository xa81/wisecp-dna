<?php

if (!defined("CORE_FOLDER")) {
    die();
}
$lang = $module->lang;
//datatable post fields

$draw   = (int)Filter::POST("draw");
$start  = (int)Filter::POST("start");
$length = (int)Filter::POST("length");
$invalidation = (int)Filter::POST("invalidate");

$pageLength = $length;
$pageNumber = $start / $pageLength;

$domains = $module->domainsdt($pageNumber, $pageLength, $invalidation);

echo Utility::jencode([
    'draw'            => $draw,
    'data'            => $domains['data'],
    'recordsTotal'    => $domains['total'],
    'recordsFiltered' => $domains['total'],
]);



