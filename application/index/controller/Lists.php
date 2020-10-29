<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Lists extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $data=$this->request->get();
        if(isset($data["page"])  && !empty($data["page"])){
            $page=$data["page"];
        }else{
            $page=1;
        }
        if(isset($data["limit"])  && !empty($data["limit"])){
            $limit=$data["limit"];
        }else{
            $limit=config('paginate.list_rows');
        }
        $where=[];
        if(isset($data["cname"])  && !empty($data["cname"])){
            $where["cname"]=['like','%'.$data["cname"].'%'];
        }
        if(isset($data["sprovince"])  && !empty($data["sprovince"])){
            $where["sprovince"]=$data['sprovince'];
        }

        $orderfield='sid';
        $ordertype='desc';

        if(isset($data['field'])  && !empty($data['field'])){
            $orderfield=$data['field'];
        }
        if(isset($data['type'])  && !empty($data['type'])){
            $ordertype=$data['type'];
        }
        $result=Db::table('stayhome')->where($where)->field('sid,sname,sthumb,sprice,score,sprovince,ctime,scity,sarea')->order($orderfield,$ordertype)->paginate($limit,false,['page'=>$page]);
        $total=$result->total();
        $item=$result->items();

        if($total && $item){
            return json([
                'code'=>200,
                'msg'=>'数据读取成功',
                'total'=>$total,
                'data'=>$item
            ]);
        }else{
            return json([
                'code'=>404,
                'msg'=>'暂无数据',
            ]);
        }


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
