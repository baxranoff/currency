<?php

use yii\db\Migration;

/**
 * Class m210120_100250_currency
 */
class m210120_100250_currency extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('currency',[
           'id' => $this->primaryKey(),
           'name' => $this->string(2550)->notNull(),
           'rate' => $this->string(50),
           'insert_dt' => $this->string(10)


        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('currency');
    }

}
