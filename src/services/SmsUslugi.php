<?php

namespace omnilight\sms\services;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use omnilight\sms\SmsServiceInterface;

class SmsUslugi extends Component implements SmsServiceInterface
{
    const URL = 'https://lcab.sms-uslugi.ru/lcabApi/sendSms.php';

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $source = null;

    /**
     * @var integer
     */
    public $channel = 0;

    /**
     * @param string $phone
     * @param string $message
     * @param string $from
     * @return bool
     */
    public function send($phone, $message, $from)
    {
        $params = [];
        if (is_array($phone)) {
            $phone = implode(',', $phone);
        }
        if (isset($this->source)) {
            $params['source'] = $this->source;
        } elseif (isset($from)) {
            $params['source'] = $from;
        }
        $params = [
            'login'     => $this->login,
            'password'  => $this->password,
            'to'        => $phone,
            'txt'       => $message,
            'channel'   => $this->channel
        ];
        $client = new Client();
        try {
            $response = $client->get(self::URL,
                [
                'query' => $params
            ]);
        } catch (TransferException $e) {
            Yii::error(strtr('SMS sending to '.self::className().' results in system error: {error}',
                    [
                '{error}' => $e->getMessage()
                ]), self::className());

            throw $e;
        }

        $jsonResp = Json::decode($response->getBody()->getContents(), false);

        if ((int) $jsonResp->code === 1) {
            return true;
        } else {
            Yii::error(strtr(self::className().' returned error: {error}',
                    [
                '{error}' => (string) $jsonResp->descr,
                ]), self::className());
            return false;
        }
    }
}