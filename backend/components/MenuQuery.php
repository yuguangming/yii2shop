<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/5
 * Time: 11:56
 */

namespace backend\components;


use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class MenuQuery extends ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

}