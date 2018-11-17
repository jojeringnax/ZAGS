<?php

namespace app\controllers;

use app\models\Config;
use app\models\Events;
use app\models\events\Encashment;
use app\models\Log;
use app\models\Owner;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
        $count = Yii::$app->db->createCommand('SELECT COUNT(owners.id) FROM licenses JOIN owners ON (licenses.id=owners.device_id) WHERE owners.user_id = :userID', [':userID' => Yii::$app->user->id])->queryScalar();
       
        $table = array();
        $set = Yii::$app->db->createCommand('SELECT owners.device_id AS device_id, licenses.license AS license, (NOW() - last_check) AS online, description, current_status.fill_wedding AS fill_wedding FROM licenses RIGHT JOIN owners ON (licenses.id=owners.device_id) RIGHT JOIN config ON (owners.device_id = config.device_id) LEFT JOIN current_status ON (config.device_id = current_status.device_id) WHERE owners.user_id = :userID', [':userID' => Yii::$app->user->id])->queryAll();

        foreach ($set as $row) {
            array_push($table, array(
				'device_id' => $row['device_id'],
				'license' => $row['license'],
				'online' => $row['online'],
				'description' => $row['description'],
				'fill_wedding' => (is_null($row['fill_wedding']))?'н/д':$row['fill_wedding'],
				'stacker' => max($this->getStackerContent($row['device_id']), $this->getStackerContent_new($row['device_id']))
			));
        }

        $provider = new ArrayDataProvider([
            'allModels' => $table,
            'sort' => [
                'attributes' => ['device_id'],
            ],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $provider
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
    public function actionView($id)
    {
        $timeFrom = new \DateTime();
        $timeFrom->setDate(date('Y'), date('m') - 1, 1);
        $timeTo = new \DateTime();
        $timeTo->modify('+1 day');
        $resultArray[$timeFrom->format('Y-m-d')] = [];
        $diff = $timeTo->diff($timeFrom)->days;
        $events = Events::getEventsForTime($id, $timeFrom->format('Y-m-d'), $timeTo->format('Y-m-d'));

        for($i=0;$i < $diff; $i++) {
            $timeFrom->modify('+1 day');
            $resultArray[$timeFrom->format('Y-m-d')] = [];
        }
        foreach($events as $event) {
            $resultArray[date('Y-m-d', strtotime($event->time))][] = $event;
        }
        ksort($resultArray, SORT_STRING);
        foreach ($resultArray as $data => $events) {
            $array = [];
            foreach($events as $event) {
                $array[$event->name][] = $event;
            }
            $resultArray[$data] = $array;
        }

        return $this->render('view', [
            'id' => $id,
           'events' => isset($resultArray) ? $resultArray : null
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
            return $this->redirect(['config', 'id' => $model->device_id]);
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
