<?php

namespace api\App\Controllers;

use api\App\Service\ArticleService;
use Phalcon\Db\Adapter\Pdo\Mysql;

class ArticleController extends BaseController
{
    public function createAction()
    {
        try {
            $param = [];
            $param['title'] = $this->request->get('name', 'trim');
            $param['short_title'] = $this->request->get('short_title', 'trim');
            $param['small_image'] = $this->request->get('small_image', 'trim');
            $param['content'] = $this->request->get('content', 'trim');
            $param['tag_list'] = $this->request->get('tag_list', 'trim');
            if (empty($param['title'])|| empty($param['short_title']) || empty($param['small_image'])  || empty($param['content']) || empty($param['tag_list'])) {
                $this->ajaxReturn('error', ERROR_PARSE, '');
            }
            $article_service = new ArticleService();
            $success = $article_service->save($param);
            if ($success) {
                $this->ajaxReturn('ok', 200, '');
            }
        } catch (\Exception $e) {
            $this->logger->error('创建文章失败:'.$e->getMessage());
        }
        $this->ajaxReturn('error', ERROR, '');
    }
    public function pvAction(){
        $name = $this->request->get('name', 'trim');

        $this->ajaxReturn('ok',200, [$name]);
    }

    /**
     * 获取文件标签列表
     * @return void
     */
    public function labelTagListAction()
    {
        $data = [
            ['value'=>'1' ,'label'=> '黄金糕' ],
            ['value'=>'2' ,'label'=> '双皮奶' ],
            ['value'=>'3' ,'label'=> '蚵仔煎' ],
        ];
        $this->ajaxReturn('ok',200, $data);
    }
}