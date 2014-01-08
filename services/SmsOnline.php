<?php

namespace omnilight\sms\services;
use Guzzle\Http\Client;
use omnilight\sms\SmsService;
use yii\base\Component;


/**
 * Class SmsOnline
 * @package \omnilight\sms\services
 */
class SmsOnline extends Component implements SmsService
{
	const SMS_ONLINE_URL = 'http://sms.smsonline.ru/mt.cgi';

	/**
	 * Login for SMS Online
	 * @var string
	 */
	public $login;
	/**
	 * Password for SMS Online
	 * @var
	 */
	public $password;
	/**
	 * Default 'From' name for SMS
	 * @var string
	 */
	public $from;

	/**
	 * @param string $phone
	 * @param string $message
	 * @param string $from
	 * @return bool
	 */
	public function send($phone, $message, $from = null)
	{
		if ($from === null)
			$from = $this->from;

		$params = array(
			'user' => $this->login,
			'pass' => $this->password,
			'to' => $phone,
			'txt' => nl2br($message),
			'utf' => 1,
		);

		if($from !== null)
			$params['from'] = $from;

		$client = new Client();
		$response = $client->get(self::SMS_ONLINE_URL, [], [
			'query' => $params
		])->send();

		if ($response->isError()) {
			\Yii::error(strtr('SMS sending to SMS online results in system error: {error}',[
				'{error}' => $response->getStatusCode()
			]), self::className());
			return false;
		} else {
			$message = $response->getMessage();

			if(preg_match('#<code>0</code>#', $response->getBody()))
				return true;
			else {
				\Yii::error(strtr('SMS online returned error: {error}',[
					'{error}' => $response->getMessage(),
				]), self::className());
				return false;
			}
		}
	}


} 