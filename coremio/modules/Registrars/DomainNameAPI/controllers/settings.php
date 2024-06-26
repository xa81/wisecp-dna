<?php
if (!defined("CORE_FOLDER")) {
    die();
}

$lang           = $module->lang;
$config         = $module->config;
$soap_installed = class_exists("SoapClient");

if (!$soap_installed) {
    die(Utility::jencode([
        'status'  => "error",
        'message' => $lang["error7"],
    ]));
}

$username = Filter::POST("username", "hclear");
$password = Filter::POST("password", "hclear");
if ($password && $password != "*****") {
    $password = Crypt::encode($password, Config::get("crypt/system"));
}
$whidden_amount = Filter::POST("whidden-amount", "amount");
$whidden_curr   = Filter::POST("whidden-currency", "numbers");
$test_mode      = Filter::POST("test-mode", "numbers");
$adp            = Filter::POST("adp", "numbers");
$cost_cid       = Filter::POST("cost-currency", "numbers");
$exclude = Filter::POST("exclude", "hclear");

$sets = [];

if ($username !== false && $username != $config["settings"]["username"]) {
    $sets["settings"]["username"] = $username;
}

if ($password !== false && $password != "*****" && $password != $config["settings"]["password"]) {
    $sets["settings"]["password"] = $password;
}

if ($whidden_amount !== false && (float)$whidden_amount != $config["settings"]["whidden-amount"]) {
    $sets["settings"]["whidden-amount"] = (float)$whidden_amount;
}

if ($whidden_curr !== false && (int)$whidden_curr != $config["settings"]["whidden-currency"]) {
    $sets["settings"]["whidden-currency"] = (int)$whidden_curr;
}

if ($test_mode !== false && (int)$test_mode != $config["settings"]["test-mode"]) {
    $sets["settings"]["test-mode"] = (int)$test_mode;
}

if ($adp !== false && (!isset($config["settings"]["adp"]) || (bool)(int)$adp != $config["settings"]["adp"])) {
    $sets["settings"]["adp"] = (bool)(int)$adp;
}

if ($cost_cid !== false && (!isset($config["settings"]["cost-currency"]) || (int)$cost_cid != $config["settings"]["cost-currency"])) {
    $sets["settings"]["cost-currency"] = (int)$cost_cid;
}

if ($exclude !== false && $exclude != $config["settings"]["exclude"]) {
    $sets["settings"]["exclude"] = $exclude;
}


$profit_rate = Filter::POST("profit-rate", "amount");
if($profit_rate !== false ) {
    $export      = Utility::array_export(Config::set("options", ["domain-profit-rate" => (float)$profit_rate]), ['pwith' => true]);
    FileManager::file_write(CONFIG_DIR . "options.php", $export);
}

if ($sets) {
    $config_result = array_replace_recursive($config, $sets);
    $array_export  = Utility::array_export($config_result, ['pwith' => true]);
    $file          = dirname(__DIR__) . DS . "config.php";
    $write         = FileManager::file_write($file, $array_export);

    $adata = UserManager::LoginData("admin");
    User::addAction($adata["id"], "alteration", "changed-registrars-module-settings", [
        'module' => $config["meta"]["name"],
        'name'   => $lang["name"],
    ]);
}

echo Utility::jencode([
    'status'  => "successful",
    'message' => $lang["success1"],
    'sets'=> $sets
]);
