<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Currency;

class SiteController extends Controller
{
    protected $create_date;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCs()
    {

        $insert_dt = '';
        $feed = 'http://www.cbr.ru/scripts/XML_daily.asp';
        $xml = simplexml_load_file($feed);
        $dataes = [];
        $date = (array) $xml;
        foreach ($date as $d){
            if(!empty($d['Date']))
                $insert_dt = $d['Date'];
        }

        $res = Currency::find()->where(['insert_dt' => $insert_dt])->all();
        if($res != null){
            return SiteController::actionUpdate($insert_dt,$xml);
//                $this->redirect(['update', 'insert_dt' => $insert_dt, 'xml' => $xml]);
        }else{
            foreach ($xml as $item){
                $array = (array) $item;
                $model = new Currency();
                $model->name = $array['Name'];
                $model->rate = $array['Value'];
                $model->insert_dt = $insert_dt;
                $model->save();
            }
            return 'Insert successful';
        }

    }

    public function actionUpdate($insert_dt, $xml)
    {
        if(Currency::deleteAll(['insert_dt' => $insert_dt])){

            foreach ($xml as $item){
                $array = (array) $item;
                $model = new Currency();
                $model->name = $array['Name'];
                $model->rate = $array['Value'];
                $model->insert_dt = $insert_dt;
                $model->save();
            }
            return 'Update successful';
        }

    }
}
