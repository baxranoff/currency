<?php


namespace app\commands;


use app\controllers\SiteController;
use yii\console\Controller;

class CurrencyController extends Controller
{
    public $message;

    public function options($actionID)
    {
        return ['message'];
    }

    public function optionAliases()
    {
        return ['m' => 'message'];
    }

    public function actionIndex()
    {
        if($this->message == 'update'){
            $this->message = SiteController::actionCs();
            echo $this->message . "\n";
        }else{
            echo $this->message . "\n";
        }

    }

}