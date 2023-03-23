<?php

namespace ywanyi\auth\common\models;

use Yii;

/**
 * This is the model class for table "{{%assignment}}".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int|null $created_at
 *
 * @property Item $itemName
 */
class Assignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assignment}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('auth');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => Yii::t('app', 'Item Name'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[ItemName]].
     *
     * @return \yii\db\ActiveQuery|ItemQuery
     */
    public function getItemName()
    {
        return $this->hasOne(Item::class, ['name' => 'item_name']);
    }

    /**
     * {@inheritdoc}
     * @return AssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssignmentQuery(get_called_class());
    }
}
