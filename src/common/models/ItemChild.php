<?php

namespace ywanyi\auth\common\models;

use Yii;

/**
 * This is the model class for table "{{%item_child}}".
 *
 * @property string $parent
 * @property string $child
 *
 * @property Item $child0
 * @property Item $parent0
 */
class ItemChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%item_child}}';
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
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['child' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parent' => Yii::t('app', 'Parent'),
            'child' => Yii::t('app', 'Child'),
        ];
    }

    /**
     * Gets query for [[Child0]].
     *
     * @return \yii\db\ActiveQuery|ItemQuery
     */
    public function getChild0()
    {
        return $this->hasOne(Item::class, ['name' => 'child']);
    }

    /**
     * Gets query for [[Parent0]].
     *
     * @return \yii\db\ActiveQuery|ItemQuery
     */
    public function getParent0()
    {
        return $this->hasOne(Item::class, ['name' => 'parent']);
    }

    /**
     * {@inheritdoc}
     * @return ItemChildQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemChildQuery(get_called_class());
    }
}
