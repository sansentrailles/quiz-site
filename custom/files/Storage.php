<?php

declare(strict_types=1);

namespace app\custom\files;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class Storage
{
    private static function getBucketConfig(string $bucket): array
    {
        $config = Yii::$app->params['buckets'][$bucket] ?? null;

        if ($config === null) {
            throw new InvalidConfigException("Bucket '{$bucket}' not found in params.");
        }

        return $config;
    }

    private static function buildPath(string $bucket, string $fileName): string
    {
        $config = self::getBucketConfig($bucket);
        $base = $config['baseSubPath'];
        $parts = self::pathParts($fileName);

        return 'files/' . $base . '/' . implode('/', $parts) . '/' . $fileName;
    }

    private static function pathParts(string $fileName): array
    {
        $hash = substr(md5($fileName), 0, 6);
        return [substr($hash, 0, 2), substr($hash, 2, 2)];
    }

    public static function fullPath(string $bucket, string $fileName): string
    {
        return Yii::getAlias('@webroot') . '/' . self::buildPath($bucket, $fileName);
    }

    public static function url(string $bucket, string $fileName): string
    {
        return '/' . self::buildPath($bucket, $fileName);
    }

    public static function save(string $bucket, string $tempPath, string $fileName): string
    {
        $dest = self::fullPath($bucket, $fileName);
        $dir = dirname($dest);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        copy($tempPath, $dest);

        return $fileName;
    }

    public static function delete(string $bucket, ?string $fileName): bool
    {
        if (!$fileName) {
            return false;
        }

        $path = self::fullPath($bucket, $fileName);

        if (file_exists($path)) {
            return unlink($path);
        }

        return false;
    }

    public static function exists(string $bucket, string $fileName): bool
    {
        return file_exists(self::fullPath($bucket, $fileName));
    }

    /**
     * Удаляет все файлы модели, описанные в getFileFields().
     * Принимает объект с интерфейсом Fileable или массив ['field' => 'bucket'].
     */
    public static function deleteModelFiles(ActiveRecord|array $source): void
    {
        $fields = $source instanceof ActiveRecord && method_exists($source, 'getFileFields')
            ? $source->getFileFields()
            : (is_array($source) ? $source : []);

        foreach ($fields as $attribute => $bucket) {
            $fileName = null;

            if ($source instanceof ActiveRecord) {
                $fileName = $source->$attribute;
            }

            self::delete((string) $bucket, $fileName);
        }
    }
}
