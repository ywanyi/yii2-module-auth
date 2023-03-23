<?php

namespace ywanyi\auth\common\models;

use Yii;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property string $name
 * @property int $type
 * @property string|null $description
 * @property string|null $rule_name
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Assignment[] $assignments
 * @property Item[] $children
 * @property ItemChild[] $itemChildren
 * @property ItemChild[] $itemChildren0
 * @property Item[] $parents
 * @property Rule $ruleName
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%item}}';
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
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => Rule::class, 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Description'),
            'rule_name' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery|AssignmentQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::class, ['item_name' => 'name']);
    }

    /**
     * Gets query for [[Children]].
     *
     * @return \yii\db\ActiveQuery|ItemQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Item::class, ['name' => 'child'])->viaTable('{{%item_child}}', ['parent' => 'name']);
    }

    /**
     * Gets query for [[ItemChildren]].
     *
     * @return \yii\db\ActiveQuery|ItemChildQuery
     */
    public function getItemChildren()
    {
        return $this->hasMany(ItemChild::class, ['parent' => 'name']);
    }

    /**
     * Gets query for [[ItemChildren0]].
     *
     * @return \yii\db\ActiveQuery|ItemChildQuery
     */
    public function getItemChildren0()
    {
        return $this->hasMany(ItemChild::class, ['child' => 'name']);
    }

    /**
     * Gets query for [[Parents]].
     *
     * @return \yii\db\ActiveQuery|ItemQuery
     */
    public function getParents()
    {
        return $this->hasMany(Item::class, ['name' => 'parent'])->viaTable('{{%item_child}}', ['child' => 'name']);
    }

    /**
     * Gets query for [[RuleName]].
     *
     * @return \yii\db\ActiveQuery|RuleQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(Rule::class, ['name' => 'rule_name']);
    }

    /**
     * {@inheritdoc}
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }
}