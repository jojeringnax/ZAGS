<?php


namespace app\models\events;


use \app\models\Events;
use yii\db\ActiveQuery;

class Kinoselfie extends Events
{
    const CONDITION = ['name' => 'Kinoselfie'];

    /**
     * @param null $limit
     * @return ActiveQuery
     */
    public static function find($limit=null)
    {
        return parent::find()->andWhere(self::CONDITION)->limit($limit);
    }

    /**
     * @return KinoselfieEmail[]
     */
    public function getEmail()
    {
        return KinoselfieEmail::find()->andWhere(['device_id' => $this->device_id, 'nonce' => [$this->nonce+1,$this->nonce+2]])->one();
    }

    /**
     * @return array|KinoselfiePaymentView
     */
    public function getPaymentView()
    {
        return KinoselfiePaymentView::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce-2])->one();
    }

    /**
     * @return array|Payment
     */
    public function getPayment()
    {
        return Payment::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce-1])->one();
    }

    /**
     * @return array|KinoselfieReprint
     */
    public function getReprint()
    {
        return KinoselfieReprint::find()->andWhere(['device_id' => $this->device_id, 'nonce' => $this->nonce+1])->one();
    }
}