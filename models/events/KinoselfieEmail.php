<?php


namespace app\models\events;


use \app\models\Events;
use yii\db\ActiveQuery;

class KinoselfieEmail extends Events
{
    const CONDITION = ['name' => 'Kinoselfie EMail'];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }
}