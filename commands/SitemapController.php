<?php

namespace app\commands;

use app\custom\services\files\SitemapGenerator;
use app\modules\quiz\services\QuizService;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Url;

/**
 * Консольная команда для генерации sitemap.xml.
 *
 * Запуск: php yii sitemap/generate
 */
class SitemapController extends Controller
{
    public function __construct(
        $id,
        $module,
        $config,
        private QuizService $quizService,
    ) {
        return parent::__construct($id, $module, $config);
    }

    public function init()
    {
        Yii::setAlias('@webroot', getcwd().'/public_html');
        Yii::setAlias('@web', getcwd().'/public_html');

        parent::init();
    }

    /**
     * Генерирует файл sitemap.xml
     * @return int Exit code
     */
    public function actionGenerate()
    {
        $this->stdout("Начинаем генерацию sitemap.xml...\n");

        // Путь к файлу sitemap.xml. Используем alias для фронтенда.
        // Для базового шаблона используйте '@app/web/sitemap.xml'
        $sitemapFile = Yii::getAlias('@webroot/sitemap.xml');
        
        // Получаем домен из параметров
        $domain = 'https://'.Yii::$app->params['siteName'];
        
        if (!$domain) {
            $this->stderr("Ошибка: параметр 'siteName' не установлен в config/params.php\n");
            return ExitCode::CONFIG;
        }

        try {
            $generator = new SitemapGenerator($sitemapFile, $domain);

            // 1. Добавляем статические страницы
            $this->stdout("Добавляем статические страницы...\n");
            $generator->addUrl('/', date('c'), 'daily', 1.0);
            $generator->addUrl('/rating', '2023-01-01T00:00:00+00:00', 'monthly', 0.8);
            $generator->addUrl('/rules', '2023-01-01T00:00:00+00:00', 'monthly', 0.8);

            // 2. Добавляем страницы из моделей (например, квизы)
            // Используем each() для экономии памяти при большом количестве записей
            $this->stdout("Добавляем квизы...\n");
            $quizes = $this->quizService->getVisible();
            foreach ($quizes as $quiz) {
                $url = $quiz->link;
                $generator->addUrl($url, $quiz->updated_at, 'weekly', 0.7);
            }

            // Завершаем генерацию и сохраняем файл
            $generator->generate();

            $this->stdout("\nГенерация sitemap.xml успешно завершена!\n");
            $this->stdout("Файл сохранен по пути: {$sitemapFile}\n");
            $this->stdout("Всего добавлено URL: {$generator->getUrlCount()}\n");

            return ExitCode::OK;

        } catch (\Exception $e) {
            $this->stderr("Произошла ошибка: " . $e->getMessage() . "\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
