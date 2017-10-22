<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.01.14
 * Time: 17:21
 */

namespace omnilight\sms;

/**
 * Interface SmsServiceInterface
 * @package omnilight\sms
 */
interface SmsServiceInterface
{
    /**
     * @param mixed $phone
     * @param string $message
     * @param string $from
     * @return bool
     */
    public function send($phone, $message, $from);
} 