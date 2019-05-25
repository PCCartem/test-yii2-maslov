<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190522_123422_dish_to_ingredient
 */
class m190522_123422_dish_to_ingredient extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('dish_to_ingredient', [
            'id' => Schema::TYPE_PK,
            'dish_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'ingredient_id' => Schema::TYPE_INTEGER . ' NOT NULL'
        ]);

        $this->addForeignKey("ingredient_fk", "{{%dish_to_ingredient}}", "ingredient_id", "{{%ingredient}}", "id", 'RESTRICT');
        $this->addForeignKey("dish_fk", "{{%dish_to_ingredient}}", "dish_id", "{{%dish}}", "id", 'RESTRICT');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('dish_to_ingredient');
    }
}
