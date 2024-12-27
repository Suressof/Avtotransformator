<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Order".
 *
 * @property int $id
 * @property int|null $id_client
 * @property int|null $id_payment
 *
 * @property User $client
 * @property Payment $payment
 * @property PurchaseOrder[] $purchaseOrders
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_client', 'id_payment'], 'integer'],
            [['id_payment'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::class, 'targetAttribute' => ['id_payment' => 'id']],
            [['id_client'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_client' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_client' => 'Id Client',
            'id_payment' => 'Id Payment',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'id_client']);
    }

    /**
     * Gets query for [[Payment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'id_payment']);
    }

    /**
     * Gets query for [[PurchaseOrders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, ['id_order' => 'id']);
    }
}
