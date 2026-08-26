<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\delete;

use yii\base\Widget;

/**
 * Displays remove button.
 */
class Delete extends Widget
{
    /**
     * @var string
     */
    public $url;

    public function init(): void
    {
        DeleteAsset::register($this->getView());
        parent::init();
    }

    public function run()
    {
        return $this->render('button', [
            'url' => $this->url,
        ]);
    }
}
