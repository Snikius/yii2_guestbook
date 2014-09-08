<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guestbook".
 *
 * @property integer $gb_id
 * @property string $name
 * @property string $email
 * @property string $body
 *
 */
class Guestbook extends \yii\db\ActiveRecord
{

    public function fields()
    {
        return [  
            'gb_id',
            'name',
            'email',
            'body',
        ];
    }
    public static function tableName()
    {
        return 'guestbook';
    }
    
    public function rules()
    {
        return [
            [['name','body'], 'required'],  
            [['email'], 'email'],
            [["name","body"], 'match', 'not'=> true, 
                                       'pattern'=>"/<.*?>/i",
                                       "message"=>"Недопустимые символы"],
            [['email',"name"], 'string', 'max' => 30],
            [['body'], 'string', 'max' => 250],
            [['gb_id'], 'number']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'E-mail',
            'body' => 'Текст',
        ];
    }

} 
