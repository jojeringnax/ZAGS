<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "uptimes".
 *
 * @property int $module_id
 * @property string $created_date
 * @property int $uptime
 *
 * @property Module $module
 */
class Uptime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uptimes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_id', 'uptime'], 'integer'],
            [['created_date'], 'safe'],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'module_id' => 'Module ID',
            'created_date' => 'Created Date',
            'uptime' => 'Uptime',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $uptimeSameDay = self::isExistForTodayForModule($this->module_id);
            if($uptimeSameDay === null) {
                return true;
            } else {
                $uptimeSameDay->created_date = $this->created_date;
                $uptimeSameDay->uptime = $this->uptime;
                $uptimeSameDay->save();
                return false;
            }
        }
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }

    /**
     * @param $moduleId
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getForCurrentMonthForModule($moduleId)
    {
        return self::find()->where(['module_id' => $moduleId])->andWhere(['between', 'time', date('Y-m-0'), date('Y-m-d')])->all();
    }

    /**
     * @param $moduleId
     * @return self|null|ActiveRecord
     */
    public static function isExistForTodayForModule($moduleId)
    {
        $date = new \DateTime();
        $date->modify('-1 day');
        return self::find()->where(['module_id' => $moduleId])->andWhere(['between', 'created_time', $date->format('Y-m-d'), date('Y-m-d')])->one();
    }
}
