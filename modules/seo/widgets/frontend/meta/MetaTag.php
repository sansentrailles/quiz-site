<?php

namespace app\modules\seo\widgets\frontend\meta;

use Yii;
use yii\base\Widget;
use app\modules\seo\services\MetaTagService;

class MetaTag extends Widget
{
    private $metaTagService;
    public $view;

    public function __construct(
        MetaTagService $metaTagService,
        $config = []
    )
    {
        $this->metaTagService = $metaTagService;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        if (!$this->view) {
            throw new InvalidConfigException('The view is a required parameter');
        }
    }

    public function run()
    {
        $metas = $this->metaTagService->getVisible();
        if (!is_array($metas) || count($metas) == 0) {
            return false;
        }

        foreach ($metas as $meta) {
            $this->view->registerMetaTag([
                'name' => $meta->name,
                'content' => $meta->content,
            ]);
        }

        // return $this->render($this->template, [
        //     'metrics' => $metrics,
        // ]);
    }
}
