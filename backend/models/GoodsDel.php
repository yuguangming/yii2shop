<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/5
 * Time: 20:34
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsDel extends ActiveRecord
{
    public static function tableName()
    {
        return 'goods_category';
    }
}