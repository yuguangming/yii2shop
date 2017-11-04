<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($article,'name')->textInput();
echo $form->field($article,'article_category_id')->dropDownList($cate);
echo $form->field($article,'intro')->textInput();
echo $form->field($article,'status')->radioList(\backend\models\Article::$status);
echo $form->field($article,'sort')->textInput();
echo $form->field($articleTetail,'content')->textarea();

echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();