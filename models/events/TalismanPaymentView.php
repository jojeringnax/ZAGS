<?php


namespace app\models\events;


use \app\models\Events;
use yii\db\ActiveQuery;

class TalismanPaymentView extends Events
{
    const CONDITION = ['name' => 'Talisman payment screen activated'];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }
}