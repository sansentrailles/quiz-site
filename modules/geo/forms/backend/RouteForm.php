<?php

declare(strict_types=1);

namespace app\modules\geo\forms\backend;

use app\modules\geo\models\Route;
use app\modules\geo\models\traits\RouteAttributeLabelsTrait;
use yii\base\Model;

class RouteForm extends Model
{
    use RouteAttributeLabelsTrait;

    public $id;
    public $title;
    public $is_visible;
    private $route;

    public function __construct(?Route $route = null, $config = [])
    {
        $this->route = $route;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->route) {
            return;
        }

        $this->id    = $this->route->id;
        $this->title = $this->route->title;
        $this->is_visible = $this->route->is_visible;
    }

    public function rules()
    {
        return [
            [['is_visible'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'required', 'message' => 'Введите название'],
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
}
