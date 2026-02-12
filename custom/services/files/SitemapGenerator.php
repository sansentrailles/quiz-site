<?php

namespace app\custom\services\files;

use XMLWriter;
use DateTime;
use InvalidArgumentException;

/**
 * Класс для генерации sitemap.xml.
 * Отвечает за формирование XML-файла в соответствии со стандартом sitemaps.org.
 * Класс не зависит от фреймворка и может быть использован в любом PHP-проекте.
 */
class SitemapGenerator
{
    /**
     * @var XMLWriter
     */
    private $writer;

    /**
     * @var string Путь к файлу, в который будет записана карта сайта.
     */
    private $filePath;

    /**
     * @var string Домен сайта с протоколом (e.g., https://example.com)
     */
    private $domain;

    /**
     * @var int Счетчик добавленных URL.
     */
    private $urlCount = 0;

    /**
     * @param string $filePath Абсолютный путь к файлу sitemap.xml.
     * @param string $domain Домен сайта (например, 'https://mysite.com').
     */
    public function __construct(string $filePath, string $domain)
    {
        $this->filePath = $filePath;
        $this->domain = rtrim($domain, '/'); // Убираем слэш в конце, если он есть
        
        $this->writer = new XMLWriter();
        $this->writer->openURI($this->filePath);
        $this->writer->startDocument('1.0', 'UTF-8');
        $this->writer->setIndent(true); // Для читаемого формата файла
        
        // Корневой элемент <urlset>
        $this->writer->startElement('urlset');
        $this->writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    }

    /**
     * Добавляет URL в карту сайта.
     *
     * @param string $loc Относительный URL страницы (например, '/about').
     * @param string|int|null $lastmod Дата последнего изменения в формате W3C или Unix timestamp.
     * @param string|null $changefreq Частота изменений ('always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never').
     * @param float|null $priority Приоритетность URL (от 0.0 до 1.0).
     * @throws InvalidArgumentException
     */
    public function addUrl(string $loc, $lastmod = null, ?string $changefreq = null, ?float $priority = null): void
    {
        $this->writer->startElement('url');
        
        // loc - обязательный элемент
        $absoluteUrl = $this->domain . $loc;
        $this->writer->writeElement('loc', $absoluteUrl);
        
        // lastmod
        if ($lastmod !== null) {
            $this->writer->writeElement('lastmod', $this->formatDate($lastmod));
        }

        // changefreq
        if ($changefreq !== null) {
            $allowedFreq = ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'];
            if (!in_array($changefreq, $allowedFreq)) {
                throw new InvalidArgumentException("Недопустимое значение для changefreq: {$changefreq}");
            }
            $this->writer->writeElement('changefreq', $changefreq);
        }

        // priority
        if ($priority !== null) {
            if ($priority < 0.0 || $priority > 1.0) {
                throw new InvalidArgumentException("Приоритет должен быть между 0.0 и 1.0. Передано: {$priority}");
            }
            $this->writer->writeElement('priority', number_format($priority, 1, '.', ''));
        }

        $this->writer->endElement(); // </url>
        $this->urlCount++;
    }

    /**
     * Завершает создание файла sitemap.
     */
    public function generate(): void
    {
        $this->writer->endElement(); // </urlset>
        $this->writer->endDocument();
        $this->writer->flush();
    }

    /**
     * Возвращает количество добавленных URL.
     * @return int
     */
    public function getUrlCount(): int
    {
        return $this->urlCount;
    }

    /**
     * Форматирует дату в W3C-совместимый формат.
     * @param string|int $date
     * @return string
     */
    private function formatDate($date): string
    {
        if (is_numeric($date)) {
            return date('c', (int)$date);
        }
        
        $dt = new DateTime($date);
        return $dt->format(DateTime::W3C);
    }
}
