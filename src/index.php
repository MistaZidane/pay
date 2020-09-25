<?php
?>
<?php
namespace SevenPay;
class PayUnit
{
    public $apiKey;
    public $apiPassword;
    public $apiUser;
    public $returnUrl;
    public $amount;
    public $transactionId;
    /**
     * @param string $apikey Your apikey
     * @param string $apiPassword Your apiPassword
     * @param string $apiUser Your apiUsername
     * @param string $returnUrl Your return Url
     * @param string $amount Clients amount
     */
    function __construct($apiKey, $apiPassword, $apiUser, $returnUrl, $amount)
    {
        $this->apiKey      = $apiKey;
        $this->apiPassword = $apiPassword;
        $this->apiUser     = $apiUser;
        $this->returnUrl   = $returnUrl;
        $this->amount      = $amount;
    }
    /**
     * Used to perform the Transaction
     */
    public function MakePayment()
    {
        $this->transactionId = uniqid();
        $encodedAuth         = base64_encode($this->apiUser . ":" . $this->apiPassword);
        $postRequest         = array(
            "bills" => array(
                array(
                    "amount" => 1500,
                    "bill_ref" => 360582888
                )
            ),
            "total_amount" => $this->amount,
            "return_url" => $this->returnUrl,
            "transaction_id" => $this->transactionId
        );
        $cURLConnection      = curl_init();
        curl_setopt($cURLConnection, CURLOPT_URL, "http://192.168.100.70:5000/payments/gateway/initialize");
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, json_encode($postRequest));
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
            "x-api-Key: {$this->apiKey}",
            "authorization: Basic {$encodedAuth}",
            'Accept: application/json',
            'Content-Type: application/json'
        ));
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $jsonArrayResponse = json_decode($apiResponse);
        if ($jsonArrayResponse->status == 201) {
            header("Location: {$jsonArrayResponse->transaction_url}");
        } else {
            echo ("failed");
        }
    }
}
$payment = new PayUnit("7c4a8d09ca3762af61e59520943dc26494f8941b", "easylight-payments@2020*", 'myeasylight-payments', 'https://sturep.herokuapp.com', '1500');
$payment->MakePayment();
?> 