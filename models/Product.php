<?php

namespace app\models;
use app\models\Vendor;

use Yii;

/**
 * This is the model class for table "Product".
 *
 * @property int $id
 * @property string|null $title
 * @property float|null $weight
 * @property float|null $price
 * @property int|null $id_vendor
 * @property int|null $id_category
 * @property string|null $photo
 *
 * @property Category $category
 * @property PurchaseOrder[] $purchaseOrders
 * @property Vendor $vendor
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['weight', 'price'], 'number'],
            [['id_vendor', 'id_category'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['photo'], 'string', 'max' => 255],
            ['photo','file','extensions' => 'png, jpg, jpeg, bmp','maxSize'=>10*1024*1024,
            'message'=>'Неверный формат файла'],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['id_category' => 'id']],
            [['id_vendor'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::class, 'targetAttribute' => ['id_vendor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'weight' => 'Вес (кг)',
            'price' => 'Цена (руб)',
            'id_vendor' => 'Поставщик',
            'id_category' => 'Категория',
            'photo' => 'Photo',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'id_category']);
    }

    public function getCategories()
    {
        $Categories = Category::find()->where(['id'=>$this->id_category])->one();  

        return $Categories->title;
    }

    public function getVendors()
    {
        $Vendors = Vendor::find()->where(['id'=>$this->id_vendor])->one();  

        return $Vendors->title;
    }

    public function getImageHtml()
    {
        return '<img src="../assets/' . $this->photo . '" alt="User Image" width="100" height="100">';
    }

    /**
     * Gets query for [[PurchaseOrders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, ['id_product' => 'id']);
    }

    /**
     * Gets query for [[Vendor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::class, ['id' => 'id_vendor']);
    }
}
