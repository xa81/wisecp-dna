<?php
if (!defined("CORE_FOLDER")) {
    die();
}
/** @var $module DomainNameAPI */

$lang = $module->lang;
//datatable post fields

$draw   = (int)Filter::POST("draw");
$start  = (int)Filter::POST("start");
$length = (int)Filter::POST("length");
$invalidation = (int)Filter::POST("invalidate");
$search = Filter::POST("search")['value'];

$pageLength = $length;
$pageNumber = $start / $pageLength;

$domains = $module->domainsdt($pageNumber, $pageLength,$search, $invalidation);

echo Utility::jencode([
    'draw'            => $draw,
    'data'            => is_array($domains['data'])? $domains['data'] : [],
    'recordsTotal'    => is_array($domains['data'])?$domains['total']:0,
    'recordsFiltered' =>is_array($domains['data'])?$domains['total']:0,
]);



