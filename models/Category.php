<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Category".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $photo_asset
 *
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 50],
            [['photo_asset'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'photo_asset' => 'Photo Asset',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id_category' => 'id']);
    }

    public function getImageHtml()
    {
        return '<img src="../assets/' . $this->photo_asset . '" alt="User Image" width="100" height="100">';
    }
}
