<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\GuestbookForm;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;

class GuestbookController extends Controller
{
    public function behaviors()
    {
        return [   
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'height'=>'32',
                'testLimit'=>100,
                'transparent'=>true,
                //'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionIndex()
    {
        $model = new GuestbookForm();
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $this->layout = null;
            if($model->save()) {
                return Json::encode($model->getAttributes());
            } else {
                throw new ForbiddenHttpException(Json::encode($model->getErrors()));
            }
        }
        $primaryKey=$model->primaryKey()[0];
        $guestBookProvider = new ActiveDataProvider([
            'query' => GuestbookForm::find(),
            'sort' => [
                'defaultOrder' => [
                    $primaryKey => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        //$this->createAction('captcha')->getVerifyCode(true);
        return $this->render('contact', [
            'model' => $model,
            'guestBookProvider'=>$guestBookProvider
        ]);
    }
    public function actionValidator()
    {
       $model = new GuestbookForm();
       if (Yii::$app->request->isAjax && $model->load($_POST)) {
           Yii::$app->response->format = Response::FORMAT_JSON;
           $validate=$model->getAttributes();
           unset($validate["verifyCode"]);
           return \yii\widgets\ActiveForm::validate($model,$validate);
       } else {
           throw new ForbiddenHttpException("Некорректный запрос");
       }
    }

}
