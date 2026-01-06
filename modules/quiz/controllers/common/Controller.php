<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\common;

use app\modules\quiz\services\QuizService;
use app\modules\quiz\services\LabelService;

/**
 * Represents the base class for the category controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    public function __construct(
        $id,
        $module,
        $config,
        protected readonly QuizService $quizService,
        protected readonly LabelService $labelService,
    ) {
        parent::__construct($id, $module, $config);
    }
}
