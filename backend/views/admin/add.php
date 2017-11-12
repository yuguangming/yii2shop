<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,"username");
echo $form->field($model,"password")->passwordInput();
echo $form->field($model,"email");
echo $form->field($model,'role')->checkboxList($role);
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();