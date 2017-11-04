<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($articleCategory,'name')->textInput();
echo $form->field($articleCategory,'intro')->textInput();
echo $form->field($articleCategory,'sort')->textInput();
echo $form->field($articleCategory,'is_help')->radioList(\backend\models\ArticleCategory::$help);

echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();