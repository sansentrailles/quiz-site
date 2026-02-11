<?php

declare(strict_types=1);

namespace app\modules\seo\controllers\common;

use app\modules\seo\services\SeoService;
use app\modules\seo\services\MetricService;
use app\modules\seo\services\MetaTagService;

/**
 * Represents the base class for the category controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    public function __construct(
        $id,
        $module,
        protected SeoService $seoService,
        protected MetricService $metricService,
        protected MetaTagService $metaTagService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }
}
