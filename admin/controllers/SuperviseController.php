<?php
class SuperviseController extends BaseController {

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
           $this-> saveData($model,$_POST[$modelName]);
        }
    }/*曾老师保留部份，---结束*/
  
   function saveData($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }
    
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition('is_progress=1');
        $criteria->condition=get_like('is_progress=1','',$keywords,'');
        $criteria->order="id";//areaCode,areaName
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    //public function actionIndex( $keywords = '') {
      //  $criteria = new CDbCriteria;
        //$criteria->condition=get_like('1','code,name',$keywords,'');//get_where
        //$criteria->order="code";//areaCode,areaName
        //$data = array();
       // parent::display($this->model, $criteria, 'index', $data);
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
