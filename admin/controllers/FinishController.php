<?php
class FinishController extends BaseController {

   protected $model = '';
   public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
  public function actionDelete($id) {
      parent::_clear($id,'','id');
    }
    
  public function actionCreate() {   
       $this-> viewUpdate(0);
   } 

   public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }/*曾老师保留部份，---结束*/
  
  public function viewUpdate($id=0) {
        $modelName = $this->model;
        $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $this->render('update', $data);
        } else {
            $temp = $_POST[$modelName];
            list($msec, $sec) = explode(' ', microtime());
            $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
            //$temp['code'] = substr($msectime, 0, 13);

            //$model->proposal_time = date('Y-m-d H:i:s', time()+6*60*60);
            //如果两方都同意结案
            $this-> saveDataTemp($model,$temp);
            if($model->congress_point=='是' && $model->department_point=='是'){
            $model->finish_time = date('Y-m-d H:i:s', time()+6*60*60);
            $model->is_progress = 0;
            $model->is_finish= 0 ;
            $model->workstate = '已结案';
            $this-> saveDataFinish($model,$temp);
          }
            else{//总之就是没结案的话
            $model->is_progress = 1;
            $model->is_finish = 1;
            $model->workstate = '未结案';
            $this-> saveData($model,$temp);
            }
        }
    }/*曾老师保留部份，---结束*/
  
   function saveDataTemp($model,$post) {
       $model->attributes =$post;
       //show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }
    function saveData($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }
    function saveDataFinish($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'议案结案成功！可前往查询界面查看历史议案。', get_cookie('_currentUrl_'),'保存失败');  
    }
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition('is_finish=1');
        $criteria->condition=get_like('is_finish=1','',$keywords,'');
        $criteria->order="id";//areaCode,areaName
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    //public function actionIndex( $keywords = '') {
        //$criteria = new CDbCriteria;
        //$criteria->condition=get_like('1','code,name',$keywords,'');//get_where
        //$criteria->order="code";//areaCode,areaName
        //$data = array();
        //parent::display($this->model, $criteria, 'index', $data);
    //}
    public function actionPreview($id = '')
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        $data = array();
        $data['model'] = $model;
        $this->render('preview', $data);
    }

}
