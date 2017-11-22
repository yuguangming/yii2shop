<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎来到京西！
                    <?php if (Yii::$app->user->isGuest){
                        echo "[".\yii\helpers\Html::a("请登录",['member/login'])."]";

                        echo "[".\yii\helpers\Html::a("免费注册",['member/regist'])."]";
                    }else{
                        echo "[欢迎".Yii::$app->user->identity->username."登录]";

                        echo "[".\yii\helpers\Html::a("退出登录",['member/logout'])."]";
                    }

                    ?>

                </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->