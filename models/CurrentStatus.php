<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "current_status".
 *
 * @property int $device_id
 * @property string $last_update
 * @property int $fill_wedding
 * @property int $fill_talisman
 * @property int $printer_media_count
 */
class CurrentStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'current_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_update'], 'safe'],
            [['fill_wedding', 'fill_talisman', 'printer_media_count'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'device_id' => 'Device ID',
            'last_update' => 'Last Update',
            'fill_wedding' => 'Fill Wedding',
            'fill_talisman' => 'Fill Talisman',
            'printer_media_count' => 'Printer Media Count',
        ];
    }

    /**
     * @param $id
     * @return CurrentStatus|null|static
     */
    public static function updateOrCreate($id)
    {
        $one = self::findOne($id);
        return $one === null ? new self() : $one;
    }
}
