<?php

namespace app\controllers;

use app\models\events\Game;
use app\models\events\Kinoselfie;
use yii\data\ActiveDataProvider;
use app\models\Config;
use app\models\events\Talisman;
use app\models\events\Wedding;
use app\models\Log;
use app\models\Licenses;
use app\models\Owner;
use app\models\Requests;
use app\models\User;
use yii\data\SqlDataProvider;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class AdminController extends \yii\web\Controller
{
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
                'rules' => [
                    // deny all POST requests
                    [
                        'allow' => true,
                        'verbs' => ['POST']
                    ],
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->getId() == 1;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionGames()
    {
        $games = new ActiveDataProvider([
            'query' => Game::find()->where(array_merge_recursive(Wedding::CONDITION, Kinoselfie::CONDITION, Talisman::CONDITION)),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        $columns = [
            'device_id',
            'name',
            'time',
            'nonce',
            ['label' => 'Email', 'value' => 'EmailData'],
            ['label' => 'Payment type', 'format' => 'raw', 'value' => function($model) {
                $result = '<div class="payment_wrapper">';
                foreach($model->getPaymentData() as $payment) {
                    $result.='
                        <div class="payment_element">
                            <div class="payment_type">'.$payment['label'].'</div>
                            <div class="payment_value">'.$payment['number'].'</div>
                        </div>';
                }
                $result.='</div>';
                return $result;
            }]
        ];
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->get('id');
            $date_first = Yii::$app->request->get('date_first');
            $date_first_array = preg_split('/\./', $date_first);
            $date_first = $date_first_array[2].'-'.$date_first_array[1].'-'.$date_first_array[0];
            $date_second = Yii::$app->request->get('date_second');
            $date_second_array = preg_split('/\./', $date_second);
            $date_second = $date_second_array[2].'-'.$date_second_array[1].'-'.$date_second_array[0];
            if($id) {
                $games->query = $games->query->andWhere(['device_id' => $id]);
            };
            if (!empty([$date_first, $date_second])) {
                if ($date_second === $date_first) {
                    $games->query = $games->query->andWhere(['between', 'time', $date_first . ' 00:00:00', $date_second . ' 23:59:59']);
                } else {
                    $games->query = $games->query->andWhere(['between', 'time', $date_first, $date_second]);
                }
            } else if ($date_first) {
                $games->query = $games->query->andWhere(['>', 'time', $date_first]);
            } else {
                $games->query = $games->query->andWhere(['<', 'time', $date_second]);
            }
            return $this->render('games', [
                'dataProvider' => $games,
                'columns' => $columns,
            ]);
        }

        return $this->render('games', [
            'games' => $games,
            'columns' => $columns,
            ]);
    }

    public function actionIndex()
    {
        $count = Yii::$app->db->createCommand('SELECT COUNT(licenses.id) FROM licenses')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT *, NOW() - last_check AS online FROM licenses',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /*public function actionConfig($id)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM config WHERE config.device_id = :deviceID',
            'params' => [':deviceID' => $id],
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        return $this->render('config', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /public function actionUser($id)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM photobooth_counters WHERE photobooth_counters.device_id = :deviceID',
            'params' => [':deviceID' => $id],
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        return $this->render('user', [
            'dataProvider' => $dataProvider,
        ]);
    }*/

    public function actionRequests()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM license_requests',
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        return $this->render('requests', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionSelect_user($id)
    {
        $count = Yii::$app->db->createCommand('SELECT COUNT(id) FROM users')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM users WHERE id NOT IN (SELECT user_id FROM owners WHERE device_id = :deviceID)',
            'params' => [':deviceID' => $id],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        $dataProvider2 = new SqlDataProvider([
            'sql' => 'SELECT * FROM users WHERE id IN(SELECT user_id FROM owners WHERE device_id = :deviceID)',
            'totalCount' => 1,
            'params' => [':deviceID' => $id],
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        return $this->render('user', [
            'dataProvider' => $dataProvider,
            'deviceID' => $id,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionAssign_user($userID, $deviceID)
    {
        $ownerModel = new Owner();
        if (!Owner::find()->where(['user_id' => $userID])->andWhere(['device_id' => $deviceID])->exists()) {
            $ownerModel->user_id = $userID;
            $ownerModel->device_id = $deviceID;
            $ownerModel->insert();
        }
        return $this->redirect(['select_user', 'id' => $deviceID]);
    }


    public function actionDelete_license($id)
    {
        $model = Licenses::findOne($id);
        $model->delete();

        Owner::deleteAll(['device_id' => $id]);
        Config::deleteAll(['device_id' => $id]);
        Log::deleteAll(['device_id' => $id]);

        return $this->redirect(['index']);
    }

    public function actionDelete_user($id)
    {
        $model = User::findOne($id);
        $model->delete();
        Owner::deleteAll(['user_id' => $id]);

        return $this->redirect(['users_list']);
    }

    public function actionDelete_owner($userID, $deviceID)
    {
        $model = Owner::find()->where(['user_id' => $userID])->andWhere(['device_id' => $deviceID])->one();
        $model->delete();

        return $this->redirect(['select_user', 'id' => $deviceID]);
    }

    public function actionDelete_request($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['requests']);
    }

    public function actionActivate_request($id)
    {
        $licenseModel = new Licenses();
        $licenseModel->license = Requests::findOne($id)->license;
        $licenseModel->insert();

        $configModel = new Config();
        $configModel->device_id = $licenseModel->id;
        $configModel->wedding_price = 200;
        $configModel->reprint_price = 50;
        $configModel->bills = "10,50,100,500";
        $configModel->disabled = 0;
        $configModel->multitouch_enabled = 1;
        $configModel->description = '';
        $configModel->log_level = 'Info';
        $configModel->quiet_time_start = 0;
        $configModel->quiet_time_end = 0;
        $configModel->insert();

        $this->findModel($id)->delete();

        return $this->redirect(['requests']);
    }

    public function actionUsers_list()
    {
        $count = Yii::$app->db->createCommand('SELECT COUNT(id) FROM users')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM users',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'id',
                ],
            ],
        ]);

        return $this->render('users_list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd_user()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['users_list']);
        } else {
            return $this->render('add_user', [
                'model' => $model,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Requests::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findGeneralModel($id)
    {
        if (($model = Licenses::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findRequestsModel($id)
    {
        if (($model = Requests::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
