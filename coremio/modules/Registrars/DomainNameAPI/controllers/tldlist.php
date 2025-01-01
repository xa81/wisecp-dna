<?php
if (!defined("CORE_FOLDER")) {
    die();
}
/** @var $module DomainNameAPI */

$lang = $module->lang;

$draw   = (int)Filter::POST("draw");
$start  = (int)Filter::POST("start");
$length = (int)Filter::POST("length");

try{
    $tlds = $module->list_tlds();
}catch (Exception $e) {
    $tlds=[];
}


if(!is_array($tlds['tlds'])) {
    $tlds['tlds'] = [];
}


// Sıralama işlevi
usort($tlds['tlds'], function($a, $b)  {

    $priorityTlds = [
        'com', 'net', 'org', 'bio', 'eu', 'hu', 'ca', 'info', 'biz', 'tk', 'rocks',
        'ninja', 'istanbul', 'ist', 'online', 'name', 'store', 'tech', 'shop',
        'moda', 'hosting', 'tv', 'wiki', 'io', 'xyz', 'tel', 'blog', 'club',
        'market', 'gen.tr', 'web.tr', 'com.tr', 'org.tr', 'net.tr', 'biz.tr',
        'cn', 'k12.tr', 'site', 'co.uk', 'de', 'icu', 'me', 'mobi', 'nl', 'ru',
        'top', 'tw', 'cloud', 'us', 'vip', 'ARMY', 'LLC'
    ];

    $posA = array_search($a['tld'], $priorityTlds);
    $posB = array_search($b['tld'], $priorityTlds);

    // Eğer her ikisi de öncelikli TLD listesinde varsa, sıralamayı öncelik sırasına göre yap
    if ($posA !== false && $posB !== false) {
        return $posA - $posB;
    }

    // Eğer sadece biri öncelikli TLD listesinde varsa, o öne geçer
    if ($posA !== false) return -1;
    if ($posB !== false) return 1;

    // Eğer her ikisi de öncelikli TLD listesinde değilse, alfabetik olarak sıralar
    return strcmp($a['tld'], $b['tld']);
});

echo Utility::jencode([
    'draw'            => $draw,
    'data'            => $tlds['tlds'],
    'recordsTotal'    => count($tlds['tlds']),
    'recordsFiltered' => count($tlds['tlds']),
]);



