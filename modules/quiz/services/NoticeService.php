<?php

namespace app\modules\quiz\services;

use Yii;
use app\custom\helpers\MailHelper;
use app\modules\quiz\models\QuizBooking;
use app\modules\settings\components\Setting;

class NoticeService
{
    private MailHelper $mailer;
    private Setting $setting;
    private bool $isTransportConfigured = false;

    public function __construct(MailHelper $mailer)
    {
        $this->setting = Yii::$app->setting;
        $this->mailer = $mailer;
        

        $this->configureTransport();
    }

    private function configureTransport(): void
    {
        $username = $this->setting->get('mailer.username');
        $password = $this->setting->get('mailer.password');
        $host = $this->setting->get('mailer.host');
        $port = $this->setting->get('mailer.port');

        if ($username && $password && $host && $port) {
            $this->mailer->setTransport($this->mailer->getDsn($username, $password, $host, $port));
            $this->isTransportConfigured = true;
        } else {
            Yii::warning('SMTP-настройки не заданы. Отправка писем невозможна.', 'quiz.notice');
        }
    }

    public function notifyQuizBooking(QuizBooking $booking)
    {
        // Проверяем, настроен ли транспорт
        if (!$this->isTransportConfigured) {
            Yii::error('Невозможно отправить уведомление о квизе: SMTP не настроен.', 'quiz.notice');
            return false;
        }

        $message = 'Заявка на квиз ' . $booking->quiz->title.'<br><br>';
        $url = \yii\helpers\Url::to(['/admin/quiz/participants/apply-booking', 'id' => $booking->id], true);

        $message .= "Имя: ".$booking->name."<br>";
        if ($booking->is_single) {
            $message .= "Один игрок (без команды)<br>";
        } else {
            $message .= "Название команды: ". $booking->team_name.'<br>';
        }
        $message .= "Контакт: ".$booking->contact."<br>";
        $message .= "Количество участников: ". $booking->persons."<br>";
        $message .= "Посмотреть <a href='".$url."'>заявку</a>";


        $subject = 'Запись на квиз: ' . $booking->quiz->title;

        $emails = $this->setting->get('mailer.to');
        $this->sendMessage($message, $subject, $emails);

        return true;
    }

    public function sendMessage(string $message, string $subject, array $emails): bool
    {
        if (!$this->isTransportConfigured) {
            Yii::error('Попытка отправки письма при ненастроенном SMTP.', 'quiz.notice');
            return false;
        }

        $from = $this->setting->get('mailer.noreply');
        $success = true;

        foreach ($emails as $email) {
            try {
                $this->mailer->send($from, $email, $subject, $message);
            } catch (\Exception $e) {
                Yii::error("Ошибка отправки письма на {$email}: " . $e->getMessage(), 'quiz.notice');
                $success = false;
            }
        }

        return $success;
    }
}
