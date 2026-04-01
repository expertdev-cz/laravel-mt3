<?php

namespace App\Libs\Api;

class ComgateApi
{
    const API_BASE_ENDPOINT = 'https://payments.comgate.cz/v1.0/';

    const ACTION_CREATE = 'create';
    const ACTION_METHODS = 'methods';

    const CURL_DEFAULT_CONTENT = 'application/json';
    const CURL_DEFAULT_ACCEPT = 'application/json';

    public const API_STATUS_NEW = 'NEW';
    public const API_STATUS_PAID = 'PAID';
    public const API_STATUS_CANCELED = 'CANCELLED';
    public const API_STATUS_AUTHORIZED = 'AUTHORIZED';
    public const API_STATUS_PENDING = 'PENDING';

    private string $apiPass;
    private string $apiName; //merchant
    public bool $apiUseInBackgroundMode;

    private bool $isSandbox;
    private bool $debug;
    private bool $debugVerbose;

    private array $allowedCurr;
    private string $selCurr;

    private array $allowedLangs;
    private string $selLang;

    private array $allowedCountries;
    private string $selCountry;

    private array $curlHttpHeader;
    private array $curlPostData;
    private bool $curlFollowRedir;

    private $curlLastCallMsg;
    private $curlLastCallCode;
    private $curlLastCallResult;

    private array $reqParamsMap;
    private array $optParamsMap;

    private bool $isApiLoginDataSet;

    private array $payPostData;

    private string $lastDataCheckErr;

    public function __construct(bool $useInBackgroundMode = true)
    {
        $this->isSandbox = true;
        $this->debug = false;
        $this->debugVerbose = false;

        $this->isApiLoginDataSet = false;

        $this->curlHttpHeader = [];
        $this->curlPostData = [];
        $this->curlFollowRedir = false;

        $this->apiName = '';
        $this->apiPass = '';

        $this->apiUseInBackgroundMode = $useInBackgroundMode;

        $this->selCurr = 'CZK';
        $this->selLang = 'cs';
        $this->selCountry = 'CZ';

        $this->lastDataCheckErr = '';

        $this->resetLastCallData();
        $this->resetPostDataPay();

        $this->fillAllowedCurr();
        $this->fillAllowedLangs();
        $this->fillAllowedCountries();

        $this->fillParamsMaps();

        $this->apiName = (string) env('COMGATE_API_NAME', '');
        $this->apiPass = (string) env('COMGATE_API_PASS', '');

        $this->checkApiLoginData();
    }

    private function checkApiLoginData()
    {
        if (strlen($this->apiName) > 0 && strlen($this->apiPass) > 3) {
            $this->isApiLoginDataSet = true;
        }
    }

    /*
    public function setApiLoginData(string $merchantName, string $apiSecret){
        $this->apiName = $merchantName;
        $this->apiPass = $apiSecret;

        if (strlen($merchantName)>0 && strlen($apiSecret)>3){
            $this->isApiLoginDataSet = true;
        }
    }
    */

    public function getApiSecret(): string
    {
        return $this->apiPass;
    }

    public function checkIfApiLoginIsSet(): bool
    {
        return $this->isApiLoginDataSet;
    }

    public function setCurrency(string $currIsoCode)
    {
        if (in_array($currIsoCode, $this->allowedCurr)) {
            $this->selCurr = $currIsoCode;
        }
    }

    public function setLang(string $langCode)
    {
        if (in_array($langCode, $this->allowedLangs)) {
            $this->selLang = $langCode;
        }
    }

    public function setCountry(string $countryCode)
    {
        if (in_array($countryCode, $this->allowedCountries)) {
            $this->selCountry = $countryCode;
        }
    }

    public function setDebugMode(bool $useDebug = true)
    {
        $this->debug = $useDebug;
    }

    public function setSandboxMode(bool $useInSandboxMode = true)
    {
        $this->isSandbox = $useInSandboxMode;
    }

    public function getLastDataCheckErr(): string
    {
        return $this->lastDataCheckErr;
    }

    private function fillAllowedCurr()
    {
        $this->allowedCurr = [];

        $this->allowedCurr[] = 'CZK';
        $this->allowedCurr[] = 'EUR';
        $this->allowedCurr[] = 'PLN';
        $this->allowedCurr[] = 'HUF';
        $this->allowedCurr[] = 'USD';
        $this->allowedCurr[] = 'GBP';
        $this->allowedCurr[] = 'RON';
        $this->allowedCurr[] = 'HRK';
        $this->allowedCurr[] = 'NOK';
        $this->allowedCurr[] = 'SEK';
    }

    private function fillAllowedLangs()
    {
        $this->allowedLangs = [];

        $this->allowedLangs[] = 'cs';
        $this->allowedLangs[] = 'sk';
        $this->allowedLangs[] = 'en';
        $this->allowedLangs[] = 'es';
        $this->allowedLangs[] = 'it';
        $this->allowedLangs[] = 'pl';
        $this->allowedLangs[] = 'fr';
        $this->allowedLangs[] = 'ro';
        $this->allowedLangs[] = 'de';
        $this->allowedLangs[] = 'hu';
        $this->allowedLangs[] = 'si';
        $this->allowedLangs[] = 'hr';
        $this->allowedLangs[] = 'no';
        $this->allowedLangs[] = 'sv';
    }

