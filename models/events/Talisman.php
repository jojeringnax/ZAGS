<?php

namespace app\models\events;


use \app\models\Events;
use yii\db\ActiveQuery;

class Talisman extends Game
{
    const CONDITION = ['name' => 'Talisman'];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }
}