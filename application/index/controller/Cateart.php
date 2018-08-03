<?php
namespace app\index\controller;

use app\common\controller\Base;

// 引入facade\session监测登陆
use think\facade\Session;


// 引入文章model
use app\common\model\Article;

// 引入文章分类model
use app\common\model\Category;

// 引入用戶表
use app\common\model\User;

// 控制文章分类列表也和文章详情页
class Cateart extends Base
{
	// 首页方法
    public function index()
    {

        // 获取文章数据赋值，根据分类id，筛选对应的文章

        // 获取请求的文章分类id cate_id
        $paramdata = $this->request->param();

        // halt($paramdata);

        // 根据接受的文章分类id，在文章分类里搜索后赋值发给前端，前端用来做发布文章，和显示本组使用
        $cateecho = Category::where('cate_id',$paramdata['cateid'])->find();


        // 置顶文章赋值
        $articletop = Article::where('cate_id',$paramdata['cateid'])//搜索文章分类
                                ->where('art_top',1)//搜索置顶状态
                                ->order('update_time', 'DESC')//按照更新时间降序
                                ->select();
        // halt($articletop);

        // 不置顶文章赋值
        $articlelist = Article::where('cate_id',$paramdata['cateid'])//搜索文章分类
                                ->where('art_top',0)//搜索不置顶状态
                                ->order('update_time', 'DESC')//按照更新时间降序
                                ->select();

        // 模板输出变量
        $this->view->assign('articletop',$articletop);
        $this->view->assign('articlelist',$articlelist);
        $this->view->assign('cateecho',$cateecho);



    	// 渲染模板
        return $this->view->fetch();
    }

    // 详情页方法
    public function detail()
    {
        // 获取主帖文章id，
         $data = $this->request->param();


        // 搜索文章内容赋值
         $article = Article::where('art_id',$data['art_id'])->find();

         // 搜索文章的分类ID，返回给前端
          $cateecho = Category::where('cate_id',$article['cate_id'])->find();

        // 模板变量输出
         $this->view->assign('article',$article);
         $this->view->assign('cateecho',$cateecho);

         // 根据主帖id，获取回帖，主帖id就是回帖的pid
         $article_reply = Article::where("part_id",$data['art_id'])
                                    ->order('update_time', 'ASC') //回帖升序排列
                                    ->select();
         // halt($article_reply);
        // 回帖输出到模板
        $this->view->assign('article_reply',$article_reply);

        // 渲染模板
        return $this->view->fetch();
    }

    // 发表新帖方法
    public function add()
    {
        // 监测登陆
        $this->ifLogin();

        // 获取文章分类的请求
        $data = $this->request->param();

        // 搜索文章分类ID，赋值
        $cateadd = Category::where('cate_id',$data['cate_id'])->find();

        // 模板输出
        $this->view->assign('cateadd',$cateadd);

        // 渲染模板
        return $this->view->fetch();
    }

    // 登陆判断，不登录跳转到登录页,发布帖子，编辑帖子需要执行此方法
    protected function ifLogin()
    {
        if (!Session::has('user_id')) { //没有session
            
            $this->error('请先登陆','user/login');
        }
    }

    // 文章主帖添加方法
    public function artadd()
    {
        // 获取数据
        $artadd = $this->request->post();
        // halt($artadd);

        // 保存到数据表
        $savesrt = Article::create([
            "art_title" => $artadd["art_title"],
            "user_id"   => $artadd["user_id"],
            "cate_id"   => $artadd["cate_id"],
            "art_content" => $artadd["art_content"]
        ]);


        // 成功后进入文章详情页
        if ($savesrt) { //保存成功
            // 返回成功代码，提示，和保存后文章id
            // 给模板输出一个文章的id
            // halt($savesrt->art_id);
            // $this->view->assign("svart_id",$savesrt->art_id);

            // 返回提示
            // exit(json_encode(["code"=>1,"msg"=>"发布成功"]));
            exit(json_encode(["code"=>1,"msg"=>"发布成功","artid"=>$savesrt->art_id]));
        }else{
            // 失败提示
            exit(json_encode(["code"=>2,"msg"=>"发布失败"]));
        }

        
    }

    // 图片上传
    public function imgupload()
    {

        // 获取图片数据
        $upimg = $this->request->file("img");

        // halt($upimg);

        // 将上传的文件移动到指定目录,注意从public开始作为根目录，必须有点
        $saveimg = $upimg->move("./upload/img");

        // halt($saveimg);

        // 图片保存后获取其地址返回前端
        if ($saveimg) {
            // exit($saveimg->getSaveName());
            // 返回json格式的图片地址,这里不用有点了，根据编辑器的手册返回
            exit(json_encode(["errno"=>0,"data"=>["/upload/img/".$saveimg->getSaveName()]]));
            // return json(["errno"=>0,"data"=>["/upload/img".$saveimg->getSaveName()]]);
        }else{
            exit($saveimg->getError());
        }


    }

    // 回帖上传方法
    public function artrepadd()
    {
        // 获取回帖数据
        $artrep = $this->request->post();

        // 保存回帖到数据表
        $saveartrep = Article::create([
            "part_id" => $artrep["part_id"],
            "user_id" => $artrep["user_id"],
            "cate_id" => $artrep["cate_id"],
            "art_content" => $artrep["art_content"]
        ]);

        // 成功后进行提示
        if ($saveartrep) { //保存成功
            // 返回成功代码，提示，和保存后文章id
            
            exit(json_encode(["code"=>1,"msg"=>"发布成功"]));
        }else{
            // 失败提示
            exit(json_encode(["code"=>2,"msg"=>"发布失败"]));
        }



    }


}
