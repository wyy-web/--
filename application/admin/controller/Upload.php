<?php


namespace app\admin\controller;

use think\Controller;


class Upload extends Controller
{
    public function index(){
        //拿到前台上传的文件
        $file=$this->request->file('file');
        if($file){
            //后台的验证
            $info = $file->validate(['size'=>500*1024 ,'ext'=>'jpg,png,gif,webp'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info){
                //成功上传后  获取上传信息
                //返回的路径
                $imgpath=date('Ymd').'/'.$info->getFilename();
                return json([
                    'code'=>200,
                    'msg'=>'图片上传成功',
                    //前台拿到绝对路径  缩略图的地址
                    'imgpath'=>'/hotel-admin/public/uploads/'.$imgpath
                ]);
            }else{
                //上传失败获取错误信息
                return json([
                    'code'=>404,
                    'msg'=>$file->getError(),
                ]);
            }
        }else{
            return json([
                'code'=>404,
                'msg'=>'上传文件不能为空'
            ]);

        }
    }

}