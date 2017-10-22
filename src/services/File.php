<?php

namespace omnilight\sms\services;

use omnilight\sms\SmsServiceInterface;
use yii\base\Component;


/**
 * Class File
 */
class File extends Component implements SmsServiceInterface
{
    /**
     * @var string
     */
    public $from;
    /**
     * File where sms will be saved
     * @var string
     */
    public $file = '@runtime/sms.log';
    /**
     * Template of the string
     * @var string
     */
    public $template = '[{date}] {from} {phone} {message}';

    /**
     * @param string $phone
     * @param string $message
     * @param string $from
     * @return bool
     */
    public function send($phone, $message, $from)
    {
        if ($from === null) {
            $from = $this->from;
        }

        $f = fopen(\Yii::getAlias($this->file), 'a+');
        $string = strtr($this->template, [
            '{date}' => date_create('now')->format('Y-m-d H:M:s'),
            '{from}' => $from,
            '{phone}' => $phone,
            '{message}' => $message,
        ]);
        fwrite($f, $string);
        fclose($f);
    }
}