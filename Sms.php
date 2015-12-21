<?php

namespace omnilight\sms;
use yii\base\Component;


/**
 * Class Sms
 * @package \omnilight\sms
 */
class Sms extends Component
{
	/**
	 * List of SMS services
	 * @var SmsServiceInterface[]
	 */
	public $services = [];

	/**
	 * @param string $phone
	 * @param string $message
	 * @param string $from
	 * @param string $service If null, first service from {@see $services} will be used
	 * @return bool
	 */
	public function send($phone, $message, $from = null, $service = null)
	{
		if (count($this->services) == 0) {
			\Yii::error('No sms servers configured');
			return false;
		}

		if ($service === null) {
			$service = array_keys($this->services)[0];
		}

		if (!is_object($this->services[$service]))
			$this->services[$service] = \Yii::createObject($this->services[$service]);

		return $this->services[$service]->send($phone, $message, $from);
	}
} 