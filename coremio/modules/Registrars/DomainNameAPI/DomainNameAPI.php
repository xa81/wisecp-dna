<?php
/**
 * DomainNameAPI Registrar Module
 * @package    coremio/modules/Registrars/DomainNameAPI
 * @version    1.0.6
 * @since      File available since Release 7.0.0
 * @license    MIT License https://opensource.org/licenses/MIT
 * @link       https://visecp.com/
 * @author     https://visecp.com/
 * @maintainer Bünyamin AKÇAY<bunyamin@bunyam.in>
 */

class DomainNameAPI {

    /** @var $api bool|\DomainNameApi\DomainNameAPI_PHPLibrary|\DNA\Service */
    public  $api     = false;
    public  $config  = [];
    public  $lang    = [];
    public  $error   = NULL;
    public  $whidden = [];
    private $order   = [];
    private $username, $password, $tmode, $resellerId;
    private $domainCacheTTL= 1024;
    private $apiV2 = false;

    function __construct($external = []) {

        $this->config = Modules::Config("Registrars", __CLASS__);
        $this->lang   = Modules::Lang("Registrars", __CLASS__);
        if (is_array($external) && sizeof($external) > 0)
            $this->config = array_merge($this->config, $external);
        if (!isset($this->config["settings"]["username"]) || !isset($this->config["settings"]["password"])) {
            $this->error = $this->lang["error1"];
            return false;
        }

        if(isset($this->config["settings"]["api-version"]) && $this->config["settings"]["api-version"]===true){
            $this->apiV2 = true;
        }

        if ($this->apiV2 === true) {
            if (!trait_exists('DNA\ModifierTrait')) {
                $v1dir = __DIR__ . DS . 'libraries' . DS . 'v2' . DS . 'DNA' . DS;
                require_once $v1dir . 'ModifierTrait.php';
                require_once $v1dir . 'DomainTrait.php';
                require_once $v1dir . 'Client.php';
                require_once $v1dir . 'ServiceFactory.php';
                require_once $v1dir . 'SSLTrait.php';
                require_once $v1dir . 'Service.php';
            }
        } else {
            if (!class_exists("\DomainNameApi\DomainNameAPI_PHPLibrary")) {
                $v2dir = __DIR__ . DS . 'libraries' . DS . 'v1' . DS;
                include $v2dir . "api.php";
            }
        }




        if (isset($this->config["settings"]["whidden-amount"])) {
            $whidden_amount            = $this->config["settings"]["whidden-amount"];
            $whidden_currency          = $this->config["settings"]["whidden-currency"];
            $this->whidden["amount"]   = $whidden_amount;
            $this->whidden["currency"] = $whidden_currency;
        }

        $username = $this->config["settings"]["username"];
        $password = $this->config["settings"]["password"];
        $password = Crypt::decode($password, Config::get("crypt/system"));
        $tmode    = (bool)$this->config["settings"]["test-mode"];
        $resellerId = $this->config["settings"]["resellerid"];

        if (isset($this->config["settings"]["dom-cache-ttl"])) {
            $this->domainCacheTTL      = $this->config["settings"]["dom-cache-ttl"];
        }

        $this->username = $username;
        $this->password = $password;
        $this->tmode    = $tmode;
        $this->resellerId    = $resellerId;

    }

    public function setApiInstance($v2, $username, $password, $resellerId)
    {
        if ($v2 === true) {
            //OVERRIDE
            $username   = 'dnatest';
            $password   = 'Dnatest123*';
            $resellerid = '2bf2ba09-6c9d-4012-9cfe-8b4c10e7e6e5';

            $this->apiV2 = true;

            if ($this->api instanceof \DNA\Service) {
                return $this->api;
            }

            $reseller_token = $this->rememberCache('auth_token_' . md5($username . $password . $resellerid),
                function () use ($username, $password, $resellerid) {
                    $service = \DNA\ServiceFactory::createWithCredentials($username, $password, $resellerid);

                    if ($service->isAuthenticated()) {
                        return $service->getToken();
                    } else {
                        return false;
                    }
                }, 1500);

            return $this->api = \DNA\ServiceFactory::createWithToken($reseller_token, $resellerid);
        } else {
            $this->apiV2 = false;
            if ($this->api instanceof \DomainNameApi\DomainNameAPI_PHPLibrary) {
                return $this->api;
            }
            return $this->api = new \DomainNameApi\DomainNameAPI_PHPLibrary($username, $password);
        }
    }

    /**
     * Set credentials
     * @return bool
     * @throws SoapFault
     */
    private function set_credentials()
    {
        $this->api = $this->setApiInstance($this->apiV2, $this->username, $this->password, $this->resellerId);
    }


    public function set_order($order = []) {
        $this->order = $order;
        return $this;
    }

    /**
     * Set config
     * @return string
     */
    private function setConfig($username, $password, $resellerId='',$apiV2 = false) {

        $this->config["settings"]["api-version"] = $apiV2;
        $this->config["settings"]["username"]  = $username;
        $this->config["settings"]["password"]  = $password;
        $this->config["settings"]["resellerid"]  = $resellerId;

        $this->api = $this->setApiInstance($apiV2, $username, $password, $resellerId);
    }

    /**
     * Test connection
     * @param $config
     * @return bool
     */
    public function testConnection($config = [])
    {
        $username   = $config["settings"]["username"];
        $password   = $config["settings"]["password"];
        $resellerId = $config["settings"]["resellerid"];
        $apiv2      = $config["settings"]["api-version"];

        if (!$username || !$password) {
            $this->error = $this->lang["error8"];
            return false;
        }
        $password = Crypt::decode($password, Config::get("crypt/system"));

        $this->setConfig($username, $password, $resellerId, $apiv2);

        if ($apiv2) {
            $result = $this->api->getCurrentBalance();
            if ($result['success'] !== true) {
                $this->error = $result["error"]["code"] . " - " . $result["error"]["message"];
                return false;
            }
        } else {
            $check = $this->api->GetResellerDetails();

            if ($check["result"] != "OK") {
                $this->error = $check["error"]["Details"];
                return false;
            }
        }
        return true;
    }

