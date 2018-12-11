<?php

namespace app\controllers;

use app\models\Config;
use app\models\CurrentStatus;
use app\models\Licenses;
use app\models\Module;
use Codeception\Util\XmlBuilder;
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


    /**
     * @param $id
     * @param null $fill_wedding
     * @param null $fill_talisman
     * @param $printer_media_count
     * @return XmlBuilder|string
     */
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
        $xml = new XmlBuilder();
        $xml->data
            ->wedding_price
            ->val(isset($config->wedding_price) ? $config->wedding_price : null)
            ->parents('data')
            ->reprint_price
            ->val(isset($config->reprint_price) ? $config->reprint_price : null)
            ->parents('data')
            ->talisman_price
            ->val(isset($config->talisman_price) ? $config->talisman_price : null)
            ->parents('data')
            ->kinoselfie_price
            ->val(isset($config->kinoselfie_price) ? $config->kinoselfie_price : null)
            ->parents('data')
            ->disabled
            ->val(isset($config->disabled) ? $config->disabled : null)
            ->parents('data')
            ->bills
            ->val('50,100,200,500')
            ->parents('data')
            ->multitouch_enabled
            ->val(isset($config->multitouch_enabled) ? $config->multitouch_enabled : null)
            ->parents('data')
            ->quiet_time_start
            ->val(isset($config->quiet_time_start) ? $config->quiet_time_start : null)
            ->parents('data')
            ->quiet_time_end
            ->val(isset($config->quiet_time_end) ? $config->quiet_time_end : null)
            ->parents('data');
        $currentStatus = CurrentStatus::updateOrCreate($id);
        $currentStatus->device_id = $id;
        $currentStatus->last_update = date('Y-m-d H:i:s');
        $currentStatus->fill_wedding = $fill_wedding;
        $currentStatus->fill_talisman = $fill_talisman;
        $currentStatus->printer_media_count = $printer_media_count;
        $currentStatus->save();

        return $xml;
    }

    /**
     * @return bool
     */
    public function actionStatus()
    {
        $json = \GuzzleHttp\json_decode(Yii::$app->request->rawBody, true);
        foreach ($json as $array) {
            $version = $array['Version'];
            $date = $array['Date'];
            $deviceId = $array['DeviceId'];
            $version = $array['Version'];
            $weddingDispenserIndex = $array['Wedding']['Dispenser'];
            $talismanDispenserIndex = $array['Talisman']['Dispenser'];
            foreach (Module::NAMES as $name) {
                if (isset($array[ucfirst($name)])) {
                    if ($name === 'dispenser') {
                        foreach ($array['Dispensers'] as $dispenser) {
                            if ($dispenser['Index'] === $weddingDispenserIndex) {
                                $fillWedding = $dispenser['Fill'];
                            } else if ($dispenser['Index'] === $talismanDispenserIndex) {
                                $fillTalisman = $dispenser['Fill'];
                            } else {
                                continue;
                            }
                        }
                        if (!isset($fillTalisman) || $fillTalisman == -1) {
                            $fillTalisman = null;
                        }
                        if (!isset($fillWedding) || $fillWedding == -1) {
                            $fillWedding = null;
                        }
                        $currentStatus = CurrentStatus::updateOrCreate($deviceId);
                        $currentStatus->fill_wedding = $fillWedding;
                        $currentStatus->fill_talisman = $fillTalisman;
                    } else {
                        Module::findOrCreateAndUpdate((integer) $deviceId, $name, $array[ucfirst($name)]['Operational'] / 1000, $date,true, $version, (integer) $array[ucfirst($name)]['Status'], (integer) $array[ucfirst($name)]['ErrorCode']);
                    }
                }
            }
        }
        return 'Ok';
    }


    /**
     * @return bool
     */
    public function actionDaily()
    {
        $json = \GuzzleHttp\json_decode(Yii::$app->request->rawBody, true);
        foreach ($json as $array) {
            $deviceId = $array['DeviceId'];
            $date = $array['Date'];
            foreach (Module::NAMES as $name) {
                if (isset($array[ucfirst($name).'Operational'])) {
                    if ($name === 'dispenser') {
                        continue;
                    }
                    Module::findOrCreateAndUpdate($deviceId, $name, $array[ucfirst($name).'Operational'] / 1000, $date);
                }
            }
        }
        return 'Ok';
    }
}
