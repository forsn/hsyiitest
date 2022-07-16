<?php

class PublicController extends CController {

    public function actions() {
        return array(
        // captcha action renders the CAPTCHA image displayed on the contact page
        'captcha' => array(
            'class' => 'application.extensions.MyCaptchaAction',
            'backColor' => 0xFFFFFF,
            'maxLength' => '4', // 最多生成几个字符
            'minLength' => '4', // 最少生成几个字符
            'offset' => 1,
            'height' => '40',
            'width' => '100',
        //'fontFile'=> ROOT_PATH.'/static/captcha.ttf',
        ),
        );
    }

    public function actionIndex() {
//        if (Yii::app()->session['admin_id'] == null) {
//            $this->redirect(array('public/login'));
//            exit;
//        }
        $data = array();
        $this->render('index', $data);
    }
  public function actionNoopen() {
        $data = array();
        $this->render('noopen', $data);
    }

    public function actionLate() {
        $data = array();
        $this->render('late', $data);
    }

    public function actionUppic($savepath = '', $sitepath = '', $prefix = '') {
        $this->_uploadify($savepath, $sitepath, $prefix);
    }

    // 保存路径结尾带/
    protected function _uploadify($savepath = '', $sitepath = '', $prefix = '') {
        if (!isset($_FILES['Filedata'])) {
            ajax_exit(array('status' => 0, 'msg' => '图片大小超过限制,最大支持' + ini_get('post_max_size')));
        }
        $attach = CUploadedFile::getInstanceByName('Filedata');
        $datapath=Basepath::model()->modelPath();
        $savepath = Basepath::model()->savePath().$datapath;
        $sitepath = Basepath::model()->sitePath().$datapath;// SITE_PATH . '/uploads/temp/';
        Basepath::model()->mk_dir($savepath);
        if ($prefix != '') {
            $prefix.='_';
        }
        //$datepath .= date('Y') . '/' . date('m') . '/' ;//. date('d') . '/';
        // 保存到远程服务器接口
        $options = array(
            'http' => array(
            'method' => 'POST',
            'header' => 'content-type:application/octet-stream',
            'content' => file_get_contents($attach->tempName),
            ),
        );
        //$file = stream_context_create($options);
        $fileName = $prefix . uniqid('', true) . timeToFilename(). '.' . $attach->extensionName;

        if ($attach->saveAs($savepath . $fileName)) {
            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'savename' =>$datapath.$fileName, 'allpath' => $sitepath . $fileName));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
        }
    }

    public function actionVideoLiveNotify() {
        echo 'success';
    }

}
