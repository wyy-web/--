<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class User extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
        $data=$this->request->post();
        $data['password']= secretpass($data['password']);
        if(!isset($data['nickname'])  || empty($data['nickname'])){
            $data['nickname']='可爱的'.time();
        }
        $result=model('User')->save($data);
        if($result){
            return json([
                'code'=>200,
                'msg'=>'用户添加成功'
            ]);
        }else{
            return json([
                'code'=>404,
                'msg'=>'用户添加失败'
            ]);
        }

    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        checkToken1();
        $uid=$this->request->uid;
        $result=model('User')->queryone(['uid'=>$uid],'uid,nickname,phone,sex,collection,avatar');
        if($result){
            $result['sextext']=setsex($result['sex']);
            return json([
                'code'=>200,
                'msg'=>'查询成功',
                'data'=>$result
            ]);
        }
        else{
            return json([
                'code'=>404,
                'msg'=>'查询失败',

            ]);
        }


    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
