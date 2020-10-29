<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Exception;
use think\Request;

class Orders extends Controller
{
    public $code;
    public $model;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->code=config('code');
        $this->model=model('Orders');
    }

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

        $data=$this->request->post();
        $data['uid']=$this->request->uid;
        $data['status']=1;
        $homdemodel=model('Stayhome');
        $stayhome=$homdemodel->queryone(['sid'=>$data['sid']],'status');
        if(!$stayhome['status']){
            return json([
                'code'=>404,
                'msg'=>'民宿已被预定'
            ]);
        }
        Db::startTrans();
//        try {

            $orderresult=$this->model->add($data);
            $orderoid=$this->model->getLastInsID();
            $homeresult=$homdemodel->edit(['status'=>0],['sid'=>$data['sid']]);
            Db::commit();
            if($orderresult && $homeresult){

                return json([
                    'code'=>$this->code['success'],
                    'msg'=>'预定成功',
                    'oid'=>$orderoid
                ]);
            }


//        }catch (Exception $exception){
            Db::rollback();
            return json([
                'code'=>$this->code['fail'],
                'msg'=>'预定失败'
            ]);


//        }


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
        $uid=$this->request->uid;
        $data=$this->request->get();
        if(isset($data['limit']) && !empty($data['limit']) ){
            $limit=$data['limit'];
        }else{
            $limit=5;
        }

        if(isset($data['page']) && !empty($data['page']) ){
            $page=$data['page'];
        }else{
            $page=1;
        }
        if(isset($data['field']) && !empty($data['field']) ){
            $field=$data['field'];
        }else{
            $field=1;
        }

        $result=Db::view('stayhome', 'sid,sname,sdesc,sprice,sthumb')
            ->view('orders', '*', 'stayhome.sid=orders.sid')
            ->where(['uid'=>$uid,'orders.status'=>$field])
            ->select();
        $typearr=[1=>'确认付款',2=>'完成入住',3=>'点击评价',4=>'点击退款'];

        if($result){
            $result=array_map(function ($ele) use($typearr) {
                $ele['text']=$typearr[$ele['status']];
                return $ele;
            },$result);
            return json([
                'code'=>200,
                'msg'=>'查找成功',
                'data'=>$result
            ]);
        }else{
            return json([
                'code'=>200,
                'msg'=>'暂无数据',

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

        $result=$this->model->payorder(['oid'=>$id],['status'=>2]);
        if($result){
            return json([
                'code'=>200,
                'msg'=>'支付成功'
            ]);
        }else{
            return json([
                'code'=>404,
                'msg'=>'支付失败'
            ]);
        }
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
