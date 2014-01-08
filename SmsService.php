<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.01.14
 * Time: 17:21
 */

namespace omnilight\sms;


interface SmsService
{
	/**
	 * @param string $phone
	 * @param string $message
	 * @param string $from
	 * @return bool
	 */
	public function send($phone, $message, $from);
} 