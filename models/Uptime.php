<?php

namespace app\models;

use Faker\Provider\DateTime;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "uptimes".
 *
 * @property int $module_id
 * @property string $created_date
 * @property int $uptime
 * @property strinf $version
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
            [['module_id'], 'integer'],
            [['created_date'], 'safe'],
            [['version'], 'string'],
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
        if($insert) {
            $uptimeSameDay = self::isExistForDateForModule($this->module_id, date('Y-m-d', strtotime($this->created_date)));
            if ($uptimeSameDay !== null) {
				$uptimeSameDay->created_date = $this->created_date;
                $uptimeSameDay->uptime = $this->uptime;
                $uptimeSameDay->save();
                return false;
            }
            return true;
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
        $dayMore = date('d') + 1;
        return self::find()->where(['module_id' => $moduleId])->andWhere(['between', 'created_date', date('Y-m-0'), date('Y-m-'.$dayMore)])->all();
    }

    /**
     * @param $moduleId
     * @return self|null|ActiveRecord
     */
    public static function isExistForDateForModule($moduleId, $date)
    {
        $dateFrom = \DateTime::createFromFormat('Y-m-d', $date);
        $dateTo = \DateTime::createFromFormat('Y-m-d', $date);
        $dateTo->modify('+1 day');
        return self::find()->where(['module_id' => $moduleId])->andWhere(['between', 'created_date', $dateFrom->format('Y-m-d'), $dateTo->format('Y-m-d')])->one();
    }
}
