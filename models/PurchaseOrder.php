<?php

namespace app\models;
use app\models\User;

use Yii;

/**
 * This is the model class for table "Purchase_Order".
 *
 * @property int $id
 * @property int|null $id_order
 * @property int|null $id_product
 * @property string $date
 * @property string|null $status
 *
 * @property Order $order
 * @property Product $product
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Purchase_Order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_order', 'id_product'], 'integer'],
            [['date'], 'safe'],
            [['status'], 'string', 'max' => 255],
            [['id_order'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['id_order' => 'id']],
            [['id_product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['id_product' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_order' => 'Id Order',
            'id_product' => 'Id Product',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'id_order']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'id_product']);
    }

    public function getProducts()
    {
        $Product = Product::find()->where(['id'=>$this->id_product])->one();  

        return $Product->title;
    }

    public function getUser()
    {
        $Order = Order::find()->where(['id'=>$this->id_order])->one();  
        $User = User::find()->where(['id'=>$Order->id_client])->one();  

        return $User;
    }
}
