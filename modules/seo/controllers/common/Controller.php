<?php

declare(strict_types=1);

namespace app\modules\seo\controllers\common;

use app\modules\seo\services\SeoService;
use app\modules\seo\services\CityService;

/**
 * Represents the base class for the category controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    protected $seoService;

    public function __construct(
        $id,
        $module,
        SeoService $seoService,
        $config = []
    ) {
        $this->seoService = $seoService;

        parent::__construct($id, $module, $config);
    }
}
