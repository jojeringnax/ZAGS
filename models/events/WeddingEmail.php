<?php

namespace app\models\events;

use \app\models\Events;
use yii\db\ActiveQuery;

class WeddingEmail extends Events
{

    const CONDITION = ['name' => ['EMail', 'Wedding EMail']];

    /**
     * @param null|integer $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->where(self::CONDITION)->limit($limit);
    }

}