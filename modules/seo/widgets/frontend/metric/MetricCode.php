<?php

namespace app\modules\seo\widgets\frontend\metric;

use Yii;
use yii\base\Widget;
use app\modules\seo\services\MetricService;

class MetricCode extends Widget
{
    private $metricService;
    public $template;
    public $place;

    const PLACE_HEAD = 1;
    const PLACE_BODY = 2;

    public function __construct(
        MetricService $metricService,
        $config = []
    )
    {
        $this->metricService = $metricService;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if($this->template === null) {
            $this->template = 'default';
        }

        $metrics = $this->metricService->getVisibleForPlace($this->place);
        if (!is_array($metrics) || count($metrics) == 0) {
            return false;
        }

        return $this->render($this->template, [
            'metrics' => $metrics,
        ]);
    }
}
