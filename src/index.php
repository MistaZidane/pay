<?php
namespace SevenPay\PayUnit;
class PayUnit
{
    public $apiKey;
    public $apiPassword;
    public $apiUser;
    public $returnUrl;
    public $amount;
    public $transactionId;
    public $notifyUrl;
    public $mode;
    /**
     * @param string $apikey Your apikey
     * @param string $apiPassword Your apiPassword
     * @param string $apiUser Your apiUsername
     * @param string $returnUrl Your return Url
     * @param string $amount Clients amount
     */
    function __construct($apiKey, $apiPassword, $apiUser, $returnUrl,$notifyUrl, $mode)
    {
        $this->apiKey      = $apiKey;
        $this->apiPassword = $apiPassword;
        $this->apiUser     = $apiUser;
        $this->returnUrl   = $returnUrl;
        $this->notifyUrl   = $notifyUrl;
        $this->mode   = $mode;
    }
    /**
     * Used to perform the Transaction
     */
    public function makePayment($amountTobePaid)
    {

        $this->transactionId = uniqid();
        $encodedAuth         = base64_encode($this->apiUser . ":" . $this->apiPassword);
        $postRequest         = array(
            "total_amount" => $amountTobePaid,
            "return_url" => $this->returnUrl,
            "notify_url" => $this->notifyUrl,
            "transaction_id" => $this->transactionId,
            "description"=> "PayUnit web payments"
        );
        // http://192.168.100.90:5000/api/gateway/initialize
        $cURLConnection      = curl_init();
        curl_setopt($cURLConnection, CURLOPT_URL, "http://192.168.100.70:5000/api/gateway/initialize");
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, json_encode($postRequest)); 
          $secArr =  array(
            "x-api-key: {$this->apiKey}",
            "authorization: Basic: {$encodedAuth}",
            'Accept: application/json',
            'Content-Type: application/json',
            "mode: {$this->mode}"
          );
        $all =  array_merge($postRequest,$secArr);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER,$all);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $jsonArrayResponse = json_decode($apiResponse);

    if(isset($jsonArrayResponse->body->transaction_url)){
        echo("dfdgdg");
        //die();
          header("Location: {$jsonArrayResponse->body->transaction_url}");
        exit();  
    }
    else{
        echo($apiResponse);
    }
    }
}
?>
