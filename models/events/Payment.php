<?php


namespace app\models\events;


use \app\models\Events;
use yii\db\ActiveQuery;

class Payment extends Events
{
    const CONDITION = ['name' => ['Money', 'Cashless']];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->name == 'Money' ? 'Наличный расчет' : 'Безналичный расчет';
    }

}