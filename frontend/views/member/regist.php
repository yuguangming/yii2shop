<?php
/* @var $this yii\web\View */
?>
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form=\yii\widgets\ActiveForm::begin(
                    [
                            'fieldConfig' => [
                                    'options'=>['tag'=>'li'],
                                    'errorOptions'=>['tag'=>'p'],
                            ]
                    ]
            );
            echo "<ul>";
            echo $form->field($model,"username")->textInput(['class'=>'txt'])->label("用户名：");
            echo $form->field($model,"password")->passwordInput(['class'=>'txt'])->label("密码：");
            echo $form->field($model,"email")->textInput(['class'=>'txt'])->label("邮箱");
            echo $form->field($model,"tel")->textInput(['class'=>'txt','id'=>'tel'])->label("手机号码")."<p id='tel_err'></p>";



            $html=<<<EOF

  <li>
                        <label for="">验证码：</label>
                        <input type="text" class="txt" value="" placeholder="请输入短信验证码" name="captcha" disabled="disabled" id="captcha"/> <input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>
                        <p id="cap_err"></p>
                    </li>
                   <!--<li class="checkcode">
                        <label for="">验证码：</label>
                        <input type="text"  name="checkcode" />
                        <img src="images/checkcode1.jpg" alt="" />
                        <span>看不清？<a href="">换一张</a></span>
                    </li>-->
EOF;

               



 echo $html;

//                   <!-- <li>
//                        <label for="">&nbsp;</label>
//                        <input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》
//                    </li>
//                    <li>
//                        <label for="">&nbsp;</label>
//                        <input type="submit" value="" class="login_btn" />
//                    </li>
//                </ul>
//            </form>-->
            echo '<label>&ensp;</label>'.\yii\helpers\Html::submitButton("",['class'=>'login_btn','id'=>'sub']);
echo "</ul>";
            \yii\widgets\ActiveForm::end();
            ?>

        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>

<?php
$js=<<<EOF
$("#get_captcha").click(function(){
var tel=$("#tel").val()
if(tel==""){
$("#tel_err").text("请输入手机号")
return false

}
$.ajax({
type:"post",
url:"message",
data:"tel="+tel,
success:function(data){

console.log(data)
$("#sub").click(function(){
var cap=$("#captcha").val()
if(data==cap){
return true
}else{
$("#cap_err").text("验证码错误")
return false
}
})
}
})

})


$("#sub").click(function(){
var yzm=$("#captcha").val()
if(yzm==""){
$("#cap_err").text("请输入验证码")
return false
}else{
return true
}

})


EOF;

$this->registerJs($js);


?>