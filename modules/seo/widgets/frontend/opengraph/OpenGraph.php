<?php

namespace app\modules\seo\widgets\frontend\opengraph;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use app\modules\seo\services\seo\SeoService;

class OpenGraph extends Widget
{
    public $view;
    public $app_id;
    public $title;
    public $type;
    public $description;
    public $url;
    public $image;
    public $image_width;
    public $image_height;
    public $refId;
    public $section;

    private $seoService;
    private $seo;

    const WEBSITE = 'website';
    const ARTICLE = 'article';
    const PROFILE = 'profile';

    public function __construct(
        SeoService $seoService,
        $config = []
    )
    {
        $this->seoService = $seoService;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
        $this->seo = $this->seoService->getSeo($this->refId, $this->section);
        $this->loadDefault();
    }

    public function run()
    {

        $siteName = Yii::$app->params['name'];
        $domain  = Yii::$app->params['domain'];

        $this->view->registerMetaTag(['property' => 'og:site_name', 'content'  => Html::encode($siteName)]);

        if($this->app_id) {
            $this->view->registerMetaTag(['property' => 'fb:app_id', 'content'  => $this->app_id]);
        }

        if($this->type) {
            $this->view->registerMetaTag(['property' => 'og:type', 'content'  => $this->type]);
        }

        if($this->title) {
            $this->view->registerMetaTag(['property' => 'og:title', 'content'  => Html::encode($this->title)]);
        }

        if($this->description) {
            $this->view->registerMetaTag(['property' => 'og:description', 'content'  => Html::encode($this->description)]);
        }

        if($this->url) {
            $this->view->registerMetaTag(['property' => 'og:url', 'content'  => $domain.$this->url]);
        }

        if($this->image) {
            $this->view->registerMetaTag(['property' => 'og:image', 'content'  => $domain.$this->image]);
        }

        if($this->image_width) {
            $this->view->registerMetaTag(['property' => 'og:image:width', 'content'  => $this->image_width]);
        }

        if($this->image_height) {
            $this->view->registerMetaTag(['property' => 'og:image:height', 'content'  => $this->image_height]);
        }

        return '';
    }

    private function loadDefault()
    {
        $defaultImageSize = Yii::$app->setting->get('og.image_size');
        $imageSizeParts = explode('|', $defaultImageSize);

        if($this->seo && !$this->description) {
            $this->description = $this->seo->description;
        }

        if($this->seo && !$this->title) {
            $this->title = $this->seo->title;
        }

        if(!$this->type) {
            $this->type = static::WEBSITE;
        }

        if(!$this->image) {
            $this->image = Yii::$app->setting->get('og.image');
        }

        if(!$this->image_width  && isset($imageSizeParts[0])) {
            $this->image_width = $imageSizeParts[0];
        }

        if(!$this->image_height  && isset($imageSizeParts[1])) {
            $this->image_height = $imageSizeParts[1];
        }
    }
}
