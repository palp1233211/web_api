<?php

namespace api\App\Service;

use api\App\Exception\InfoException;
use api\App\Models\ArticleModel;
use api\App\Models\ArticlePostTagsModel;
use mysql_xdevapi\Exception;

class ArticleService extends BaseService
{

    /**
     * 文章数据入库
     * @param $data
     * @return bool
     */
    public function save($data)
    {
        $db = $this->getWriteDB();
        $db->begin();
        try {
            //文章数据入口
            $article_model = ArticleModel::getInstance();
            $lastInsertId  = $article_model->rowSave($data);
            if (!$lastInsertId) {
                throw new \Exception('文章入库失败');
            }
            //文章标签数据入口
            $tag_list = $data['tag_list'];
            $article_post_tags_model = ArticlePostTagsModel::getInstance();
            $success = $article_post_tags_model->dataSave($tag_list, $lastInsertId);
            if (!$success) {
                throw new \Exception('文章标签数据入口失败');
            }
            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollback();
            $this->getLogger()->error('文章入库失败：'.$e->getMessage());
        }
        return false;
    }



}