    /**
     * Get TLDs
     * @return array
     */
    public function questioning($sld = null, $tlds = [])
    {
        $this->set_credentials();

        // Hatalı parametre kontrolü
        if (empty($sld) || empty($tlds)) {
            $this->error = $this->lang["error2"];
            return false;
        }
        $result = [];

        $cacheKey = "domain_query_" . md5(json_encode([$sld, $tlds]));

        // API v2 kontrolü
        if ($this->apiV2) {

            $response = $this->api->rememberCache($cacheKey, function () use ($sld, $tlds) {
                return $this->api->checkAvailability([$sld], $tlds);
            }, 60);

            foreach ($response as $domain) {
                if (isset($domain['info'])) {
                    $domainName  = $domain['info']['domainName'];
                    $firstDotPos = strpos($domainName, '.');
                    $sld         = substr($domainName, 0, $firstDotPos);
                    $tld         = substr($domainName, $firstDotPos);

                    $status = ($domain['info']['status'] == 'AVAILABLE') ? 'available' : 'unavailable';

                    $result[$tld] = ['status' => $status];

                    if (isset($domain['info']['isPremium']) && $domain['info']['isPremium'] == '1') {
                        $result[$tld]['premium']       = true;
                        $result[$tld]['premium_price'] = [
                            'amount'   => number_format($domain['info']['price'], 2, '.', ''),
                            'currency' => 'USD',
                        ];
                    }
                }
            }
        } else {

            $response = $this->rememberCache($cacheKey, function () use ($sld, $tlds) {
                return $this->api->CheckAvailability([$sld], $tlds, 1, "create");
            }, 60);

            foreach ($response as $domain) {
                if (isset($domain['TLD'])) {
                    $status = ($domain['Status'] == 'available') ? 'available' : 'unavailable';

                    $result[$domain['TLD']] = ['status' => $status];

                    if (isset($domain['ClassKey']) && $domain['ClassKey'] == 'premium') {
                        $result[$domain['TLD']]['premium']       = true;
                        $result[$domain['TLD']]['premium_price'] = [
                            'amount'   => number_format($domain['Price'], 2, '.', ''),
                            'currency' => $domain['Currency'],
                        ];
                    }
                }
            }
        }

        return $result;
    }



    /**
     * Register domain
     * @param $domain
     * @param $sld
     * @param $tld
     * @param $year
     * @param $dns
     * @param $whois
     * @param $wprivacy
     * @param $tcode
     * @return array|array[]|false|string[]
     */
    public function register($domain = '', $sld = '', $tld = '', $year = 1, $dns = [], $whois = [], $wprivacy = false, $tcode = NULL) {
        $this->set_credentials();

        $user = User::getInfo($this->order["owner_id"], [
                'identity',
                'company_tax_number',
                'company_tax_office'
        ]);

        $whois = $this->contactProcess($whois);
        $additional = $this->addionalFieldsProcess($domain,$whois,$user);
        $dns = array_values($dns);


        Modules::save_log("Registrars", __CLASS__, "PreRegister", [
            'domain'   => $domain,
            'year'     => $year,
            'start_at' => date('Y-m-d H:i:s'),
        ], []);

        $response = $this->api->RegisterWithContactInfo($domain, $year, $whois, $dns, false, $wprivacy, $additional);

        Modules::save_log("Registrars", __CLASS__, "Register", [
            'domain'    => $domain,
            'year'      => $year,
            'whois'     => $whois,
            'finish_at' => date('Y-m-d H:i:s'),
        ], $response);


        if ($response["result"] != "OK") {
            $this->error = $response["error"]["Message"] . " : " . $response["error"]["Details"];

            if (stristr($this->error, 'ERR_INVALID_ORGANIZATION'))
                $this->error = $this->lang["error11"];
            return false;
        }

        $status  = "SUCCESS";
        $message = NULL;


        return [
            'status'  => $status,
            'message' => $message,
            'config'  => [
                'ID' => $response["data"]["ID"],
            ],
        ];

    }

    /**
     * Renew domain
     * @param $params
     * @param $domain
     * @param $sld
     * @param $tld
     * @param $year
     * @param $oduedate
     * @param $nduedate
     * @return bool
     */
    public function renewal($params = [], $domain = '', $sld = '', $tld = '', $year = 1, $oduedate = '', $nduedate = '') {
        $this->set_credentials();
        $OrderDetails = $this->api->getDetails($domain);
        if ($OrderDetails["result"] != "OK") {
            $this->error = $OrderDetails["error"]["Details"];
            return false;
        }

        $handle = $this->api->Renew($domain, $year);

        Modules::save_log("Registrars", __CLASS__, ucfirst(__FUNCTION__), [
            'domain'    => $domain,
            'year'      => $year,
        ], $handle);

        if ($handle["result"] != "OK") {
            $this->error = $handle["error"]["Details"];
            return false;
        }

        return true;
    }


    /**
     * Transfer domain
     * @param $domain
     * @param $sld
     * @param $tld
     * @param $year
     * @param $dns
     * @param $whois
     * @param $wprivacy
     * @param $tcode
     * @return array|false
     */
    public function transfer($domain = '', $sld = '', $tld = '', $year = 1, $dns = [], $whois = [], $wprivacy = false, $tcode = '') {
        $this->set_credentials();
        /*

        validation responsibility assigned to registrar

        $detail = $this->api->GetDetails($domain);
        if ($detail["result"] == "OK") {
            $this->error = $domain . " already exists.";
            return false;
        }
        */


        $response = $this->api->Transfer($domain, $tcode, $year);

        Modules::save_log("Registrars", __CLASS__, ucfirst(__FUNCTION__), [
            'domain'    => $domain,
            'year'      => $year,
        ], $response);


        if ($response["result"] != "OK") {
            $this->error = $response["error"]["Details"];
            return false;
        }

        $this->ModifyDns(['domain' => $domain], $dns);
        $this->ModifyWhois(['domain' => $domain], $whois);

        $returnData = [
            'status'        => "SUCCESS",
            'message'       => NULL,
            'config'        => [
                'ID' => $response["data"]["ID"],
            ],
            'creation_info' => $response,
        ];

        if ($wprivacy) {
            $returnData["whois_privacy"] = [
                'status'  => $this->purchasePrivacyProtection(['domain' => $domain]),
                'message' => $this->error,
            ];
        }

        return $returnData;
    }

    /**
     * Nameserver Details
     * @param $params
     * @return array|false
     * @throws SoapFault
     */
    public function NsDetails($params = [])
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;

