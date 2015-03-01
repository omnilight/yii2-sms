<?php

namespace omnilight\sms\services;
use yii\base\Component;
use omnilight\sms\SmsServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;


/**
 * Class SmsOnlineBulk
 */
class SmsOnlineBulk extends Component implements SmsServiceInterface
{
    const SMS_ONLINE_URL = 'https://bulk.sms-online.com/';
    /**
     * @var string
     */
    public $login;
    /**
     * @var string
     */
    public $secretKey;
    /**
     * @var string
     */
    public $from;

    /**
     * @param string $phone
     * @param string $message
     * @param string $from
     * @return bool
     */
    public function send($phone, $message, $from)
    {
        if ($from === null)
            $from = $this->from;

        $params = array(
            'user' => $this->login,
            'phone' => $phone,
            'txt' => nl2br($message),
        );

        if ($from !== null)
            $params['from'] = $from;

        $params['sign'] = md5(
            $params['user'].
            $params['from'].
            $params['phone'].
            $params['txt'].
            $this->secretKey
        );

        $client = new Client();
        try {
            $response = $client->get(self::SMS_ONLINE_URL, [
                'query' => $params
            ]);
        } catch (TransferException $e) {
            \Yii::error(strtr('SMS sending to SMS online Bulk API results in system error: {error}', [
                '{error}' => $e->getMessage()
            ]), self::className());

            throw $e;
        }

        if (preg_match('#<code>0</code>#', $response->getBody()))
            return true;
        else {
            \Yii::error(strtr('SMS online returned error: {error}', [
                '{error}' => $response->getBody(),
            ]), self::className());
            return false;
        }
    }
}