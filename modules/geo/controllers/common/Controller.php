<?php

declare(strict_types=1);

namespace app\modules\geo\controllers\common;

/**
 * Represents the base class for the category controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    public function __construct(
        $id,
        $module,
        $config,
    ) {
        parent::__construct($id, $module, $config);
    }
}
