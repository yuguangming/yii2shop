<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/8
 * Time: 18:29
 */

namespace backend\models;


use yii\base\Model;

class GoodsSearchForm extends Model
{
    public $keyword;
    public $minPrice;
    public $maxPrice;

    public function rules()
    {
        return [
          [['minPrice','maxPrice'],'number'],
          [['keyword'],'safe'],
        ];
    }
}