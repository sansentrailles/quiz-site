<?php

namespace app\modules\quiz\services;

use Yii;
use app\custom\helpers\MailHelper;
use app\modules\quiz\models\QuizBooking;

class NoticeService
{
    private $mailer;
    private $setting;

    public function __construct(MailHelper $mailer)
    {
        $this->setting = Yii::$app->setting;
        $this->mailer = $mailer;

        $username = $this->setting->get('mailer.username');
        $password = $this->setting->get('mailer.password');
        $host = $this->setting->get('mailer.host');
        $port = $this->setting->get('mailer.port');

        $this->mailer->setTransport($this->mailer->getDsn($username, $password, $host, $port));
    }

    public function notifyQuizBooking(QuizBooking $booking)
    {
        $message = 'Заявка на квиз ' . $booking->quiz->title.'<br><br>';

        $message .= "Имя: ".$booking->name."<br>";
        if ($booking->is_single) {
            $message .= "Один игрок (без команды)<br>";
        } else {
            $message .= "Название команды: ". $booking->team_name.'<br>';
        }
        $message .= "Контакт: ".$booking->contact."<br>";
        $message .= "Количество участников: ". $booking->persons."<br>";


        $subject = 'Запись на квиз: ' . $booking->quiz->title;

        $emails = $this->setting->get('mailer.to');
        $this->sendMessage($message, $subject, $emails);

        return true;
    }

    public function sendMessage($message, $subject, $emails)
    {
        if (\count($emails) === 0) {
            return false;
        }

        $from = $this->setting->get('mailer.noreply');

        foreach ($emails as $email) {
            $this->mailer->send($from, $email, $subject, $message);
        }

        return true;
    }
}
