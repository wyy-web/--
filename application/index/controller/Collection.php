<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Collection extends Controller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        checkToken1();
    }
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
        $data=$request->post();
        $model=model('User');
        $where['uid']=$this->request->uid;
        $result=$model->collection($where,$data);
        if ($result){
            return json([
                'code'=>200,
                'msg'=>'收藏成功',
            ]);
        }else{
            return json([
                'code'=>404,
                'msg'=>'收藏失败',
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

        $uid = $this->request->uid;
        $collectionarr = model('User')->queryone(['uid' => $uid], 'collection');
        $result = Db::table('stayhome')->field('sid,sname,sthumb,sprovince,scity,sarea,sprice,stag,sdesc')->where('sid','in',$collectionarr['collection'])->select();

        if ($result) {
            return json([
                'code' => 200,
                'msg' => '查询成功',
                'colldata' => $result
            ]);
        } else {
            return json([
                'code' => 404,
                'msg' => '查询失败',

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
