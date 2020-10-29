<?php


namespace app\admin\controller;

use think\Controller;
use think\Db;

class Category extends Controller
{
    //1.权限
    //验证和解析token
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        checkToken();
    }

//添加
    public function add(){
    //是否用post方式请求
    if (!$this->request->isPost()){
        return json([
            'code'=>404,
            'msg'=>'请求方式错误'
        ]);
    }
    $data=$this->request->post();
    $validate=validate('Category');

//    验证提交上来的数据
    if (!$validate->scene('add')->check($data)){
        return json([
            'code'=>404,
            'msg'=>$validate->getError()
        ]);
    }
    $result=Db::table('category')->insert($data);
    if ($result){
        return json([
            'code'=>200,
            'msg'=>'分类添加成功'
        ]);
    }else{
        return json([
            'code'=>404,
            'msg'=>'分类添加失败'
        ]);
    }
}

//查看数据、分页(limit  page)、搜索
//前台：查看符合指定条件的某一页若干条数据
//后台：将当前页面数据和数据总数返回
//limit  page
public function index(){
    $data=$this->request->get();
    if (isset($data['page'])&&!empty($data['page'])){
        $page=$data['page'];
    }else{
        $page=1;
    }
    if (isset($data['limit'])&&!empty($data['limit'])){
        $limit=$data['limit'];
    }else{
        $limit=5;
    }

    $where=[];
    if (isset($data['cname'])&&!empty($data['cname'])){
        $where['cname']=['like','%'.$data['cname'].'%'];
    }

    $category=Db::table('category')->field('cid,cname,cdesc')->where($where)->page($page)->limit($limit)->select();
    $count=Db::table('category')->where($where)->count();

    if ($category && $count){
        return json([
            'code'=>200,
            'msg'=>'数据获取成功',
            'data'=>$category,
            'total'=>$count,
        ]);
    }else{
        return json([
            'code'=>200,
            'msg'=>'暂无数据',
        ]);
    }
}


public function indexall(){
    $data=$this->request->get();
    $category = Db::table('category')->field('cid,cname')->select();
    if($category ){
        return json([
            'code'=>200,
            'msg'=>'数据获取成功',
            'data'=>$category
        ]);
    }else{
        return json([
            'code'=>200,
            'msg'=>'暂无数据'
        ]);
    }
}

    public function delcategory(){
        $data=$this->request->get();
        if(!$data){
            return json([
                'code'=>404,
                'msg'=>'请求方式错误'
            ]);
        }
        $result=Db::table('category')->where('cid',$data['cid'])->delete();
        if($result > 0){
            return json([
                'code'=>200,
                'msg'=>'删除成功',
            ]);
        }else{
            return json([
                'code'=>404,
                'msg'=>'删除失败'
            ]);
        }

    }


    public function read(){
        $data = $this->request->get();
        $validate = validate('Category');
        if(!$validate->scene('read')->check($data)){
            return  json([
                'code'=>404,
                'msg'=>$validate->getError()
            ]);
        }
        $category =  Db::table('category')->where('cid',$data['cid'])->find();
        if($category){
            return json([
                'code'=>200,
                'msg'=>'数据读取成功',
                'data'=>$category
            ]);
        }else{
            return json([
                'code'=>200,
                'msg'=>'暂无数据'
            ]);
        }
    }


public function edit(){
    $data = $this->request->post();
    $validate = validate('Category');
    if(!$validate->scene('edit')->check($data)){
        return json([
            'code'=>404,
            'msg'=>$validate->getError()
        ]);
    }

//       Db::table('category')->update($data);
    $cid = $data['cid'];
    unset($data['cid']);
    $result = Db::table('category')->where('cid',$cid)->update($data);
    if($result){
        return json([
            'code'=>200,
            'msg'=>'数据更新成功'
        ]);
    }else{
        return json([
            'code'=>404,
            'msg'=>'数据更新失败'
        ]);
    }
}
    public function changepassword(){
        $uid=$this->request->id;
    }

}