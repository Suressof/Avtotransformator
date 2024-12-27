<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "News".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $new
 * @property string|null $date
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'News';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['new'], 'string'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'new' => 'New',
            'date' => 'Date',
        ];
    }
}
