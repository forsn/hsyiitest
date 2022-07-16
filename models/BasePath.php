<?php
class Basepath extends BaseModel {
    var $db_data="2";//文件上传使用的是统一的服务器，需要设置访问数据源，1-新服务器，2-内测，3-公测，4-公网

    public function tableName() {
        return '{{x2_base_code}}';//base_path
    }
      /*** Returns the static model of the specified AR class. */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /** * 模型关联规则 */
    public function relations() {
        return array( );
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
      );
    }

  public function savePath() {
    return ROOT_PATH .'/uploads/';//."uploads/temp/";
  }

  public function sitePath() {
        return  SITE_PATH .'/uploads/';
  }

  public function modelPath(){
     $s1=get_session('modelPath');
     $s1=($s1) ? $s1.'/' : 'temp/';
     return  $s1 .date('Y') . '/' . date('m') . '/' ;
  }


  public function datePath(){
     return date('Y') . '-' . date('m') ;//. '/' . date('d') . '/';
  }
  function mk_dir($path, $mode = 0755) {
  if(!is_dir($path)) {
    $ds=explode("/",$path);
    $s1="";$b1='';
    foreach ($ds as $v) {
       if(!empty($v)){
        $s1.=$b1.$v;$b1='/';
        if (!is_dir($s1)) {
            mkdir($s1,$mode,true);
        }
      } 
    }
  }
}

public function toNewPage($paction) {
    return  $this->getParentPath().'index?r='.$paction;
  }
   
public function reMovePath($str1){
  return  str_replace($this->sitePath(),"",$str1);
}



public function addPath($str1){
    if($str1)
     if(!substr_count($str1,'http')){
      if(indexOf($str1,'app/core/')>=0)
         $str1=SITE_PATH.trim('/ ').$str1;
       else{
        $str1=$this->sitePath().$str1;
       }
    }
    return  $str1;
  }
     
public function remove_path($str) {
  return $this->reMovePath($str);
}

public function fileIcon($flie) {
   $s1=substr($flie,-3,3);
   $s2='uploads/temp/image/'.$s1.'_icon.jpg';
    if(indexOf($s1,'app/core/')>=0)
      $s2=$this->addPath($s2);
    else{
       $s2=$this->addPath($s2);
    }
   $rs=$flie;
   if (substr($flie,-3,3)=='pdf') $rs=$s2;
    return $rs;
  }

     
}
