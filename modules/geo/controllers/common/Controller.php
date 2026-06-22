<?php

declare(strict_types=1);

namespace app\modules\geo\controllers\common;

use app\modules\geo\services\RouteService;
use app\modules\geo\services\PointService;

/**
 * Represents the base class for the category controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    public function __construct(
        $id,
        $module,
        $config,
        protected readonly RouteService $routeService,
        protected readonly PointService $pointService,
    ) {
        parent::__construct($id, $module, $config);
    }
}
