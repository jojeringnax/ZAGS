<?php

namespace app\controllers;

use app\models\Config;
use app\models\CurrentStatus;
use app\models\Licenses;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('index');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

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

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionGet_config($id, $fill_wedding=null, $fill_talisman=null, $printer_media_count)
    {
        $license = Licenses::findOne($id);
        if($license === null) {
            return 'License doesn\'t exists for this device';
        } else {
            $license->last_check = date('Y-m-d H:i:s');
            $license->save();
        }
        $config = Config::findOne($id);
        if ($config === null) {
            return 'Устройсто не найдено в БД';
        }

        echo'<?xml version="1.0" encoding="utf-8" ?>';
        echo'<data>';
        echo'<wedding_price>'.isset($config->wedding_price) ? $config->wedding_price : null.'</wedding_price>';
        echo'<reprint_price>'.isset($config->reprint_price) ? $config->reprint_price : null.'</reprint_price>';
        echo'<talisman_price>'.isset($config->talisman_price) ? $config->talisman_price : null.'</talisman_price>';
        echo'<kinoselfie_price>'.isset($config->kinoselfie_price) ? $config->kinoselfie_price : null.'</kinoselfie_price>';
        echo'<disabled>'.isset($config->disabled) ? $config->disabled : null.'</disabled>';
        echo'<bills>50,100,200,500</bills>';
        echo'<multitouch_enabled>'.isset($config->multitouch_enabled) ? $config->multitouch_enabled : null.'</multitouch_enabled>';
        echo'<quiet_time_start>'.isset($config->quiet_time_start) ? $config->quiet_time_start : null.'</quiet_time_start>';
        echo'<quiet_time_end>'.isset($config->quiet_time_end) ? $config->quiet_time_end : null.'</quiet_time_end>';
        echo'</data>';

        $currentStatus = CurrentStatus::updateOrCreate($id);
        $currentStatus->device_id = $id;
        $currentStatus->last_update = date('Y-m-d H:i:s');
        $currentStatus->fill_wedding = $fill_wedding;
        $currentStatus->fill_talisman = $fill_talisman;
        $currentStatus->printer_media_count = $printer_media_count;
        $currentStatus->save();

        return true;
    }
}
