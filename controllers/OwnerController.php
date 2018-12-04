<?php

namespace app\controllers;

use app\models\Config;
use app\models\CurrentStatus;
use app\models\Events;
use app\models\events\Encashment;
use app\models\events\Game;
use app\models\events\Kinoselfie;
use app\models\events\Payment;
use app\models\events\Talisman;
use app\models\events\Wedding;
use app\models\Licenses;
use app\models\Log;
use app\models\LoginForm;
use app\models\Module;
use app\models\Owner;
use app\models\User;
use function GuzzleHttp\Psr7\str;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Expression;

class OwnerController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['config', 'view', 'log', 'update', 'encashment'],
                'rules' => [
                    [
                        'actions' => ['config', 'view', 'log', 'update', 'encashment'],
                        'allow' => false,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !$this->isOwner();
                        }
                    ],
                    // deny all POST requests
                    [
                        'allow' => true,
                        'verbs' => ['POST']
                    ],
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * @return bool
     */
    protected function isOwner()
    {
        $user_id = Yii::$app->user->id;
        $device_id = Yii::$app->request->get('id');
        $result = Owner::find()->where(['user_id' => $user_id])->andWhere(['device_id' => $device_id])->exists();
        return $result;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->getIsGuest()) {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
            return $this->render('/site/login', [
                'model' => $model,
            ]);
        }
        $owners = Owner::find()->where(['user_id' => Yii::$app->getUser()->id])->select(['device_id'])->all();
        if ($owners == null) {
            return $this->render('index', [
                'data' => [],
                'noOwner' => true
            ]);
        }
        foreach($owners as $owner) {
            $devicesArray[] = $owner->device_id;
        }
        $modules = Module::find()->where(['device_id' => $devicesArray])->all();
        $money = Payment::getStackerForDevices($devicesArray);
        $licenses = Licenses::findAll(['id' => $devicesArray]);
        foreach ($licenses as $license) {
            /** @var $modules Module[]*/
            foreach($modules as $module) {
                if ($module->device_id === $license->id) {
                    $module->setUptimesNeeded();
                    $resultArray[$license->id][$module->name . '_uptime_yesterday'] = $module->uptime_yesterday;
                    $resultArray[$license->id][$module->name . '_uptime_today'] = $module->uptime_today;
                    $resultArray[$license->id][$module->name . '_uptime_month'] = $module->uptime_month;
                    $resultArray[$license->id][$module->name . '_status'] = $module->status;
                    $founded = true;
                }
            }
            if (!isset($founded)) {
                foreach (Module::NAMES as $name) {
                    $resultArray[$license->id][$name.'_uptime_yesterday'] = 'not set';
                    $resultArray[$license->id][$name.'_uptime_today'] = 'not set';
                    $resultArray[$license->id][$name.'_uptime_month'] = 'not set';
                    $resultArray[$license->id][$name.'_status'] = 'not set';
                }
            }
            $resultArray[$license->id]['stacker'] = !isset($money['stacker'][$license->id]) ? $money['stacker'] : $money['stacker'][$license->id];
            $resultArray[$license->id]['profit'] = !isset($money['profit'][$license->id]) ? $money['profit'] : $money['profit'][$license->id];
            $currentStatus = $license->getCurrentStatus();
            $config = $license->getConfig();
            $resultArray[$license->id]['license'] = $license->license;
            $resultArray[$license->id]['online'] = (strtotime(date('Y-m-d H:i:s')) - strtotime($license->last_check)) > 180 ? 'Оффлайн' : 'Онлайн';
            $resultArray[$license->id]['description'] = $config->description;
            $resultArray[$license->id]['fill_wedding'] = $currentStatus->fill_wedding;
            $resultArray[$license->id]['printer_media_count'] = $currentStatus->printer_media_count;
        }
        return $this->render('index', [
            'data' => $resultArray
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionConfig($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Config::find()->where(['device_id' => $id]),
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        return $this->render('config', [
            'dataProvider' => $dataProvider,
            'id' => $id,
        ]);
    }

    /**
     * @param $id
     * @return int|mixed
     */
    public function getStackerContent_new($id)
    {
        $set = Events::find()->where(['device_id' => $id])->andWhere(['name'=>'Money'])->andWhere(new Expression('time > (select IfNull(max(time), \'01-01-01 00:00:00\') from events where name = \'Encashment\' AND device_id = ' . $id . ')'))->all();

        $result = 0;
        foreach ($set as $row)
            $result = $result + $row->data;
        return $result;
    }

    /**
     * @param $id
     * @return int|string
     */
    public function getStackerContent($id)
    {
        $set = Log::find()->where([ 'device_id' => $id ])->andWhere(['like', 'message', 'Recieved % rubles', false])->andWhere(new Expression('time > (select IfNull(max(time), \'01-01-01 00:00:00\') from logs where message = \'Stacker inserted\' AND device_id = '.$id.')'))->all();

        $result = 0;
        foreach ($set as $row)
        {
            preg_match_all('!\d+!', $row->message, $counts);
            $result = $result + implode($counts[0]);
        }
        return $result;
    }


    /**
     * @param $id
     * @return string
     */
    public function actionView($id, $timeFrom=null, $timeTo=null)
    {
        if($timeFrom === null && $timeTo === null) {
            $timeFrom = \DateTime::createFromFormat('Y-m-d H:i:s', Events::getTimeOfFirstEvent());
            $timeTo = new \DateTime();
        } else if ($timeFrom === null) {
            $timeFrom = \DateTime::createFromFormat('Y-m-d H:i:s', Events::getTimeOfFirstEvent());
        } else if ($timeTo === null) {
            $timeTo = new \DateTime();
        } else {
            $timeFrom = \DateTime::createFromFormat('Y-m-d', $timeFrom);
            $timeTo = \DateTime::createFromFormat('Y-m-d', $timeTo);
            $timeTo->modify('+1 day');
        }
        $events = Events::getEventsForTime($id, $timeFrom->format('Y-m-d'), $timeTo->format('Y-m-d'));
        $timeTo->modify('-1 day');
        $resultArray[$timeTo->format('Y-m-d')] = [];
        $diff = $timeTo->diff($timeFrom)->days;
        for($i=0;$i < $diff; $i++) {
            $timeTo->modify('-1 day');
            $resultArray[$timeTo->format('Y-m-d')] = [];
        }
        foreach($events as $event) {
            $resultArray[date('Y-m-d', strtotime($event->time))][] = $event;
        }
        $oldMonthNumber = date('m_Y');
        $totalesMonthMoney = [];
        $totalesMonthMoney[$oldMonthNumber] = array(
            'Money' => 0,
            'Cashless' => 0,
            'Games' => 0,
            'Weddings' => 0,
            'Kinoselfies' => 0,
            'Talismans' => 0
        );

        foreach ($resultArray as $data => $events) {
            $currentMonthNumber = date('m_Y', strtotime($data));
            if ($currentMonthNumber !== $oldMonthNumber) {
                $totalesMonthMoney[$currentMonthNumber] = array(
                    'Money' => 0,
                    'Cashless' => 0,
                    'Games' => 0,
                    'Weddings' => 0,
                    'Kinoselfies' => 0,
                    'Talismans' => 0
                );
            }
            $array = [];
            foreach($events as $event) {
                if(in_array($event->name, Game::getCondition()['name'])) {
                    if (in_array($event->name, Wedding::CONDITION['name']))
                        $totalesMonthMoney[$currentMonthNumber]['Weddings'] += 1;
                    if ($event->name === Kinoselfie::CONDITION['name'])
                        $totalesMonthMoney[$currentMonthNumber]['Kinoselfies'] += 1;
                    if ($event->name === Talisman::CONDITION['name'])
                        $totalesMonthMoney[$currentMonthNumber]['Talismans'] += 1;
                    $totalesMonthMoney[$currentMonthNumber]['Games'] += 1;
                }
                $array[$event->name][] = $event;
            }
            if (isset($array['Money'])) {
                foreach ($array['Money'] as $event) {
                    $totalesMonthMoney[$currentMonthNumber]['Money'] += $event->data;
                }
            }
            if (isset($array['Cashless'])) {
                foreach ($array['Cashless'] as $event) {
                    $totalesMonthMoney[$currentMonthNumber]['Cashless'] += $event->data;
                }
            }
            $resultArray[$data] = $array;
            $oldMonthNumber = $currentMonthNumber;
        }


        return $this->render('view', [
            'id' => $id,
            'events' => isset($resultArray) ? $resultArray : null,
            'totales' => isset($totalesMonthMoney) ? $totalesMonthMoney : null,
            'monthName' => array(
                1 => 'Январь',
                2 => 'Февраль',
                3 => 'Март',
                4 => 'Апрель',
                5 => 'Май',
                6 => 'Июнь',
                7 => 'Июль',
                8 => 'Август',
                9 => 'Сентябрь',
                10 => 'Октябрь',
                11 => 'Ноябрь',
                12 => 'Декабрь',
            )
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function actionLog($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());
        $model->save();

        switch (Config::find()->where(['device_id' => $id])->one()->log_level) {
            case "Debug":
                $in_statement = 'AND level IN (\'Debug\', \'Info\', \'Warning\', \'Error\', \'Fatal\')';
                break;
            case "Info":
                $in_statement = 'AND level IN (\'Info\', \'Warning\', \'Error\', \'Fatal\')';
                break;
            case "Warning":
                $in_statement = 'AND level IN (\'Warning\', \'Error\', \'Fatal\')';
                break;
            case "Error":
                $in_statement = 'AND level IN (\'Error\', \'Fatal\')';
                break;
            case "Fatal":
                $in_statement = 'AND level IN (\'Fatal\')';
                break;
            default:
                $in_statement = '';
                break;
        }

        $totalCount = Yii::$app->db->createCommand('SELECT count(*) FROM logs WHERE device_id = ' . $id . ' ' . $in_statement, [])->queryScalar();

        if ($totalCount > 10000)
            $totalCount = 10000;

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT time, level, sender, message FROM logs WHERE device_id = ' . $id . ' ' . $in_statement.' ORDER BY time DESC',
            'sort' => [
                'attributes' => [
                    'time',
                ],
            ],
            'totalCount' => (int)$totalCount,
            'pagination' => [
                // количество пунктов на странице
                'pageSize' => 100,
            ]
        ]);

        return $this->render('log', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionEncashment($id)
    {
        $encashments = Encashment::getEncashmentsWithTotalForDevice($id);

        return $this->render('encashment' ,[
            'encashments' => $encashments,
            'id' => $id
        ]);
    }

    /**
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Config::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
