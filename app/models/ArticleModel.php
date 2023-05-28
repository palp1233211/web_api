<?php

namespace api\App\Models;

use api\app\Traits\Singleton;

class ArticleModel extends BaseModel
{

    use Singleton;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'article';
    }

    /**
     * 新增文章入库
     * @param $data
     * @return bool|int
     */
    public function rowSave($data)
    {
        try {
            $sql = "
                insert into article(title, short_title, small_image, content, created_at, updated_at)
                values (:title, :short_title, :small_image, :content, :created_at, :updated_at)
            ";
            $insert_data = [
                'title' => $data['title'],
                'short_title' => $data['short_title'],
                'small_image' => $data['small_image'],
                'content' => $data['content'],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ];
            $connection = $this->getWriteDB();
            $statement = $connection->prepare($sql);
            $success = $statement->execute($insert_data);
            if ($success) {
                return $connection->lastInsertId();
            }
        } catch (\PDOException $e) {
            $this->getLogger()->error('新增文章入库报错：'.$e->getMessage())
                ->error('数据：'. json_encode($data));
        }
        return false;
    }

}