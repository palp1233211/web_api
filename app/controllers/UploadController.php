<?php

namespace api\App\Controllers;

use api\App\Service\UploadService;
use WebGeeker\Validation\ValidationException;

class UploadController extends BaseController
{
    /**
     * 图片上传
     * @return void
     */
    public function imgAction()
    {
        try {
            $file_names = $this->request->getUploadedFiles();
            $path_arr = (new UploadService())->uploadedFiles($file_names);
            return $this->ajaxReturn('ok', 200, ['src'=>$path_arr]);
        }catch (ValidationException $e) {
            $msg = $e->getMessage() ?:'error';
            return $this->ajaxReturn($msg, 0, '');
        }
    }

}