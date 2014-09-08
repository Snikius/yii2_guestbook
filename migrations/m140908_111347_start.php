<?php

use yii\db\Schema;

class m140908_111347_start extends \yii\db\Migration
{
    public function up()
    {
        echo "m140908_111347_start setup.\n";
        
        $this->createTable('guestbook', [
            'gb_id' => Schema::TYPE_PK,
            'email' => Schema::TYPE_STRING. '(30)',
            'name' => Schema::TYPE_STRING. '(30) NOT NULL',
            'body' => Schema::TYPE_STRING. '(250) NOT NULL',
        ]);
        $this->insert("guestbook",["gb_id"=>1,"email"=>"", "name"=>"test 1", "body"=>"text 1"]);
        $this->insert("guestbook",["gb_id"=>2,"email"=>"test@mail.ru", "name"=>"test 2", "body"=>"text 2"]);
        $this->insert("guestbook",["gb_id"=>3,"email"=>"", "name"=>"test 3", "body"=>"text 3"]);
        $this->insert("guestbook",["gb_id"=>4,"email"=>"test2@mail.ru", "name"=>"test 4", "body"=>"text 4"]);
        $this->insert("guestbook",["gb_id"=>5,"email"=>"", "name"=>"test 5", "body"=>"text 5"]);
        $this->insert("guestbook",["gb_id"=>6,"email"=>"test3@mail.ru", "name"=>"test 6", "body"=>"text 6"]);
        $this->insert("guestbook",["gb_id"=>7,"email"=>"test4@mail.ru", "name"=>"test 7", "body"=>"text 7"]);
    }

    public function down()
    {
        echo "m140908_111347_start cannot be reverted.\n";
        $this->dropTable('guestbook');
        return false;
    }
}
