<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($role,'name');

echo $form->field($role,'description');

echo $form->field($role,'permissions')->checkboxList($permission);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);


\yii\bootstrap\ActiveForm::end();