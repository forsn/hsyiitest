<?php
class Supervise extends BaseModel {
    public function tableName()
    {
        return '{{proposal}}'; // TODO: Change the autogenerated stub
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
            'code' =>'议案编码',
            'type' => '议案类型',
            'title'  => '议案名称',
            'proposal_time'=>'交办时间',
            'proposal_update'=>'最近更新时间',
            'proposal_action'=>'议案落实进度',
            'company_header'=>'执行负责人',
            'supervision_company'=>'监办单位',
            'proposal_supervisor'=>'监办负责人',
            'content'=>'议案内容',
            'company_name'=>'执行部门',
            'allocation_remark'=>'执行要点说明',
            'is_allocation'=>'是否处于交办状态',
            'is_process'=>'是否跟进流程',
            'is_finish'=>'是否处于结案状态',
        );
       

     //x2_scourse,id,code,value,subjectsetting,subpic,id,x2_scourse;id;code;value;subjectsetting;subpic;id;
    }
    
   //public function picLabels() {
     //   return 'proposal_article';//图片或文件
    //}  
   //public  function pathLabels(){
     //  return 'articles';//文件存放路径
   //}
  
   /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    public function keySelect(){
        return array('1','code','type');
    }
}
   