    private function fillAllowedCountries()
    {
        $this->allowedCountries = [];

        $this->allowedCountries[] = 'AT';
        $this->allowedCountries[] = 'BE';
        $this->allowedCountries[] = 'CY';
        $this->allowedCountries[] = 'CZ';
        $this->allowedCountries[] = 'DE';
        $this->allowedCountries[] = 'EE';
        $this->allowedCountries[] = 'EL';
        $this->allowedCountries[] = 'ES';
        $this->allowedCountries[] = 'FI';
        $this->allowedCountries[] = 'FR';
        $this->allowedCountries[] = 'GB';
        $this->allowedCountries[] = 'HR';
        $this->allowedCountries[] = 'HU';
        $this->allowedCountries[] = 'IE';
        $this->allowedCountries[] = 'IT';
        $this->allowedCountries[] = 'LT';
        $this->allowedCountries[] = 'LU';
        $this->allowedCountries[] = 'LV';
        $this->allowedCountries[] = 'MT';
        $this->allowedCountries[] = 'NL';
        $this->allowedCountries[] = 'NO';
        $this->allowedCountries[] = 'PL';
        $this->allowedCountries[] = 'PT';
        $this->allowedCountries[] = 'RO';
        $this->allowedCountries[] = 'SL';
        $this->allowedCountries[] = 'SK';
        $this->allowedCountries[] = 'SV';
        $this->allowedCountries[] = 'US';
    }

    private function fillParamsMaps()
    {
        $this->reqParamsMap = [];
        //$this->reqParamsMap[self::ACTION_CREATE] = ['merchant','price','curr','label','refId','method','email','prepareOnly','secret'];
        $this->reqParamsMap[self::ACTION_CREATE] = ['merchant', 'price', 'curr', 'label', 'refId', 'method', 'email', 'secret'];
        $this->reqParamsMap[self::ACTION_METHODS] = ['merchant', 'secret'];

        $this->optParamsMap = [];
        $this->optParamsMap[self::ACTION_CREATE] = ['test', 'country', 'account', 'phone', 'name', 'lang', 'preauth', 'initRecurring', 'verification', 'eetReport', 'eetData', 'embedded', 'applePayPayload', 'expirationTime', 'dynamicExpiration', 'prepareOnly'];
        $this->optParamsMap[self::ACTION_METHODS] = ['type', 'lang', 'curr', 'country'];
    }

    public function setAdditionalPayData(string $phoneNumber = '', string $accountForMoneySend = '', string $productName = '')
    {

        if (strlen($phoneNumber) > 3) {
            $this->payPostData['phone'] = $phoneNumber;
        }

        if (strlen($accountForMoneySend) > 3) {
            $this->payPostData['account'] = $accountForMoneySend;
        }

        if (strlen($productName) > 1) {
            $this->payPostData['name'] = $productName;
        }

        //preauth
        //initRecurring
        //verification
        //eetReport
        //eetData
        //embedded
        //applePayPayload
        //expirationTime
        //dynamicExpiration
    }

    public function createPay($price, string $label, string $refId, string $userEmail, string $paymentMethod)
    {
        $url = self::API_BASE_ENDPOINT . self::ACTION_CREATE;
        $retArr = [];

        if (strlen($paymentMethod) < 2) {
            $paymentMethod = 'ALL';
        }

        $this->payPostData['price'] = $price;
        $this->payPostData['curr'] = $this->selCurr;
        $this->payPostData['label'] = $label;
        $this->payPostData['refId'] = $refId;
        $this->payPostData['method'] = $paymentMethod;
        $this->payPostData['email'] = $userEmail;
        $this->payPostData['lang'] = $this->selLang;
        $this->payPostData['country'] = $this->selCountry;

        $this->curlPostData = $this->payPostData;

        if ($this->apiUseInBackgroundMode) {
            $this->curlPostData['prepareOnly'] = 'true';
        }

        if ($this->checkPostData(self::ACTION_CREATE, true)) {
            $this->curlCall($url, false);

            if ($this->curlLastCallResult) {
                if ($this->debug) {
                    dump($this->curlLastCallResult);
                }

                $respondArr = $this->parsePlaintextRespond($this->curlLastCallResult);
                $this->getCodeAndMsgFromResult($respondArr);

                if ($respondArr) {
                    if (isset($respondArr['transId'])) {
                        $retArr['transId'] = $respondArr['transId'];
                    }

                    if (isset($respondArr['redirect'])) {
                        $retArr['redirect'] = urldecode($respondArr['redirect']);
                    }
                }
            }
        }

        $this->resetPostDataPay();

        return $retArr;
    }

    private function parsePlaintextRespond($textRespond): array
    {
        $ret = [];
        $respondArr = explode('&', $textRespond);

        if ($respondArr) {
            foreach ($respondArr as $item) {
                $paramValueArr = explode('=', $item);

                if (count($paramValueArr) == 2) {
                    $ret[$paramValueArr[0]] = $paramValueArr[1];
                }
            }
        }

        return $ret;
    }

