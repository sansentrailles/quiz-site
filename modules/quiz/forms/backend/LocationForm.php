<?php

declare(strict_types=1);

namespace app\modules\quiz\forms\backend;

use app\custom\files\BaseImageFile;
use app\custom\traits\common\form\UploadFilesTrait;
use app\modules\quiz\models\Location;
use app\modules\quiz\models\traits\LocationAttributeLabelsTrait;
use yii\base\Model;
use yii\behaviors\SluggableBehavior;

class LocationForm extends Model
{
    use LocationAttributeLabelsTrait;

    public $id;
    public $title;
    public $desc;
    public $address;
    public $longitude;
    public $latitude;
    public $workmode;
    private $location;

    public function __construct(?Location $location = null, $config = [])
    {
        $this->location = $location;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->location) {
            return;
        }

        $this->id        = $this->location->id;
        $this->title     = $this->location->title;
        $this->desc      = $this->location->desc;
        $this->address   = $this->location->address;
        $this->longitude = $this->location->longitude;
        $this->latitude  = $this->location->latitude;
        $this->workmode  = $this->location->workmode;
    }

    public function rules()
    {
        return [
            [['address', 'title'], 'string', 'max' => 255],
            [['workmode', 'desc'], 'string'],
            [['longitude', 'latitude'], 'string', 'max' => 255],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->location) {
            return $this->location->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->location) {
            return false;
        }

        return true;
    }
}
