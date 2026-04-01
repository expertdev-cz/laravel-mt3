<?php

namespace App\Libs\Api;

use App\Models\Courses\Course;
use App\Models\Eshop\Api\PaymentComgate;
use App\Models\Eshop\Api\PaymentComgateLog;
use App\Models\Eshop\Order;

class ComgateApiCaller
{
    public const STATUS_NICE_NEW = 'Platba byla vytvořena v platebním systému';
    public const STATUS_NICE_PENDING = 'Čekající platba';
    public const STATUS_NICE_PAID = 'Zaplaceno';
    public const STATUS_NICE_CANCELLED = 'Platba byla zrušena';
    public const STATUS_NICE_ALREADY_PAYED = 'Objednávka již byla zaplacena';
    public const STATUS_NICE_TEXT_NOT_FOUND = 'Status nenalezen';

    private string $lastCallErr;
    private array $paymentToComgateMethodMap;
    private ComgateApi $comgateApi;

    public function __construct(){
        $this->comgateApi = new ComgateApi(true);
        $this->lastCallErr = '';
    }

    public function setSandboxMode():void{
        $this->comgateApi->setSandboxMode(true);
    }

    public function setProductionMode():void{
        $this->comgateApi->setSandboxMode(false);
    }

    public function isComgateApiInit():bool{
        return $this->comgateApi->checkIfApiLoginIsSet();
    }

    public function setUseInBackgroundToFalse(){
        $this->comgateApi->apiUseInBackgroundMode = false;
    }

    public function getLastCallError(): string{
        return $this->lastCallErr;
    }

    private static function getComgateOrderDbDataByOrderId(int $orderId){
        return PaymentComgate::query()->where('order_id','=',$orderId)->limit(1)->get()->first();
    }

    public function getComgateOrderDbDataByRefId(string $refId){
        return PaymentComgate::query()->where('comgate_ref_id','=',$refId)->limit(1)->get()->first();
    }

    public function payOrder(Order $order){
        if ($order->is_payed){
            return self::STATUS_NICE_ALREADY_PAYED;
        }

        $existComgateData = self::getComgateOrderDbDataByOrderId($order->id);

        if ($existComgateData){
            if($existComgateData['status']==ComgateApi::API_STATUS_NEW){
                return $existComgateData['payment_url'];
            }
        }else{
            $this->comgateApi->setAdditionalPayData($order->phone);

            $retData = $this->comgateApi->createPay(
                $order->price_total*100,
                'Obj. id: '.$order->id,
                $order->id,
                $order->email,
                'CARD_ALL'
            );

            if ($retData){
                $ret = false;
                if (isset($retData['transId'],$retData['redirect'])){

                    PaymentComgate::create([
                        'order_id'=>$order->id,
                        'comgate_ref_id'=>$retData['transId'],
                        'payment_url'=>$retData['redirect'],
                        'status'=>ComgateApi::API_STATUS_NEW
                    ]);

                    $ret = $retData['redirect'];
                }else{
                    $this->saveToErrLog($order->id,$this->comgateApi->getLastDataCheckErr());
                }

                return $ret;
            }else{
                $this->lastCallErr = 'API call return not contain needed data.';
            }
        }

        return false;
    }

    public function listenerOrderStatus(){
        $transactionId = $this->getPostData('transId');
        $paymentStatus = $this->getPostData('status');
        $apiSecret = $this->getPostData('secret');

        if ($transactionId && $paymentStatus && $apiSecret){
            if ($apiSecret==$this->comgateApi->getApiSecret()){
                $existInDb = $this->getComgateOrderDbDataByRefId($transactionId);

                if ($existInDb){
                    $existInDb->status= $paymentStatus;
                    $existInDb->save();

                    if ($paymentStatus==ComgateApi::API_STATUS_PAID){
                        $order = Order::whereId($existInDb->order_id)->get()->first();
                        $order->is_payed = true;
                        $order->save();
                    }
                }
            }else{
                $this->saveToErrLog(-1,'Listener err, trans id:'.$transactionId.' api secret auth failed.');
            }
        }
    }

    private function saveToErrLog(int $orderId,string $msg){
        PaymentComgateLog::create([
            'order_id'=>$orderId,
            'err_msg'=>$msg
        ]);
    }

    private function getPostData($valueName){
        if (isset($_POST[$valueName]) && $_POST[$valueName]){
            return $_POST[$valueName];
        }
        return false;
    }

    public static function getNiceStatusText($statusText): string{
        if (strlen($statusText)==0){
            return '';
        }

        return match ($statusText) {
            ComgateApi::API_STATUS_NEW => self::STATUS_NICE_NEW,
            ComgateApi::API_STATUS_PENDING => self::STATUS_NICE_PENDING,
            ComgateApi::API_STATUS_PAID => self::STATUS_NICE_PAID,
            ComgateApi::API_STATUS_CANCELED => self::STATUS_NICE_CANCELLED,
            default => self::STATUS_NICE_TEXT_NOT_FOUND,
        };
    }

    public static function getNiceComgateData($orderId): ?PaymentComgate{
        $data = self::getComgateOrderDbDataByOrderId($orderId);

        if ($data){
            $data['statusNice'] = '';
            $data['showUrl'] = false;

            if (isset($data['status'])){
                $data['statusNice'] = self::getNiceStatusText($data['status']);

                if ($data['status']==ComgateApi::API_STATUS_NEW){
                    $data['showUrl'] = true;
                }
            }

            return $data;
        }
        return null;
    }

    public function getOrderAndEventByComgateId($comgateId): bool|array{
        $exist = $this->getComgateOrderDbDataByRefId($comgateId);

        if ($exist){
            $orderItem = Order::query()->where('id','=',$exist['order_id'])->limit(1)->get()->first();

            if ($orderItem){
                $dataItem = Course::whereId($orderItem['course_id'])->get()->first();

                if ($dataItem){
                    return ['comgate'=>$exist,'order'=>$orderItem,'data'=>$dataItem];
                }
            }
        }

        return false;
    }

    public static function getHashFromString(string $str):string{
        return md5($str.'b5244t3');
    }
}