        $returns = [];

        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDomainDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["success"] !== true) {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            $nameservers = $domainDetail["nameservers"] ?? null;
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $nameservers = $domainDetail["data"]["NameServers"] ?? null;
        }

        if (is_array($nameservers)) {
            foreach ([0, 1, 2, 3, 4] as $v) {
                if (isset($nameservers[$v])) {
                    $returns["ns" . ($v + 1)] = $nameservers[$v];
                }
            }
        } elseif ($nameservers !== null) {
            // Tek bir nameserver varsa
            $returns["ns1"] = $nameservers;
        }


        return $returns;
    }

    /**
     * Modify Nameservers
     * @param $params
     * @param $dns
     * @return bool
     * @throws SoapFault
     */
    public function ModifyDns($params = [], $dns = [])
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;


        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDomainDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["success"] !== true) {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            $nsList = array_filter(array_values($dns), 'strlen');
            $result = $this->api->ModifyNameserver($domain, $nsList);

            if ($result["success"] !== true) {
                $this->error = $result["error"]["code"] . " - " . $result["error"]["message"];
                return false;
            }
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $newDns = [];
            foreach (array_values($dns) as $index => $dn) {
                $newDns["ns" . ($index + 1)] = $dn;
            }

            $modifyDns = $this->api->ModifyNameServer($domain, $newDns);
            if ($modifyDns["result"] != "OK") {
                $this->error = $modifyDns["error"]["Details"];
                return false;
            }
        }
        $this->invalidateCache($domainCacheKey);

        return true;
    }


    /**
     * Child Nameserver Details
     * @param array $params
     * @return bool
     */
    public function CNSList($params = [])
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;

        $result = [];

        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDomainDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["success"] !== true) {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            $childNsList = $domainDetail["hosts"] ?? [];
            foreach ($childNsList as $index => $ns) {
                $result[$index + 1] = [
                    'ns' => $ns['name'],
                    'ip' => $ns['ipAddresses'][0]['ipAddress']
                ];
            }
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $childNsList = $domainDetail["data"]["ChildNameServers"] ?? [];

            foreach ($childNsList as $index => $ns) {
                $result[$index + 1] = [
                    'ns' => $ns["ns"],
                    'ip' => $ns["ip"]
                ];
            }
        }

        return $result;
    }



    /**
     * Add Child Nameserver
     * @param $params
     * @param $ns
     * @param $ip
     * @return array|false|string[]
     */
    public function addCNS($params = [], $ns = '', $ip = '')
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;

        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDomainDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["success"] !== true) {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            $result = $this->api->addChildNameServer($domain, $ns, $ip);

            if ($result["success"] !== true) {
                $this->error = $result["error"]["code"] . " - " . $result["error"]["message"];
                return false;
            }
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $addCNS = $this->api->AddChildNameServer($domain, $ns, $ip);
            if ($addCNS["result"] != "OK") {
                $this->error = $addCNS["error"]["Details"];
                return false;
            }
        }

        $this->invalidateCache($domainCacheKey);

        return [
            'ns' => $ns,
            'ip' => $ip
        ];
    }

    /**
     * Modify Child Nameserver
     * @param $params
     * @param $cns
     * @param $ns
     * @param $ip
     * @return bool
     */
    public function ModifyCNS($params = [], $cns = [], $ns = '', $ip = '') {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;


        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDomainDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["success"] !== true) {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            if ($cns["ip"] != $ip) {
                $cns_ns = $cns["ns"];
                $result = $this->api->ModifyChildNameServer($domain, $cns_ns, $ip);
                if ($result["success"] !== true) {
                    $this->error = $result["error"]["code"] . " - " . $result["error"]["message"];
                    return false;
                }
            }

        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return true;
            }

            if ($cns["ip"] != $ip) {
                $cns_ns = $cns["ns"];
                $modify = $this->api->ModifyChildNameServer($domain, $cns_ns, $ip);
                if ($modify["result"] != "OK") {
                    $this->error = $modify["error"]["Details"];
                    return false;
                }
            }
        }

        $this->invalidateCache($domainCacheKey);

        return true;
    }


    /**
     * Delete Child Nameserver
     * @param $params
     * @param $cns
     * @param $ip
     * @return bool
     */
    public function DeleteCNS($params = [], $cns = '', $ip = '')
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;


        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDomainDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["success"] !== true) {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }
            $result = $this->api->deleteChildNameServer($domain, $cns);
            if ($result["success"] !== true) {
                $this->error = $result["error"]["code"] . " - " . $result["error"]["message"];
                return false;
            }

        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $delete = $this->api->DeleteChildNameServer($domain, $cns);
            if ($delete["result"] != "OK") {
                $this->error = $delete["error"]["Details"];
                return false;
            }
        }

        $this->invalidateCache($domainCacheKey);

        return true;
    }

    /**
     * Get Whois Privacy
     * @param array $params
     * @return string
     */
    public function getWhoisPrivacy($params = [])
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;

        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDomainDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["success"] !== true) {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }
            return $domainDetail['privacyProtectionStatus'] == 1;
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            return $domainDetail["data"]["PrivacyProtectionStatus"] ? "active" : "passive";
        }
    }

    /**
     * Modify Whois Privacy
     * @param $params
     * @param $whois
     * @return bool
     */
    public function ModifyWhois($params = [], $whois = [])
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;


        if ($this->apiV2) {
            $result = $this->api->saveContacts($domain, $this->contactProcess($whois));

            if ($result["success"] !== true) {
                $this->error = $result["error"]["code"] . " - " . $result["error"]["message"];
                return false;
            }
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return true;
            }

            $modifyContact = $this->api->SaveContacts($domain, $this->contactProcess($whois));
            if ($modifyContact["result"] != "OK") {
                $this->error = $modifyContact["error"]["Details"];
                return false;
            }
        }


        $this->invalidateCache($domainCacheKey);
        $this->invalidateCache('cnt_' . $domainCacheKey);
        return true;
    }

    /**
     * Set Contact Details
     * @param array $data
     * @param string $type
     * @return array
     */

    /**
     * Get Transfer Lock
     * @param $params
     * @return array
     */
    public function getTransferLock($params = [])
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;

        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["success"] !== true) {
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            return $domainDetail['lockStatus'] == 1;
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            return $domainDetail["data"]["LockStatus"] == "true";
        }
    }

    /**
     * Check Active
     * @param $params
     * @return bool
     */
    public function isInactive($params = [])
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;

        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["success"] !== true) {
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            return $domainDetail["status"] != "Active";
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            return $domainDetail["data"]["Status"] != "Active";
        }




    }

    /**
     * Modify Transfer Lock
     * @param $params
     * @param $type
     * @return bool
     */
    public function ModifyTransferLock($params = [], $type = '')
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;


        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["success"] !== true) {
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            $modify = $type == "enable" ? $this->api->enableTheftProtectionLock($domain) : $this->api->disableTheftProtectionLock($domain);

            if ($modify["success"] !== true) {
                $this->error = $modify["error"]["code"] . " - " . $modify["error"]["message"];
                return false;
            }
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $modify = $type == "enable" ? $this->api->EnableTheftProtectionLock($domain) : $this->api->DisableTheftProtectionLock($domain);

            if ($modify["result"] != "OK") {
                $this->error = $modify["error"]["Details"];
                return false;
            }
        }


        $this->invalidateCache($domainCacheKey);

        return true;
    }


    /**
     * Modify Privacy Protection
     * @param $params
     * @param $staus
     * @return bool
     */
    public function modifyPrivacyProtection($params = [], $staus = false)
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;

        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["success"] !== true) {
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            $modify = $this->api->modifyPrivacyProtectionStatus($domain, $staus);

            if ($modify["success"] !== true) {
                $this->error = $modify["error"]["code"] . " - " . $modify["error"]["message"];
                return false;
            }
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $modify = $this->api->ModifyPrivacyProtectionStatus($domain, $staus);
            if ($modify["result"] != "OK") {
                $this->error = $modify["error"]["Details"];
                return false;
            }
        }


        $this->invalidateCache($domainCacheKey);

        return true;
    }

    /**
     * Enable Privacy Protection
     * @param $params
     * @return bool
     */
    public function purchasePrivacyProtection($params = []) {
        return $this->modifyPrivacyProtection($params, true);
    }

    public function getAuthCode($params = [])
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;


        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["success"] !== true) {
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            return $domainDetail['authCode'];
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["result"] != "OK") {
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }
            return $domainDetail["data"]["AuthCode"];
        }
    }

    public function sync($params = []) {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;
        $this->invalidateCache($domainCacheKey);

        $return_data = [];
        $endtime     = $currentstatus = false;

        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["success"] !== true) {
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            $endtime       = isset($domainDetail["expirationDate"]) ? DateManager::format("Y-m-d H:i:s", $domainDetail["expirationDate"]) : false;
            $currentstatus = $domainDetail["status"] ?? false;
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["result"] != "OK") {
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $endtime       = isset($domainDetail["data"]["Dates"]["Expiration"]) ? DateManager::format("Y-m-d H:i:s", $domainDetail["data"]["Dates"]["Expiration"]) : false;
            $currentstatus = $domainDetail["data"]["Status"] ?? false;
        }

        $return_data['status'] = 'waiting';

        if ($endtime) {
            $return_data["endtime"] = $endtime;
        }

        if ($currentstatus == "Active") {
            $return_data["status"] = "active";
        } elseif ($currentstatus == "Expired") {
            $return_data["status"] = "expired";
        }


        return $return_data;
    }

    public function transfer_sync($params = []) {
        $this->set_credentials();

        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;
        $this->invalidateCache($domainCacheKey);

        $return_data = [];
        $endtime     = $currentstatus = false;

        if ($this->apiV2) {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);
            if ($domainDetail["success"] !== true) {
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            $endtime       = isset($domainDetail["expirationDate"]) ? DateManager::format("Y-m-d H:i:s", $domainDetail["expirationDate"]) : false;
            $currentstatus = $domainDetail["status"] ?? false;
        } else {
            $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
                return $this->api->getDetails($domain);
            }, $this->domainCacheTTL);

            if ($domainDetail["result"] != "OK") {
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $endtime       = isset($domainDetail["data"]["Dates"]["Expiration"]) ? DateManager::format("Y-m-d H:i:s", $domainDetail["data"]["Dates"]["Expiration"]) : false;
            $currentstatus = $domainDetail["data"]["Status"] ?? false;
        }

        $return_data['status'] = 'waiting';

        if ($endtime) {
            $return_data["endtime"] = $endtime;
        }

        if ($currentstatus == "Active") {

             $dns = [];

             foreach ([1,2,3,4] as $vns) {
                 if (isset($params["ns{$vns}"]) && $params["ns{$vns}"]) {
                     $dns[] = $params["ns{$vns}"];
                 }
             }


            $this->ModifyDns(['domain' => $domain], $dns);
            $this->ModifyWhois(['domain' => $domain], $params["whois"]);


            $return_data["status"] = "active";
        } elseif ($currentstatus == "Expired") {
            $return_data["status"] = "expired";
        }

        return $return_data;
    }

    public function get_info($params = [])
    {
        $this->set_credentials();
        $domain         = trim($params["domain"]);
        $domainCacheKey = "dom_" . $domain;

        $domainDetail = $this->rememberCache($domainCacheKey, function () use ($domain) {
            return $this->apiV2 ? $this->api->getDetails($domain) : $this->api->GetDetails($domain);
        }, $this->domainCacheTTL);

        if ($this->apiV2) {
            if ($domainDetail["success"] !== true) {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["code"] . " - " . $domainDetail["error"]["message"];
                return false;
            }

            $cdate       = DateManager::format("Y-m-d H:i:s", $domainDetail["startDate"]);
            $duedate     = DateManager::format("Y-m-d H:i:s", $domainDetail["expirationDate"]);
            $wprivacy    = $domainDetail["privacyProtectionStatus"];
            $nameservers = $domainDetail['nameservers'];
            $whois       = $this->formatWhois($domainDetail['contacts']);
        } else {
            if ($domainDetail["result"] != "OK") {
                $this->invalidateCache($domainCacheKey);
                $this->error = $domainDetail["error"]["Details"];
                return false;
            }

            $data        = $domainDetail["data"];
            $cdate       = DateManager::format("Y-m-d H:i:s", $data["Dates"]["Start"]);
            $duedate     = DateManager::format("Y-m-d H:i:s", $data["Dates"]["Expiration"]);
            $wprivacy    = $data["PrivacyProtectionStatus"];
            $nameservers = $data["NameServers"] ?? [];
            $contacts    = $this->rememberCache('cnt_' . $domainCacheKey, function () use ($domain) {
                return $this->api->GetContacts($domain);
            }, $this->domainCacheTTL);
            $whois       = $this->formatWhois($contacts["data"]["contacts"]);
        }

        $result = [
            "whois_privacy" => ['status' => $wprivacy ? "enable" : "disable"],
            "creation_time" => $cdate,
            "end_time"      => $duedate,
            "transferlock"  => $this->apiV2 ? ($domainDetail['lockStatus'] == 1) : ($data["LockStatus"] == "true"),
        ];

        foreach ($nameservers as $index => $ns) {
            $result["ns" . ($index + 1)] = $ns;
        }

        if (!empty($whois)) {
            $result["whois"] = $whois;
        }

        return $result;
    }


    public function domainsdt($pageNumber, $pageLength,$invalidation=0) {
        $this->set_credentials();
        Helper::Load(["User"]);

       if ($invalidation==1){
           $this->invalidateCache(["domainsdt","user_info_short_"]);
       }
       $cacheKey = "domainsdt_" . $pageNumber . "_" . $pageLength;

       $result    = [
            'data'  => [],
            'total' => 0,
        ];
        $user_data = $domain_arr = [];

        if($this->apiV2){
            $listParams = [
                'SkipCount'=> ($pageNumber-1)*$pageLength,
                'MaxResultCount'=>$pageLength
            ];

            $response = $this->rememberCache($cacheKey,
                function () use ($listParams) {
                    return $this->api->getDomainList($listParams);
            }, 180);

            if ($response["success"] !== true) {
                $this->error = $response["error"]["code"] . " - " . $response["error"]["message"];
                return false;
            }

            if (isset($response["items"]) && $response["items"]) {
                $result['total'] = $response["totalCount"];
                foreach ($response['items'] as $res) {
                    $domain_arr[] = [
                        'domain' => $res["domainName"],
                        'start'  => $res["startDate"],
                        'end'    => $res["expirationDate"],
                        'status' => $res["status"]==1 ? "Active" : "Inactive"
                    ];
                }
            }

        }else{
            $listParams = [
                'PageNumber'     => $pageNumber,
                'PageSize'       => $pageLength,
                'OrderColumn'    => 'Id',
                'OrderDirection' => 'DESC',
            ];

            $response = $this->rememberCache($cacheKey,
                function () use ($listParams) {
                    return $this->api->GetList($listParams);
                }, 180);


            if ($response["result"] != "OK") {
                $this->error = $response["error"]["Message"] . " : " . $response["error"]["Details"];
                return false;
            }


            if (isset($response["data"]["Domains"]) && $response["data"]["Domains"]) {
                $result['total'] = $response["TotalCount"];
                foreach ($response["data"]["Domains"] as $res) {
                    $domain_arr[] = [
                        'domain' => $res["DomainName"],
                        'start'  => $res["Dates"]["Start"],
                        'end'    => $res["Dates"]["Expiration"],
                        'status' => $res["Status"]
                    ];
                }
            }
        }

        

        foreach ($domain_arr as $res) {
            $user_data[$res["domain"]] = [];

            $user_data[$res["domain"]]['user_info'] = $this->rememberCache("user_info_short_" . $res["domain"],
                function () use ($res) {
                    $is_imported = Models::$init->db->select("id,owner_id AS user_id")
                                                    ->from("users_products");
                    $is_imported->where("type", '=', "domain", "&&");
                    $is_imported->where("options", 'LIKE', '%"domain":"' . $res["domain"] . '"%');
                    $is_imported = $is_imported->build() ? $is_imported->getAssoc() : false;
                    if ($is_imported) {
                        $user_data= User::getData($is_imported["user_id"], "id,full_name,company_name", "array");
                        $user_data['order_id']=$is_imported["id"];
                        return $user_data;
                    }
                    return [];
                },180);
        }


        foreach ($domain_arr as $res) {
                $cdate  = isset($res["start"]) ? DateManager::format("Y-m-d H:i", $res["start"]) : '';
                $edate  = isset($res["end"]) ? DateManager::format("Y-m-d H:i", $res["end"]) : '';
                $domain = isset($res["domain"]) ? $res["domain"] : '';
                if ($domain) {
                    $order_id    = 0;
                    if ($res["status"] == "Active")
                        $result['data'][] = [
                            'domain'        => $domain,
                            'creation_date' => $cdate,
                            'end_date'      => $edate,
                            'order_id'      => $user_data[$domain]['user_info']['order_id'] ?? 0,
                            'user_data'     => $user_data[$domain]['user_info'],
                        ];
                }
            }
        
        return $result;
    }

    public function import_domain($data = []) {
        $this->set_credentials();
        $config = $this->config;

        $imports = $results = [];

        Helper::Load([
            "Orders",
            "Products",
            "Money"
        ]);

        foreach ($data as $domain => $datum) {

            $domain_parse = Utility::domain_parser("http://" . $domain);
            $sld          = $domain_parse["host"];
            $tld          = $domain_parse["tld"];
            $user_id      = (int)$datum["user_id"];
            if (!$user_id){
                continue;
            }

            $info = $this->get_info([
                'domain' => $domain,
                'name'   => $sld,
                'tld'    => $tld,
            ]);

            if (!$info){
                $results[$domain] = 'domain info not found';
                continue;
            }


            $user_data = User::getData($user_id, "id,lang", "array");
            $ulang     = $user_data["lang"];
            $locallang = Config::get("general/local");
            $productID = Models::$init->db->select("id")
                                          ->from("tldlist")
                                          ->where("name", "=", $tld);

            $productID = $productID->build() ? $productID->getObject()->id : false;
            if (!$productID)
                continue;
            $productPrice     = Products::get_price("register", "tld", $productID);
            $productPrice_amt = $productPrice["amount"];
            $productPrice_cid = $productPrice["cid"];
            $start_date       = $info["creation_time"];
            $end_date         = $info["end_time"];

            $options = [
                "established"      => true,
                "group_name"       => Bootstrap::$lang->get_cm("website/account_products/product-type-names/domain", false, $ulang),
                "local_group_name" => Bootstrap::$lang->get_cm("website/account_products/product-type-names/domain", false, $locallang),
                "category_id"      => 0,
                "domain"           => $domain,
                "name"             => $sld,
                "tld"              => $tld,
                "dns_manage"       => true,
                "whois_manage"     => true,
                "transferlock"     => $info["transferlock"],
                "cns_list"         => isset($info["cns"]) ? $info["cns"] : [],
                "whois"            => isset($info["whois"]) ? $info["whois"] : [],
            ];

            if (isset($info["whois_privacy"]) && $info["whois_privacy"]) {
                $options["whois_privacy"] = $info["whois_privacy"]["status"] == "enable";
                $wprivacy_endtime         = DateManager::ata();
                if (isset($info["whois_privacy"]["end_time"]) && $info["whois_privacy"]["end_time"]) {
                    $wprivacy_endtime                 = $info["whois_privacy"]["end_time"];
                    $options["whois_privacy_endtime"] = $wprivacy_endtime;
                }
            }

            if (isset($info["ns1"]) && $info["ns1"])
                $options["ns1"] = $info["ns1"];
            if (isset($info["ns2"]) && $info["ns2"])
                $options["ns2"] = $info["ns2"];
            if (isset($info["ns3"]) && $info["ns3"])
                $options["ns3"] = $info["ns3"];
            if (isset($info["ns4"]) && $info["ns4"])
                $options["ns4"] = $info["ns4"];


            $order_data = [
                "owner_id"     => (int)$user_id,
                "type"         => "domain",
                "product_id"   => (int)$productID,
                "name"         => $domain,
                "period"       => "year",
                "period_time"  => 1,
                "amount"       => (float)$productPrice_amt,
                "total_amount" => (float)$productPrice_amt,
                "amount_cid"   => (int)$productPrice_cid,
                "status"       => "active",
                "cdate"        => $start_date,
                "duedate"      => $end_date,
                "renewaldate"  => DateManager::Now(),
                "module"       => $config["meta"]["name"],
                "options"      => Utility::jencode($options),
                "unread"       => 1,
            ];

            $insert = Orders::insert($order_data);
            if (!$insert){
                $results[$domain] = 'order insert failed';
                continue;
            }

            /*
             * Possiblity slow down the system
            if (isset($options["whois_privacy"])) {
                $amount = Money::exChange($this->whidden["amount"], $this->whidden["currency"], $productPrice_cid);
                $start  = DateManager::Now();
                $end    = isset($wprivacy_endtime) ? $wprivacy_endtime : DateManager::ata();
                Orders::insert_addon([
                    'invoice_id'  => 0,
                    'owner_id'    => $insert,
                    "addon_key"   => "whois-privacy",
                    'addon_id'    => 0,
                    'addon_name'  => Bootstrap::$lang->get_cm("website/account_products/whois-privacy", false, $ulang),
                    'option_id'   => 0,
                    "option_name" => Bootstrap::$lang->get("needs/iwwant", $ulang),
                    'period'      => 1,
                    'period_time' => "year",
                    'status'      => "active",
                    'cdate'       => $start,
                    'renewaldate' => $start,
                    'duedate'     => $end,
                    'amount'      => $amount,
                    'cid'         => $productPrice_cid,
                    'unread'      => 1,
                ]);
            }
            */
            $imports[] = $order_data["name"] . " (#" . $insert . ")";
        }

        if ($imports) {
            $adata = UserManager::LoginData("admin");
            User::addAction($adata["id"], "alteration", "domain-imported", [
                'module'   => $config["meta"]["name"],
                'imported' => implode(", ", $imports),
            ]);
        }

        return $results;
    }

    public function cost_prices($type = 'domain')
    {
        $this->set_credentials();
        $config = $this->config;
        if (!isset($this->config["settings"]["adp"]) || !$this->config["settings"]["adp"]) {
            return false;
        }

        $response = $this->rememberCache("tld_list", function () {
            return $this->api->GetTldList(999);
        }, 180);


        if ($response["result"] != "OK" && isset($response["error"]["Details"]) && strlen($response["error"]["Details"]) >= 3) {
            $this->error = $response["error"]["Message"] . " : " . $response["error"]["Details"];
            return false;
        }

        $result = [];

        $excluded_tlds = $config['settings']['exclude'] ? explode(',', $config['settings']['exclude']) : [];

        foreach ($response["data"] as $row) {
            if ($row["status"] != "Active") {
                continue;
            }
            if (in_array($row["tld"], $excluded_tlds)) {
                continue;
            }

            if (!isset($row["pricing"]["registration"][1])) {
                continue;
            }

            $result[$row["tld"]] = [
                'register' => number_format(($row["pricing"]["registration"][1] ?? 0), 2, '.', ''),
                'transfer' => number_format(($row["pricing"]["transfer"][1] ?? 0), 2, '.', ''),
                'renewal'  => number_format(($row["pricing"]["renew"][1] ?? 0), 2, '.', ''),
            ];
        }

        return $result;
    }

    public function list_tlds() {
        $this->set_credentials();
        $config = $this->config;

        $response = $this->rememberCache("tld_list", function () {
            return $this->api->GetTldList(999);
        }, 180);


        if ($response["result"] != "OK") {
            $this->error = $response["error"]["Message"] . " : " . $response["error"]["Details"];
            return false;
        }

        Helper::Load([
            "Products",
            "Money"
        ]);

        $cost_cid    =  4;
        $profit_rate = Config::get("options/domain-profit-rate");
        $excluded_tlds = $config['settings']['exclude'] ? explode(',',$config['settings']['exclude']) : [];

        $tld_arr = [];


        foreach ($response["data"] as $row) {


            if ($row["status"] != "Active")
                continue;
            if (!isset($row["pricing"]["registration"][1]))
                continue;
            $name = Utility::strtolower(trim($row["tld"]));

            $tld_obj = [
                'tld'                     => $name,
                'module'                  => null,
                'register_cost'           => number_format($row["pricing"]["registration"][1], 2),
                'renewal_cost'            => number_format($row["pricing"]["renew"][1], 2),
                'transfer_cost'           => number_format($row["pricing"]["transfer"][1], 2),
                'register_current'        => null,
                'renewal_current'         => null,
                'transfer_current'        => null,
                'register_margin'         => null,
                'renewal_margin'          => null,
                'transfer_margin'         => null,
                'register_margin_percent' => null,
                'renewal_margin_percent'  => null,
                'transfer_margin_percent' => null,
            ];


            $check = Models::$init->db->select()->from("tldlist")->where("name", "=", $name);

            if ($check->build()) {
                $tld = $check->getAssoc();
                $pid = $tld["id"];

                $tld_obj['module'] = $tld["module"];

                $reg_price = Products::get_price("register", "tld", $pid);
                $ren_price = Products::get_price("renewal", "tld", $pid);
                $tra_price = Products::get_price("transfer", "tld", $pid);

                //currency_id
                $reg_currency = $reg_price["cid"];
                $ren_currency = $ren_price["cid"];
                $tra_currency = $tra_price["cid"];
                //amount
                $reg_amount= $reg_price["amount"];
                $ren_amount= $ren_price["amount"];
                $tra_amount= $tra_price["amount"];

                $tld_obj['register_current'] = number_format((Money::exChange($reg_amount, $reg_currency, $cost_cid)),2);
                $tld_obj['renewal_current'] = number_format((Money::exChange($ren_amount, $ren_currency, $cost_cid)),2);
                $tld_obj['transfer_current'] = number_format((Money::exChange($tra_amount, $tra_currency, $cost_cid)),2);

            }

            //calculate margin between current and cost as percentage
            if($tld_obj['register_current']!==null && $tld_obj['register_cost']<>0){
                $tld_obj['register_margin'] = floatval(number_format(($tld_obj['register_current'] - $tld_obj['register_cost']),2));
                $tld_obj['register_margin_percent'] = intval(number_format((($tld_obj['register_margin'] / $tld_obj['register_cost']) * 100),0));
            }
            if($tld_obj['renewal_current']!==null && $tld_obj['renewal_cost']<>0){
                $tld_obj['renewal_margin'] = floatval(number_format(($tld_obj['renewal_current'] - $tld_obj['renewal_cost']),2));
                $tld_obj['renewal_margin_percent'] = intval(number_format((($tld_obj['renewal_margin'] / $tld_obj['renewal_cost']) * 100),0));
            }
            if($tld_obj['transfer_current']!==null && $tld_obj['transfer_cost']<>0){
                $tld_obj['transfer_margin'] = floatval(number_format(($tld_obj['transfer_current'] - $tld_obj['transfer_cost']),2));
                $tld_obj['transfer_margin_percent'] =intval(number_format(( ($tld_obj['transfer_margin'] / $tld_obj['transfer_cost']) * 100),0));
            }

            $tld_obj['excluded'] =in_array($name,$excluded_tlds);

            $tld_arr[] = $tld_obj;


        }

        return ['tlds'          => $tld_arr];
    }

    public function apply_import_tlds($selected_tlds=[]) {
        $this->set_credentials();

        $response = $this->rememberCache("tld_list", function () {
            return $this->api->GetTldList(999);
        }, 180);
        if ($response["result"] != "OK") {
            $this->error = $response["error"]["Message"] . " : " . $response["error"]["Details"];
            return false;
        }

        Helper::Load([
            "Products",
            "Money"
        ]);

        $cost_cid    = isset($this->config["settings"]["cost-currency"]) ? $this->config["settings"]["cost-currency"] : 4;
        $profit_rate = Config::get("options/domain-profit-rate");

        foreach ($response["data"] as $row) {
            if(is_array($selected_tlds) && count($selected_tlds)>0){
                if($row["tld"]!='' && !in_array($row["tld"],$selected_tlds)){
                    continue;
                }
            }

            if ($row["status"] != "Active"){
                continue;
            }

            if (!isset($row["pricing"]["registration"][1])){
                continue;
            }

            $name = Utility::strtolower(trim($row["tld"]));


            $api_cost_prices = [
                'register' => number_format(($row["pricing"]["registration"][1] ?? 0), 2, '.', ''),
                'transfer' => number_format(($row["pricing"]["transfer"][1] ?? 0), 2, '.', ''),
                'renewal'  => number_format(($row["pricing"]["renew"][1] ?? 0), 2, '.', ''),
            ];

            $paperwork     = $row["IsDocumentRequired"] ? 1 : 0;
            $epp_code      = $row["IsTransferable"] ? 1 : 0;
            $dns_manage    = 1;
            $whois_privacy = 1;
            $module        = "DomainNameAPI";

            $check = Models::$init->db->select()
                                      ->from("tldlist")
                                      ->where("name", "=", $name);

            if ($check->build()) {
                $tld = $check->getAssoc();
                $pid = $tld["id"];

                $reg_price = Products::get_price("register", "tld", $pid);
                $ren_price = Products::get_price("renewal", "tld", $pid);
                $tra_price = Products::get_price("transfer", "tld", $pid);

                $tld_cid = $reg_price["cid"];


                $register_cost = Money::deformatter($api_cost_prices["register"]);
                $renewal_cost  = Money::deformatter($api_cost_prices["renewal"]);
                $transfer_cost = Money::deformatter($api_cost_prices["transfer"]);

                // ExChanges
                $register_cost = Money::exChange($register_cost, $cost_cid, $tld_cid);
                $renewal_cost  = Money::exChange($renewal_cost, $cost_cid, $tld_cid);
                $transfer_cost = Money::exChange($transfer_cost, $cost_cid, $tld_cid);


                $reg_profit = Money::get_discount_amount($register_cost, $profit_rate);
                $ren_profit = Money::get_discount_amount($renewal_cost, $profit_rate);
                $tra_profit = Money::get_discount_amount($transfer_cost, $profit_rate);

                $register_sale = $register_cost + $reg_profit;
                $renewal_sale  = $renewal_cost + $ren_profit;
                $transfer_sale = $transfer_cost + $tra_profit;

                Products::set("domain", $pid, [
                    'paperwork'     => $paperwork,
                    'epp_code'      => $epp_code,
                    'dns_manage'    => $dns_manage,
                    'whois_privacy' => $whois_privacy,
                    'register_cost' => $register_cost,
                    'renewal_cost'  => $renewal_cost,
                    'transfer_cost' => $transfer_cost,
                    'module'        => $module,
                ]);

                Models::$init->db->update("prices", [
                    'amount' => $register_sale,
                    'cid'    => $tld_cid,
                ])
                                 ->where("id", "=", $reg_price["id"])
                                 ->save();


                Models::$init->db->update("prices", [
                    'amount' => $renewal_sale,
                    'cid'    => $tld_cid,
                ])
                                 ->where("id", "=", $ren_price["id"])
                                 ->save();


                Models::$init->db->update("prices", [
                    'amount' => $transfer_sale,
                    'cid'    => $tld_cid,
                ])
                                 ->where("id", "=", $tra_price["id"])
                                 ->save();

            } else {

                $tld_cid = $cost_cid;


                $register_cost = Money::deformatter($api_cost_prices["register"]);
                $renewal_cost  = Money::deformatter($api_cost_prices["renewal"]);
                $transfer_cost = Money::deformatter($api_cost_prices["transfer"]);


                $reg_profit = Money::get_discount_amount($register_cost, $profit_rate);
                $ren_profit = Money::get_discount_amount($renewal_cost, $profit_rate);
                $tra_profit = Money::get_discount_amount($transfer_cost, $profit_rate);

                $register_sale = $register_cost + $reg_profit;
                $renewal_sale  = $renewal_cost + $ren_profit;
                $transfer_sale = $transfer_cost + $tra_profit;

                $insert = Models::$init->db->insert("tldlist", [
                    'status'        => "inactive",
                    'cdate'         => DateManager::Now(),
                    'name'          => $name,
                    'paperwork'     => $paperwork,
                    'epp_code'      => $epp_code,
                    'dns_manage'    => $dns_manage,
                    'whois_privacy' => $whois_privacy,
                    'currency'      => $tld_cid,
                    'register_cost' => $register_cost,
                    'renewal_cost'  => $renewal_cost,
                    'transfer_cost' => $transfer_cost,
                    'module'        => $module,
                ]);

                if ($insert) {
                    $tld_id = Models::$init->db->lastID();

                    Models::$init->db->insert("prices", [
                        'owner'    => "tld",
                        'owner_id' => $tld_id,
                        'type'     => 'register',
                        'amount'   => $register_sale,
                        'cid'      => $tld_cid,
                    ]);


                    Models::$init->db->insert("prices", [
                        'owner'    => "tld",
                        'owner_id' => $tld_id,
                        'type'     => 'renewal',
                        'amount'   => $renewal_sale,
                        'cid'      => $tld_cid,
                    ]);


                    Models::$init->db->insert("prices", [
                        'owner'    => "tld",
                        'owner_id' => $tld_id,
                        'type'     => 'transfer',
                        'amount'   => $transfer_sale,
                        'cid'      => $tld_cid,
                    ]);
                }

            }


        }


        return true;
    }

    public function getDNAUser()
    {
        $this->set_credentials();

        $response =$this->rememberCache("dna_user", function () {
            return $this->api->GetResellerDetails();
        }, 180);

        return $response;
    }


    private function formatWhois($contacts)
{
    $whois = [];
     $types = ['Registrant', 'Administrative', 'Technical', 'Billing'];
    if ($this->apiV2) {
        foreach ($contacts as $contact) {
            $s_k = strtolower($contact['contactType']);
            $state = $contact["state"] ?: 'N/A';

            $whois[$s_k] = [
                'FirstName' => $contact["firstName"],
                'LastName' => $contact["lastName"],
                'Name' => $contact["firstName"] . ($contact["lastName"] ? ' ' : '') . $contact["lastName"],
                'Company' => $contact["companyName"],
                'EMail' => $contact["eMail"],
                'AddressLine1' => $contact["address"],
                'City' => $contact["city"],
                'State' => $state,
                'ZipCode' => $contact["postalCode"],
                'Country' => $contact["country"],
                'PhoneCountryCode' => $contact["phoneCountryCode"],
                'Phone' => $contact["phone"],
                'FaxCountryCode' => $contact["faxCountryCode"] ?? "",
                'Fax' => $contact["fax"] ?? "",
            ];
        }
    } else {

        foreach ($types as $ct) {
            $s_k = strtolower($ct);
            $contact = $contacts[$ct] ?? $contacts["Registrant"];
            $state = $contact["Address"]["State"] ?: 'N/A';
            $whois[$s_k] = [
                'FirstName' => $contact["FirstName"],
                'LastName' => $contact["LastName"],
                'Name' => $contact["FirstName"] . ($contact["LastName"] ? ' ' : '') . $contact["LastName"],
                'Company' => $contact["Company"],
                'EMail' => $contact["EMail"],
                'AddressLine1' => $contact["Address"]["Line1"],
                'City' => $contact["Address"]["City"],
                'State' => $state,
                'ZipCode' => $contact["Address"]["ZipCode"],
                'Country' => $contact["Address"]["Country"],
                'PhoneCountryCode' => $contact["Phone"]["Phone"]["CountryCode"],
                'Phone' => $contact["Phone"]["Phone"]["Number"],
                'FaxCountryCode' => $contact["Phone"]["Fax"]["CountryCode"] ?? "",
                'Fax' => $contact["Phone"]["Fax"]["Number"] ?? "",
            ];
        }
    }
    return $whois;
}

    public function contactProcess($data = [], $type = 'Contact')
    {
        $this->set_credentials();

        $formatWhoisData = function ($v) {
            $firstname   = $v["FirstName"] ?? $v["firstName"] ?? $v["firstname"];
            $lastname    = $v["LastName"] ?? $v["lastName"] ?? $v["lastname"];
            $companyname = $v["Company"] ?? $v["company"] ?? $v["companyname"];
            $email       = $v["Email"] ?? $v["email"];
            $address1    = $v["AddressLine1"] ?? $v["addressLine1"] ?? $v["address1"];
            $address2    = $v["AddressLine2"] ?? $v["addressLine2"] ?? $v["address2"];
            $city        = $v["City"] ?? $v["city"];
            $country     = $v["Country"] ?? $v["country"] ?? $v["countrycode"];
            $fax         = $v["Fax"] ?? $v["fax"] ?? $v["phonenumber"];
            $faxcc       = $v["FaxCountryCode"] ?? $v["faxCountryCode"] ?? $v["phonecc"];
            $phonecc     = $v["PhoneCountryCode"] ?? $v["phoneCountryCode"] ?? $v["phonecc"];
            $phone       = $v["Phone"] ?? $v["phone"] ?? $v["phonenumber"];
            $postcode    = $v["ZipCode"] ?? $v["zipCode"] ?? $v["postcode"];
            $state       = $v["State"] ?? $v["state"];

            if ($this->apiV2) {
                // Yeni API için anahtar adlarını kullan
                $whois_arr = [
                    "firstName"        => $firstname,
                    "lastName"         => $lastname,
                    "companyName"      => $companyname,
                    "eMail"            => $email,
                    "address"          => $address1 . " " . $address2, // Adresleri birleştir
                    "state"            => $state,
                    "city"             => $city,
                    "country"          => $country,
                    "fax"              => $fax,
                    "faxCountryCode"   => $faxcc,
                    "phone"            => $phone,
                    "phoneCountryCode" => $phonecc,
                    "postalCode"       => $postcode,
                ];
            } else {
                // Eski API için anahtar adlarını kullan
                $whois_arr = [
                    "FirstName"        => $firstname,
                    "LastName"         => $lastname,
                    "Company"          => $companyname,
                    "EMail"            => $email,
                    "AddressLine1"     => $address1,
                    "AddressLine2"     => $address2,
                    "State"            => $state,
                    "City"             => $city,
                    "Country"          => $country,
                    "Fax"              => $fax,
                    "FaxCountryCode"   => $faxcc,
                    "Phone"            => $phone,
                    "PhoneCountryCode" => $phonecc,
                    "ZipCode"          => $postcode,
                ];
                if (isset($params['FirstName'])) {
                    $whois_arr['Status'] = ""; // Eğer FirstName parametresi varsa, Status ekleyin
                }
            }

            if (strlen(trim($whois_arr["LastName"])) == 0) {
                $whois_arr["LastName"] = $whois_arr["FirstName"];
            }

            return $whois_arr;
        };

        if (isset($data["registrant"])) {
            $whois_data = [];
            foreach ($data as $k => $v) {
                $whois_data[ucfirst($k)] = $formatWhoisData($v);
            }
            return $whois_data;
        } else {
            $whois_data = $formatWhoisData($data);
            return [
                "Administrative" => $whois_data,
                "Billing"        => $whois_data,
                "Technical"      => $whois_data,
                "Registrant"     => $whois_data,
            ];
        }
    }

    public function addionalFieldsProcess($domain, $whois, $userInfo)
    {
        $additional = [];

        if (substr($domain, -3) == ".tr") {
            $additional['TRABISDOMAINCATEGORY'] = $whois['Registrant']['Company'] ? 0 : 1;
            $additional['TRABISCOUNTRYID']      = $whois['Registrant']['Country'] == "TR" ? 215 : 888;
            $additional['TRABISCOUNTRYNAME']    = $whois['Registrant']['Country'];
            $additional['TRABISCITYNAME']       = $whois['Registrant']['City'];
            $additional['TRABISCITIYID']        = 888;


            $identity     = "11111111111";
            $name_surname = $whois["Registrant"]['FirstName'] . ' ' . $whois["Registrant"]['LastName'];
            $tax_number   = '1111111111';
            $tax_office   = 'Bilinmiyor';


            if ($userInfo) {
                if ($userInfo['identity']) {
                    $identity = $userInfo['identity'];
                }
                if ($userInfo["company_tax_office"]) {
                    $tax_office = $userInfo["company_tax_office"];
                }
                if ($userInfo["company_tax_number"]) {
                    $tax_number = $userInfo["company_tax_number"];
                }
            }

            if ($whois['Registrant']['Company']) {
                $additional['TRABISORGANIZATION'] = $whois["Registrant"]["Company"];
                $additional['TRABISTAXOFFICE']    = $tax_office;
                $additional['TRABISTAXNUMBER']    = $tax_number;
            } else {
                $additional['TRABISCITIZIENID']  = $identity;
                $additional['TRABISNAMESURNAME'] = $name_surname;
            }
        }

        return $additional;
    }




    public function rememberCache($key, $function, $ttl = 3600)
    {
        // Güvenli bir hash algoritması kullanın
        $cache_key = "DNA-" . substr($key, 0, 10) . '_' . hash('sha256', $this->username . $this->password . '-' . $key);


        $cache_object = Models::$init->db->select("name,content,updated_at")
                                         ->from("mod_dna_cache_elements")
                                         ->where("name", '=', $cache_key);

        $cache_object = $cache_object->build() ? $cache_object->getAssoc() : false;

        if (!$cache_object || time() > strtotime($cache_object["updated_at"]) + $ttl) {
            $response = $function();

            if (!isset($cache_object["name"])) {
                Models::$init->db->insert("mod_dna_cache_elements", [
                    'name'       => $cache_key,
                    'content'    => base64_encode(serialize($response)),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                Models::$init->db->update("mod_dna_cache_elements", [
                    'content'    => base64_encode(serialize($response)),
                    'updated_at' => date('Y-m-d H:i:s'),
                ])
                                 ->where("name", '=', $cache_key)
                                 ->save();
            }
        } else {
            $response = unserialize(base64_decode($cache_object["content"]));
        }
        return $response;
    }

    public function invalidateCache($key)
    {
        $invalidations = [];
        if(is_string($key) ){
            $invalidations[] = $key;
        }elseif (is_array($key)){
            $invalidations = $key;
        }else{
            return false;
        }
        if(count($invalidations) == 0){
            return false;
        }

        foreach ($invalidations as $k => $v) {
             $cache_key = "DNA-" . substr($v, 0, 10);
             Models::$init->db->delete("mod_dna_cache_elements")->where("name", "LIKE", "{$cache_key}%")->run();
        }

    }

}
