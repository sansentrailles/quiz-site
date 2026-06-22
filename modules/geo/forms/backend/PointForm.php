<?php

declare(strict_types=1);

namespace app\modules\geo\forms\backend;

use app\modules\geo\models\Point;
use app\modules\geo\models\Route;
use app\modules\geo\models\traits\PointAttributeLabelsTrait;
use yii\base\Model;

class PointForm extends Model
{
    use PointAttributeLabelsTrait;

    public $id;
    public $route_id;
    public $title;
    public $longitude;
    public $latitude;
    public $is_visible;
    private $route;

    public function __construct(?Point $route = null, $config = [])
    {
        $this->route = $route;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->route) {
            return;
        }

        $this->id         = $this->route->id;
        $this->route_id   = $this->route->route_id;
        $this->title      = $this->route->title;
        $this->longitude  = $this->route->longitude;
        $this->latitude   = $this->route->latitude;
        $this->is_visible = $this->route->is_visible;
    }

    public function rules()
    {
        return [
            [['is_visible'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'required', 'message' => 'Введите название'],
            [['latitude', 'longitude'], 'required', 'message' => 'Введите координаты'],
            [['latitude', 'longitude'], 'filter', 'filter' => function ($value) {
                return str_replace(',', '.', $value);
            }],
            [['latitude'], 'number', 'min' => -90, 'max' => 90],
            ['longitude', 'number', 'min' => -180, 'max' => 180],
            [['route_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Route::class,
                'targetAttribute' => ['route_id' => 'id']
            ],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->route) {
            return $this->route->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->route) {
            return false;
        }

        return true;
    }

    public function setRoute(int $routeId)
    {
        $this->route_id = $routeId;
    }
}
