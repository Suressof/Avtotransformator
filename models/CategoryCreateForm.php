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
class CategoryCreateForm extends Category
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required', 'message'=> 'Не заполнено обязательное поле'],
            ['photo_asset','file','extensions' => 'png, jpg, jpeg, bmp','maxSize'=>10*1024*1024,
            'message'=>'Неверный формат файла'],
            [['title'], 'string', 'max' => 50],
            [['photo_asset'], 'string', 'max' => 250],
        ];
    }

}
