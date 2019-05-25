<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190522_123222_dish
 */
class m190522_123222_dish extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('dish', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('dish');
    }
}
