<?php

namespace api\App\Controllers;

use api\App\Service\UploadService;
use WebGeeker\Validation\ValidationException;

class UploadController extends ControllerBase
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
            $this->ajaxReturn('ok', 200, ['src'=>$path_arr]);
        }catch (ValidationException $e) {
            $msg = $e->getMessage() ?:'error';
            $this->ajaxReturn($msg, 0, '');
        }
    }

}