    private function setCurlHttpHeader(string $contentType = self::CURL_DEFAULT_CONTENT, string $accept = self::CURL_DEFAULT_ACCEPT)
    {
        $this->curlHttpHeader = [
            'Accept: ' . $accept,
            'Content-Type: ' . $contentType
        ];
    }

    private function prePrintData($data, array $hiddenParamsArr = ['secret', 'merchant'])
    {
        $renderData = $data;

        if ($hiddenParamsArr) {
            foreach ($hiddenParamsArr as $param) {
                if (isset($data[$param])) {
                    $renderData[$param] = '***** - hidden by debugger';
                }
            }
        }

        echo '<br> curlPostData: <pre>' . print_r($renderData, true) . '</pre>';
    }

    private function curlCall(string $url, bool $jsonDecode = true)
    {
        $this->resetLastCallData();

        $curl = curl_init();

        if ($this->debug) {
            echo '<br> url: ' . $url;
            $this->prePrintData($this->curlPostData);

            //echo '<br> curlHttpHeader: '.fcesLib::prePrint($this->curlHttpHeader);

            if ($this->debugVerbose) {
                ob_start();
                $out = fopen('php://output', 'w');
                curl_setopt($curl, CURLOPT_VERBOSE, true);
                curl_setopt($curl, CURLOPT_STDERR, $out);
            }
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($this->curlHttpHeader) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->curlHttpHeader);
        }

        if ($this->curlPostData) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->curlPostData);
        } else {
            curl_setopt($curl, CURLOPT_POST, false);
        }

        if ($this->curlFollowRedir) {
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        }

        $result = curl_exec($curl);

        if ($this->debug && $this->debugVerbose) {
            fclose($out);
            $debug = ob_get_clean();

            echo '<br><pre>' . print_r($debug, true) . '</pre>';
        }

        $curlErr = '';
        if (curl_errno($curl)) {
            $curlErr = curl_error($curl);
        }

        if ($this->debug) {
            echo '<br> curl result: <pre>' . print_r($result, true) . '</pre>';
            echo '<br> curl err:' . $curlErr;
        }

        curl_close($curl);

        if (strlen($result) > 1) {
            $this->curlLastCallResult = $result;

            if ($jsonDecode) {
                $this->curlLastCallResult = json_decode($this->curlLastCallResult, true);
            }
        }

        return $result;
    }

    private function getCodeAndMsgFromResult($resultData)
    {
        $this->curlLastCallMsg = 'N/A';
        $this->curlLastCallCode = -1;

        if (isset($resultData['message'])) {
            $this->curlLastCallMsg = $resultData['message'];
        }

        if (isset($resultData['code'])) {
            $this->curlLastCallCode = $resultData['code'];
        }
    }

    private function resetLastCallData()
    {
        $this->curlLastCallMsg = '';
        $this->curlLastCallCode = -1;
        $this->curlLastCallResult = [];
    }

    private function resetPostDataPay()
    {
        $this->payPostData = [];
    }

    private function checkPostData(string $callerName, bool $strictValidateMode = true): bool
    {
        $this->lastDataCheckErr = '';

        if ($this->isSandbox) {
            $this->curlPostData['test'] = 'true';
        }

        if ($this->apiName) {
            $this->curlPostData['merchant'] = $this->apiName;
        }

        if ($this->apiPass) {
            $this->curlPostData['secret'] = $this->apiPass;
        }

        if ($this->curlPostData) {
            $foundAllReq = true;
            $tempFinalData = [];

            if (isset($this->reqParamsMap[$callerName])) {
                foreach ($this->reqParamsMap[$callerName] as $reqParam) {
                    if (isset($this->curlPostData[$reqParam])) {
                        $tempFinalData[$reqParam] = $this->curlPostData[$reqParam];
                    } else {
                        $this->lastDataCheckErr = 'caller: ' . $callerName . ' not found required param: ' . $reqParam;
                        $foundAllReq = false;
                        break;
                    }
                }
            }

            if ($foundAllReq) {
                if (isset($this->optParamsMap[$callerName])) {
                    foreach ($this->optParamsMap[$callerName] as $optParam) {
                        if (isset($this->curlPostData[$optParam])) {
                            $tempFinalData[$optParam] = $this->curlPostData[$optParam];
                        }
                    }
                }

                if ($strictValidateMode) {
                    $this->curlPostData = $tempFinalData;
                }

                return true;
            } elseif ($strictValidateMode) {
                $this->curlPostData = [];
            }
        }

        return false;
    }

    public function getAvailableMethods()
    {
        $this->curlPostData = ['type' => 'json'];

        $url = self::API_BASE_ENDPOINT . self::ACTION_METHODS;
        $retArr = [];

        if ($this->checkPostData(self::ACTION_METHODS, true)) {
            if (isset($this->curlPostData['test'])) {
                unset($this->curlPostData['test']);
            }

            $retArr = $this->curlCall($url);

            if ($retArr) {
                return json_decode($retArr, true);
            }
        }

        return $retArr;
    }

}
