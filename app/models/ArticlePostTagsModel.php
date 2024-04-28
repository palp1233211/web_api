<?php

namespace api\App\Models;

use api\App\Traits\Singleton;

class ArticlePostTagsModel extends BaseModel
{

    use Singleton;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'article_post_tags';
    }

    /**
     * 文章标签关联入库
     * @param $data
     * @param $article_id
     * @return bool
     */
    public function dataSave($data, $article_id)
    {
        try {
            $connection = $this->getWriteDB();
            $insert_data = [
                'article_id' => null,
                'post_tags_id' => null,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ];

            foreach ($data as $datum) {
                $insert_data['article_id'] = $article_id;
                $insert_data['post_tags_id'] = $datum;
                $sql = "
                    insert into article_post_tags(article_id, post_tags_id, created_at, updated_at)
                    values (:article_id, :post_tags_id, :created_at, :updated_at)
                ";
                $statement = $connection->prepare($sql);
                $success = $statement->execute($insert_data);
                if (!$success) {
                    return false;
                }
            }
            return true;
        } catch (\PDOException $e) {
            $this->getLogger()->error('文章标签关联入库报错：'.$e->getMessage())
                ->error('数据：'. json_encode($data));
        }
        return false;
    }

}