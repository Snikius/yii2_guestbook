<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\captcha\Captcha;

$this->registerJs('guestbook.captchaInit()',yii\web\View::POS_READY);
?>
<div class="site-contact">
    <h1>Гостевая книга</h1>
    <div class="row">
        <div class="col-xs-12">
            <?php \yii\widgets\Pjax::begin([
                   'id'=>"pjaxwidget"
            ]); ?>
            <?php echo GridView::widget([
                      'dataProvider' => $guestBookProvider,
                      'summary'=>'',
                      'columns' => [
                        [
                            'attribute' => 'body',
                            'headerOptions'=>['class'=>'hidden'], 
                            'options' => ["class"=>'col-xs-12'],
                            'format' => 'html',
                            'content'=> function($model) {
                                  return "<p class=\"lead text-info\">".$model->name."</p>"
                                        ."<p>".$model->body."</p>";
                            },
                        ],  
                      ],    
                  ]);
            ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>    
    </div>    
    <div class="alert alert-success hidden jsGuestbookMessage">
        Отзыв отправлен. 
    </div>
    <div class="jsForm">
        <h1>Оставить отзыв</h1>
        <div class="row">
            <div class="col-xs-12">
                <?php $form = ActiveForm::begin([
                    'id' => 'guestbook-form' , 
                    'enableAjaxValidation'=>true,
                    'validationUrl'=>'guestbook/validator',
                    'beforeSubmit'=>'function(form) { guestbook.submit(form); return false; }',
                    "fieldConfig"=>[
                        "labelOptions"=>["class"=>"hidden"],
                    ]]); ?>
                    <?= $form->field($model, 
                                     'name', 
                                     ["inputOptions"=>["placeholder"=>$model->getAttributeLabel("name"),
                                                       "class"=>"form-control"]]) ?>
                    <?= $form->field($model, 
                                     'email',
                                     ["inputOptions"=>["placeholder"=>$model->getAttributeLabel("email"),
                                                       "class"=>"form-control"]]) ?>
                    <?= $form->field($model, 
                                     'body', 
                                     ["inputOptions"=>["placeholder"=>$model->getAttributeLabel("body"),
                                      "class"=>"form-control"]])
                             ->textArea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode', ['enableClientValidation'=>false, 'enableAjaxValidation'=>false])
                        ->widget(Captcha::className(), [
                        'captchaAction' => "/guestbook/captcha",
                        'options'=>["class"=>'input-lg form-control','placeholder'=>$model->getAttributeLabel('verifyCode')],
                        'template' => '<div class="input-group">'
                                    . '<div class="input-group-addon">{image}</div>'
                                    . '<div>{input}</div></div>',
                        ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'contact-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div> 
</div>
