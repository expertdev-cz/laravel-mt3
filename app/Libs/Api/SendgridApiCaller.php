<?php

namespace App\Libs\Api;

class SendgridApiCaller
{
    //private string $lastCallErr;
    private SendgridApi $sendgridApi;

    public function __construct(){
        $this->sendgridApi = new SendgridApi();
        //$this->lastCallErr = '';
    }

    public function createMarketingContact(string $email){
        return $this->sendgridApi->createMarketingContact($email);
    }
}
