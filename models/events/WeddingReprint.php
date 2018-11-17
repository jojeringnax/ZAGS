<?php


namespace app\models\events;


use \app\models\Events;
use yii\db\ActiveQuery;

class WeddingReprint extends Events
{
    const CONDITION = ['name' => ['Reprinting', 'Wedding reprint']];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }
}