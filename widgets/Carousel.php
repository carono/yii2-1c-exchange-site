<?php

namespace app\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;

class Carousel extends Widget
{
    public $options = [];
    /**
     * @var ActiveDataProvider
     */
    public $dataProvider;

    public function run()
    {
        return $this->render('carousel/main', ['images' => $this->dataProvider->getModels()]);
    }
}