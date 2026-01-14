<?php

declare(strict_types=1);

namespace app\modules\quiz\controllers\common;

use app\modules\quiz\services\FaqItemService;
use app\modules\quiz\services\QuizService;
use app\modules\quiz\services\LabelService;
use app\modules\quiz\services\LocationService;
use app\modules\quiz\services\TeamService;
use app\modules\quiz\services\ParticipantService;
use app\modules\quiz\services\QuizBookingService;

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
        protected readonly LocationService $locationService,
        protected readonly FaqItemService $faqItemService,
        protected readonly TeamService $teamService,
        protected readonly ParticipantService $participantService,
        protected readonly QuizBookingService $quizBookingService,
    ) {
        parent::__construct($id, $module, $config);
    }
}
