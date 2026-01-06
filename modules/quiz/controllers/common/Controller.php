<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\common;

use app\modules\quiz\services\QuizService;

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
    ) {
        parent::__construct($id, $module, $config);
    }
}
