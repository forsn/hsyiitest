<?php
class Functionary extends BaseModel {
    public function tableName()
    {
        return '{{functionary}}'; // TODO: Change the autogenerated stub
    }
    /*** Returns the static model of the specified AR class. */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**  * 模型关联规则  */
    public function relations() {
        return array();
    }
    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
        'id' => 'id',
        'code' => '工号',
        'name'=>'姓名',
        'company'=>'所属单位',
        'department'=>'所属科室',
        'gender'=>'性别',
        'age'=>'年龄',
        'edu'=>'学历',
        'position'=>'职位',
        ); 

     //x2_scourse,id,code,value,subjectsetting,subpic,id,x2_scourse;id;code;value;subjectsetting;subpic;id;
    }
    
   //public function picLabels() {
     //   return 'subpic';//图片或文件
   // }  
   //public  function pathLabels(){
     //  return 'articles';//文件存放路径
   //}
  
   /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    public function keySelect(){
        return array('1','code','name');
    }
}
   