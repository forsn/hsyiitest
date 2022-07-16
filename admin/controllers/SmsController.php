<?php

class SmsController extends BaseController {
    protected $model = '';
    public function init() {
        parent::init();
    }

    public function actionSupplier($keywords = '', $partnership_type = 0, $project_id = 0, 
        $no_cooperation = 0, $s_state='' ) {  // $s_state="s_state='编辑中'"  这样可以筛选出状态是“编辑中”的商家
        //最后一个参数选择渲染页面  
        $this->show_info($keywords, $partnership_type, $project_id, $no_cooperation, $s_state, 'supplier');
    }

    public function actionSendSms($to = '',$text=''){ 
      echo Sms::model()->sendMsg();
    }



    function show_info($keywords, $partnership_type, $project_id, $no_cooperation, $s_state, $pfile) {
        $data = array();
        $model = SupplierList::model();
        $criteria = new CDbCriteria;

        $criteria->condition = $s_state;
        $criteria->select = 's_id select_id,s_name select_title,s_state select_code';

        if($keywords != '') {
            $criteria->condition .= ' AND (s_name like "%' . $keywords . '%")';
        }

        parent::_list($model, $criteria, $pfile, $data, 10);
    }
}