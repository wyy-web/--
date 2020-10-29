<?php

namespace app\admin\controller;


 use think\Controller;
 use think\Db;
 use think\JWT;
// 1.验证权限
//2.验证请求方式
//3.接受前台发送数据
//4.前台数据验证
//5.业务逻辑

class Login extends Controller
{
    public function check()
    {
        $method = $this->request->method();
        if ($method != 'POST') {
            return json([
                'code' => 404,
                'msg' => '请求方式错误'

            ]);

        }
        $data = $this->request->post();
        $validate = validate('Login');
        $flag = $validate->scene('login')->check($data);
        if (!$flag) {
            return json([
                'code' => 404,
                'msg' => $validate->getError()
            ]);
        }
        $whereArr = ['username' => $data['username']];
        $user = Db::table('admin')->where($whereArr)->find();
        if ($user) {
            $password = md5(crypt($data['password'], config('salt')));
            if ($password === $user['password']) {
                $payload = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'avatar' => $user['avatar']
                ];
                $token = JWT::getToken($payload, config('jwtkey'));
                return json([
                    'code' => 200,
                    'msg' => '登录成功',
                    'token' => $token,
                    'user' => $payload,
                ]);
            } else {
                return json([
                    'code' => 404,
                    'msg' => '用户名与密码不匹配'

                ]);
            }
        } else {
            return json([
                'code' => 404,
                'msg' => '用户名不存在'

            ]);
        }
    }
//修改管理员密码
//1.oldpass  ===  password
//2. 更新
    public function changepass(){
        checkToken();
        if(!$this->request->isPost()){
            return json([
                'code'=>404,
                'msg'=>'请求方式错误'
            ]);
        }

        $data = $this->request->post();
        $validate = validate('login');
        if(!$validate->scene('changepass')->check($data)){
            return json([
                'code'=>404,
                'msg'=>$validate->getError()
            ]);
        }
        $id = $this->request->id;
        $oldpass =  secretpass( $data['oldpass']);
        $newpass =  secretpass( $data['newpass']);

        if($oldpass == $newpass){
            return json([
                'code'=>404,
                'msg'=>'新密码和原密码不能相同'
            ]);
        }

        $result = Db::table('admin')->field('password')->where('id',$id)->find();
        $password = $result['password'];

        if($password != $oldpass){
            return json([
                'code'=>404,
                'msg'=>'原密码错误'
            ]);
        }

        $result =  Db::table('admin')->where('id',$id)->update(['password'=>$newpass]);

        if($result){
            return json([
                'code'=>200,
                'msg'=>'数据更新成功,请重新登录'
            ]);
        }else{
            return json([
                'code'=>404,
                'msg'=>'数据更新失败'
            ]);
        }
    }

}
