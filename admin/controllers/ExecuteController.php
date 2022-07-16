<?php
class ExecuteController extends BaseController {

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
    
//连续交办
    public function actionUpdateExe() {

        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model=Execute::model()->find('is_allocation=1');
        
        if(isset($model))
        {
          $id=Execute::model()->find('is_allocation=1')->id;
          $model = $this->loadModel($id, $modelName);


          $proposal=Execute::model()->find('id='.$id);
          if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
            
           $this->render('UpdateExe', $data);

         } else { 
          //$model->proposal_time = date('Y-m-d H:i:s', time()+6*60*60);
          $submitType = $_POST['submitType'];
          if($submitType == 'baocun'){
            $model->is_allocation = 1;
            $model->is_progress = 0;
            $model->workstate = '交办中';
            $this-> saveData($model,$_POST[$modelName]);
          }
          else{
            $model->proposal_time = date('Y-m-d H:i:s', time()+6*60*60);
            $model->is_allocation = 0;
            $model->is_progress = 1;
            $model->is_finish = 1;
            $model->workstate = '已交办';
            $this-> saveDataSubmit($model,$_POST[$modelName]);
          }
          
        }
      }
      else
      {
        $msg="已经没有可以继续审核的议案";
        echo $msg;
      }
    }



//单个交办
    public function viewUpdate($id=0) {
        $modelName = $this->model;
        $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $this->render('update', $data);
        }   
        else{
            $temp = $_POST[$modelName];
            list($msec, $sec) = explode(' ', microtime());
            $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
            //$temp['code'] = substr($msectime, 0, 13);

            $submitType = $_POST['submitType'];
            if($submitType == 'baocun'){//如果交办时选择保存而不选择提交，那么留在交办界面，不能进入跟进界面
            $model->is_allocation = 1;
            $model->is_progress = 0;
            $model->is_finish= 0;
            $model->workstate = '交办中';
            $this-> saveData($model,$temp);
          }
            else{//如果交办时选择了提交,那么就不能留在交办界面，而是要出现在跟进界面
            $model->proposal_time = date('Y-m-d H:i:s', time()+6*60*60);
            $model->is_allocation = 0;
            $model->is_progress = 1;
            $model->is_finish = 1;
            $model->workstate = '已交办';
            }
            $this-> saveDataSubmit($model,$temp);
        }
    }/*曾老师保留部份，---结束*/

//议案浏览应该要有两种议案
    /*
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition('is_allocation=1');
        $criteria->condition=get_like('is_allocation=1','',$keywords,'');
        $criteria->order="id";//areaCode,areaName
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }*/
    public function actionIndex( $keywords = '') {
        $criteria = new CDbCriteria;
        $criteria->condition=get_like('1','code,name',$keywords,'');//get_where
        $criteria->order="code";//areaCode,areaName
        $data = array();
        parent::display($this->model, $criteria, 'index', $data);
    }
    public function actionIndexExe($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition('is_allocation=1');
        $criteria->condition=get_like('is_allocation=1','',$keywords,'');
        $criteria->order="id";//areaCode,areaName
        $data = array();
        parent::_list($model, $criteria, 'indexExe', $data);
    }
     public function actionIndexN($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition('is_allocation=1');
        $criteria->condition=get_like('is_allocation=1','',$keywords,'');
        $criteria->order="id";//areaCode,areaName
        $data = array();
        parent::_list($model, $criteria, 'indexN', $data);
    }
    public function actionIndexY($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition('is_progress=1');
        $criteria->condition=get_like('is_progress=1','',$keywords,'');
        $criteria->order="id";//areaCode,areaName
        $data = array();
        parent::_list($model, $criteria, 'indexY', $data);
    }
  
    function saveData($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }

    function saveDataSubmit($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'交办成功！', get_cookie('_currentUrl_'),'交办失败，请重试');  
    }


    public function actionPreview($id = '')
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        $data = array();
        $data['model'] = $model;
        $this->render('preview', $data);
    }


public function actionPreviewExe($id = '')
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        $data = array();
        $data['model'] = $model;
        $this->render('previewExe', $data);
    }

public function actionPreviewN($id = '')
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        $data = array();
        $data['model'] = $model;
        $this->render('previewN', $data);
    }

public function actionPreviewY($id = '')
    {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        $data = array();
        $data['model'] = $model;
        $this->render('previewY', $data);
    }
}
