<?php

namespace app\models;


/**
 * This is the model class for table "dish".
 *
 * @property int $id
 * @property string $name
 *
 * @property DishToIngredient[] $dishToIngredients
 */
class Dish extends \yii\db\ActiveRecord
{
    const MIN_COUNT_INGREDIENTS = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dish';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishToIngredients()
    {
        return $this->hasMany(DishToIngredient::className(), ['dish_id' => 'id']);
    }

    /**
     * Функция привязывает ингредиенты к текущему блюду
     * @param $ingredients
     * @return bool
     */
    public function associate($ingredients)
    {
        if(count($ingredients) >= self::MIN_COUNT_INGREDIENTS) {
            foreach ($ingredients as $ingredient) {

                $model = new DishToIngredient();
                $model->dish_id = $this->id;
                $model->ingredient_id = (int)$ingredient;
                $model->save();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Функция ищет совпадение всех ингредиентов, а затем, если не находит, пробует найти частичное совпадение
     * @param array $ingredients
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    public static function search($ingredients)
    {
        if(!empty($ingredients)) {
            $ingredientsCount = count($ingredients);
            if($ingredientsCount >= self::MIN_COUNT_INGREDIENTS) {
                $sub = DishToIngredient::find()
                    ->select('COUNT(*)')
                    ->where("`dish_to_ingredient`.`dish_id`=`dish`.`id`")
                    ->andWhere(['ingredient_id' => $ingredients])
                    ->groupBy('dish_id');

                $baseQuery = self::find()
                    ->select(['dish.id', 'dish.name', 'count' => $sub])
                    ->joinWith('dishToIngredients')
                    ->innerJoin('ingredient', 'ingredient.id = dish_to_ingredient.ingredient_id')
                    ->andWhere(['dish_to_ingredient.ingredient_id' => $ingredients])
                    ->andHaving(['AVG(`ingredient`.`visible`)' => 1])
                    ->orderBy(['count' => SORT_DESC])
                    ->groupBy('id')
                    ->asArray();

                $fullOverlap = $baseQuery->andHaving(['count' => $ingredientsCount])->andHaving(['AVG(`ingredient`.`visible`)' => 1])->all();

                if(!empty($full)) {
                    return $fullOverlap;
                } else {
                    $partialOverlap = $baseQuery->andHaving(['<', 'count', $ingredientsCount])
                        ->andHaving(['>=', 'count', self::MIN_COUNT_INGREDIENTS])
                        ->all();
                    return $partialOverlap;
                }
            }
        } else {
            return false;
        }

    }


}
