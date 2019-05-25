<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190522_122909_ingredient
 */
class m190522_122909_ingredient extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('ingredient', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'visible' => Schema::TYPE_BOOLEAN . ' DEFAULT TRUE',
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('ingredient');
    }

}
