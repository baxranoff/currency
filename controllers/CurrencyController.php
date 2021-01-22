<?php


namespace app\controllers;

use yii\rest\ActiveController;

class CurrencyController extends ActiveController
{
    public $modelClass = 'app\models\Currency';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}
