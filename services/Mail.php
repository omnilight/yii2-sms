<?php

namespace omnilight\sms\services;
use omnilight\sms\SmsServiceInterface;
use yii\base\Component;


/**
 * Class Mail implements sms sending to email (as mail) for debug
 * @package \omnilight\sms\services
 */
class Mail extends Component implements SmsServiceInterface
{
    /**
     * @var string
     */
    public $to;
    /**
     * @var
     */
    public $from;
    public $subject = 'New SMS';
    /**
     * @param string $phone
     * @param string $message
     * @param string $from
     * @return bool
     */
    public function send($phone, $message, $from)
    {
        \Yii::$app->mail->compose([
            'html' => strtr("==== SMS [{from}] ====\nTo: {phone}\n\n{message}",[
                '{from}' => $from,
                '{phone}' => $phone,
                '{message}' => $message,
            ])
        ])
            ->setTo($this->to)
            ->setFrom($this->from)
            ->send();
    }
} 