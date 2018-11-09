<?php
/**
 * Created by PhpStorm.
 * User: Броненосец
 * Date: 09.11.2018
 * Time: 12:31
 */

namespace app\models\events;


use yii\db\ActiveQuery;
use \app\models\Events;

class WeddingPaymentView extends Events
{
    const CONDITION = ['name' => ['Payment screen activated', 'Wedding payment screen activated']];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }
}