<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name');
echo $form->field($model,'goods_category_id')->dropDownList($cates);
echo $form->field($model,'brand_id')->dropDownList($brand);
echo $form->field($model,'isonline')->radioList(\backend\models\Goods::$isonline);
echo $form->field($model,'status')->radioList(\backend\models\Goods::$status);
echo $form->field($model,'sort');
echo $form->field($model,'logo')->widget('manks\FileInput', []);
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');

// ActiveForm
echo $form->field($model, 'imgFiles')->widget('manks\FileInput', [
    'clientOptions' => [
        'pick' => [
            'multiple' => true,
        ],
        // 'server' => Url::to('upload/u2'),
        // 'accept' => [
        // 	'extensions' => 'png',
        // ],
    ],
]);

echo  $form->field($content, 'details')->widget(\crazydb\ueditor\UEditor::className());


echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();