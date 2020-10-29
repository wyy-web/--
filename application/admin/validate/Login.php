<?php

namespace app\admin\validate;

use think\validate;


class Login extends Validate{
    protected $rule=[
        'username'=>'require',
        'password'=>'require',
        'oldpass'=>'require',
        'newpass'=>'require',
        'newpassagain'=>'require|confirm:newpass'

];
    protected $message=[
        'username'=>'用户名必填',
        'password'=>'密码必填',
        'oldpass'=>'原密码必填',
        'newpass'=>'新密码必填',
        'newpassagain.require'=>'确认密码必填',
        'newpassagain.confirm'=>'两次密码请保持一致'
    ];
    protected $scene = [
        'login'=>'username,password',
        'changepass'=>'oldpass,newpass,newpassagain'
    ];

}


