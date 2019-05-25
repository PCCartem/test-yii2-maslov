<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingredient".
 *
 * @property int $id
 * @property string $name
 *
 * @property DishToIngredient[] $dishToIngredients
 */
class Ingredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['visible'], 'boolean']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'visible' => 'Visible',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishToIngredients()
    {
        return $this->hasMany(DishToIngredient::className(), ['ingredient_id' => 'id']);
    }

    /**
     * Ищем видимые ингредиенты
     * @return array
     */
    public static function getDataForMultiselect()
    {
        $data = [];
        foreach (self::find()->where(['visible' => 1])->all() as $key => $ingredient) {
            $data[$ingredient->id] = $ingredient->name;
        }
        return $data;
    }
}
