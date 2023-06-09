<?php

namespace api\App\Service;

use http\Exception\UnexpectedValueException;
use Phalcon\Http\Request\File;
use WebGeeker\Validation\Validation;
use WebGeeker\Validation\ValidationException;
use const BASE_PATH;

class UploadService extends BaseService
{
    private $__validations;

    public function __construct($validations = null)
    {
        $this->__validations = $validations;
    }

    /**
     * 批量上传
     * @param $files
     * @return array
     * @throws ValidationException
     */
    public function uploadedFiles($files)
    {
        $path_arr = [];
        foreach ($files as $file) {
            $result = $this->uploaded($file);
            if ($result['code'] !== true) {
                throw new ValidationException($result['msg']);
            }
            $path_arr[] = $result['path'];
        }
        return $path_arr;
    }

    /**
     * 单条上传
     * @param File $file
     * @return array
     */
    public function uploaded(File $file)
    {
        try {
            $name = $file->getName();
            $type = $file->getType();
            $tempName = $file->getTempName();
            $code = false;
            $msg = $path = '';
            if ($this->__validations) {
                $params = [
                    'type' => $type,
                    'size' => $file->getSize(),
                ];
                Validation::validate($params, $this->__validations);
            }
            $today = date('Ymd');

            $path = BASE_PATH . '/public/uploads/' . $type. '/' . $today ;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
                chmod($path, 0777);
            }
            $path .= '/' . $name;
            // 处理上传的文件，例如保存到服务器上
            $code = move_uploaded_file($tempName, $path);
        }catch (ValidationException $e) {
            $msg = $e->getMessage();
        }
        return ['code'=>$code,'path'=>$path,'msg'=>$msg];
    }




}