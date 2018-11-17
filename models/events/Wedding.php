<?php

namespace app\models\events;


use \app\models\Events;
use yii\db\ActiveQuery;

class Wedding extends Game
{
    const CONDITION = ['name' => ['Game', 'Wedding']];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }

}