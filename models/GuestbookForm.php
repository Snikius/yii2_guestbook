<?php

namespace app\models;

use Yii;

class GuestbookForm extends Guestbook
{
    var $verifyCode;
    
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['verifyCode', 'captcha','captchaAction'=>'guestbook/captcha'],
            ['verifyCode', 'required'],
        ]);
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'verifyCode'=>"Код",
        ]);
    }

} 
