<?php

declare(strict_types=1);

namespace app\custom\helpers;

use Yii;

class AppHelper
{
    public static function getManifestData($fileName, $resourceName)
    {
        $file = Yii::getAlias('@app') . '/public_html/' . $fileName;

        if (!file_exists($file)) {
            return $resourceName;
        }

        $data = json_decode(file_get_contents($file), true);

        if (empty($data[$resourceName])) {
            return $resourceName;
        }

        return $data[$resourceName];
    }
}
