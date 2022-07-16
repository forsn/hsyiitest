<?php

class Test extends BaseModel {
    public function tableName() {
        return '{{x2_test_err}}';
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
      'f_id' => 'ID',
      'f_msg' =>'内容',
      'f_time'=> '更新时间',
      'f_callname' =>'调用函数',
      'f_username' => '操作人',
      );
    }

   public static function put_msg($pmsg) {
        if (is_array($pmsg)){
            $pmsg=json_encode($pmsg);
        }
        $test = new Test();
        $test->isNewRecord = true;
        $test->f_msg=$pmsg;
        $test->f_callname=json_encode(debug_backtrace());
        $test->f_time=get_date();
        $test->save();
     }


    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

}
