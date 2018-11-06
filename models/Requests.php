<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "license_requests".
 *
 * @property integer $id
 * @property string $license
 */
class Requests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'license_requests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['license'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'license' => 'License',
        ];
    }
}
