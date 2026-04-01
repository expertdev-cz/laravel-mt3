<?php

namespace App\Libs\Api;

class SendgridApi
{
    //TODO: make base curl class
    const CURL_DEFAULT_CONTENT = 'application/json';
    const CURL_DEFAULT_ACCEPT = 'application/json';

    const API_BASE_ENDPOINT = 'https://api.sendgrid.com/v3/';

    private string $apiToken;

    private bool $isSandbox;
    private bool $debug = true;
    private bool $debugVerbose= true;

    private array $curlHttpHeader;
    private array $curlPostData;
    private bool $curlFollowRedir = true;

    private $curlLastCallMsg=false;
    private $curlLastCallCode=false;
    private $curlLastCallResult=false;

    public function __construct()
    {
        $this->apiToken = (string) env('SENDGRID_API_KEY', '');
    }

    public function createMarketingContact($email){
        if ($this->apiToken === '') {
            return false;
        }

        $this->curlPostData = ['contacts' => ['email'=>$email]];
        $retArr = $this->curlCall(self::API_BASE_ENDPOINT.'marketing/contacts');

        if ($retArr) {
            return json_decode($retArr, true);
        }

        return false;
    }

    private function setCurlAuthHttpHeader()
    {
        $this->curlHttpHeader = [
            'Authorization: Bearer ' . $this->apiToken,

        ];
    }

    private function prePrintData($data, array $hiddenParamsArr = ['secret'])
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

    private function resetLastCallData()
    {
        $this->curlLastCallMsg = '';
        $this->curlLastCallCode = -1;
        $this->curlLastCallResult = [];
    }

    private function curlCall(string $url, bool $jsonDecode = true): bool|string{
        $this->resetLastCallData();
        $this->setCurlAuthHttpHeader();

        $curl = curl_init();
        $out = false;

        if ($this->debug) {
            echo '<br> url: ' . $url;
            $this->prePrintData($this->curlPostData);

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
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->curlPostData));
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
}
