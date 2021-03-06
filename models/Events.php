<?php

namespace app\models;
use app\models\events\Kinoselfie;
use app\models\events\KinoselfiePaymentView;
use app\models\events\KinoselfieReprint;
use app\models\events\Payment;
use app\models\events\Talisman;
use app\models\events\Wedding;
use app\models\events\WeddingReprint;
use yii\db\Exception;
use app\models\events\WeddingPaymentView;
use app\models\events\TalismanPaymentView;
/**
 * This is the model class for table "events".
 *
 * @property integer $device_id
 * @property string $time [datetime]
 * @property string $name [varchar(40)]
 * @property string $data [varchar(20)]
 * @property integer $nonce
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id'], 'integer'], [['time'], 'date'], [['name', 'data', 'nonce'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'device_id' => 'ID устройства',
            'time' => 'Время',
            'name' => 'Событие',
            'data' => 'Данные',
            'nonce' => 'Nonce',
        ];
    }

    /**
     * @return string
     */
    public static function getTimeOfFirstEvent()
    {
        return self::find()->orderBy('time ASC')->one()->time;
    }


    /**
     * @param null|string $timeFrom
     * @param null|string $timeTo
     * @param $deviceId integer
     * @return null|Events[]
     * @throws Exception
     */
    public static function getEventsForTime($deviceId, $timeFrom = null, $timeTo = null)
    {
        $events = self::find()
            ->where(array_merge_recursive(Wedding::CONDITION, Payment::CONDITION, Talisman::CONDITION, Kinoselfie::CONDITION, TalismanPaymentView::CONDITION, WeddingPaymentView::CONDITION, KinoselfieReprint::CONDITION, WeddingReprint::CONDITION, KinoselfiePaymentView::CONDITION))
            ->andWhere(['device_id' => $deviceId]);
        if($timeFrom !== null || $timeTo !== null) {
           $events->andWhere(['between', 'time', $timeFrom, $timeTo]);
        }
        return $events->orderBy('time DESC')
            ->all();
    }

}
