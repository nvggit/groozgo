<?php

use yii\db\Migration;

class m170927_172515_new_migration extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'surname' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'birthdate' => $this->date()->notNull(),
            'male' => $this->string()->notNull(),
        ]);
		
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'address' => $this->string()->notNull(),
            'comment' => $this->string()->notNull(),
            'user' => $this->integer(),
        ]);
        
		$this->createIndex('fk_user', '{{%address}}', 'user');
        $this->addForeignKey(
            'fk_user', '{{%address}}', 'user', '{{%users}}', 'id', 'SET NULL', 'CASCADE'
        );		
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
        $this->dropTable('{{%address}}');
    }
}
