<?php

declare(strict_types=1);

namespace app\custom\interfaces;

interface Fileable
{
    /**
     * Возвращает массив полей с файлами.
     * Ключ — атрибут модели, значение — имя bucket'а.
     *
     * Пример: ['image' => 'quizImage', 'cover' => 'quizImage']
     */
    public function getFileFields(): array;
}
