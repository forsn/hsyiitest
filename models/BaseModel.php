<?php

class BaseModel extends CActiveRecord {

    public $select_id='';
    public $select_code='';
    public $select_title='';
    public $select_item1='';
    public $select_item2='';
    public $select_item3='';
    public $html_tmp0='',$html_tmp1='',$html_tmp2='';
    public $data_check=1;
    protected function afterSave() {
        parent::afterSave();
    }
    public  function className() {
        return (__CLASS__);
    }
    
   public  function noCheck($ch=0) {
       set_session('noCheck',$ch);
    }
  public  function getNoCheck() {
     return get_session('noCheck');
    }

public function extend($values){
    foreach($values as $var=>$value){
    if(!isset($this->{$var}))
     $this->{$var} = $value;
    }
  }
 protected function abeforeSave() {
      parent::beforeSave();
      if(!($this->getTableName()=="table_update")){
         if(!$this->getIsNewRecord()) $this->update_log($tname);
      } 
      return true;
  }

   protected function getTableName() {
      $tname= str_replace('{','',$this->tableName());
      return str_replace('}','',$tname);
    }

    protected function afterDelete() {
        parent::afterDelete();
    }

    protected function safeField() {
       $dm=$this->attributeLabels();
       $s1='';$b1='';
       foreach($dm as $k=>$v)
       { $s1.=$b1.$k;$b1=',';}
       return $s1;
    }

    /** * 属性标签 */
    public function getAttributeSet() {
        $attributes=$this->attributeSets();
        $arr = array();
        foreach ($attributes as $k => $v) {
           $d=explode(':',$v.':');
           $arr[$k] =$d[0];
        }
        return $arr;
    }
    /**  * 属性标签 */
    public function noEmptyAttribute() {
        $attributes=$this->attributeSets();
        $s1='';$b1="";
        $rs=array();
        $data_check=0;//$this->getNoCheck();
        if(isset($_POST["submitType"])){
           $data_check=(indexOf($_POST["submitType"],"_Nocheck")>=0) ? 1 : 0;
        }
        if ($data_check==0){
          foreach ($attributes as $k => $v) {
             $d=explode(':',$v.':');
             if((indexof($v,':k')>=0 || indexof($v,':K')>=0)) // && (indexof($v,':len')<0) ) 
               {$s1.=$b1.$k;$b1=',';}
             if(indexof($v,':len')>=0){
               $rs[]=$this->lenSet($k,$d);
             }
          }
        }
        $rs[]=array($s1, 'required', 'message' => '{attribute} 不能为空');
        return $rs; 
    }


    /** * 属性标签 */
    public function lenSet($k,$dsrt) {
        $n1=1;$n2=20;
        foreach ($dsrt as $v) {
           if(indexof($v,'len')>=0){
             $s1=str_replace('len','',$v);
             $s1=str_replace('(','',$s1);
             $s1=str_replace(')','',$s1);
             $ds=explode(',',$s1.','.$s1);
             $n1= $ds[0];$n2= $ds[1];
           }
        }
      //  return  array($k, 'length', 'min'=>11, 'tooShort'=>'密码至少为6位');
        return array($k,'length', 'min'=>$n1,'max'=>$n2);
    }



    /** * 属性标签 */
    public function saveAttribute() {
        return array($this->safeField(),'safe');
    }

  /**   * 属性标签 */
    public function attributeRule() {
        $rs=$this->noEmptyAttribute();
        $rs[]=$this->saveAttribute();
        return $rs;
    }

    public function del_daohao($pstr,$dchar=',')
    {
       $pstr=str_replace(' ','', $pstr);
       return str_replace($dchar.$dchar,$dchar,$pstr);
     }
         //自动图片加上路径
    protected function afterFind(){
      parent::afterFind();
      $this->toAddPath();
      $this->changeJsonData(1);
   //   $this->changeHtml(1);
    }

//保存图片时候 删除图片前面的路径
    protected function beforeSave(){
      parent::beforeSave();
       if(!($this->getTableName()=="x2_test_err")) $this-> movePath();
        return true;
    }

//保存的图片取消根路径 op=?,0 删除，1 添加
    protected function changeHtml($op){
        $ds=$this->getHtmlField();
        foreach($ds as $v1){ //加上路径名称
           if(isset($this->{$v1})){
               $s2=$this->{$v1};
               if($op==1){
                 $s2=html_entity_decode($s2);//转换成数组
               }
               $this->{$v1}=$s2;
           }
        }
        return true;
    }

    //保存图片时候 删除图片前面的路径
    protected function toAddPath(){
        $ds=$this->getPicField();
        foreach($ds as $v1){ //加上路径名称
          $this->{$v1}=BasePath::model()->addPath($this->{$v1});
        }
    }

    //保存图片时候 删除图片前面的路径
   
    protected function movePath(){
        $ds=$this->getPicField();
        foreach($ds as $v1){ //加上路径名称
          $this->{$v1}=BasePath::model()->reMovePath($this->{$v1});
        }
    }

//改变数据格式 op=?,0 JONS 字符串，1 字符转JSON添加
    protected function changeJsonData($op=0){
       $ds=$this->getJsonField();
       $i=0;
       foreach($ds as $v1){ //加上路径名称
          $i=$i+1;
          $s2=$this->{$v1};
          if(isset($this->{$v1})){
               $s2=$this->{$v1};
               if($op==1){
                 $s2=$this->mb_unserializea($s2);//转换成数组
               }
              $this->{$v1}=$s2;
          }
       }
       return true;
    }
   //扩充 对象转换成数组
   public function saveHtml($fieldstr,$post) {
        if(isset($post[$fieldstr.'_temp']) ){
           $this->{$fieldstr}=$post[$fieldstr.'_temp'];
        };
    }

    protected function getPicField() {
      $rs=array();
      if(method_exists($this,'picLabels')){
        $afieldstr=$this->picLabels();
        $rs=explode(',',$afieldstr);
      }
      return $rs;
    } 

  public function setUploadPath() {
      $tpath='temp';
      if(method_exists($this,'pathLabels')){
        $tpath=$this->pathLabels();
      }
      set_Session('modelPath',$tpath);
    } 
    
  protected function getHtmlField() {
      $rs=array();
      if(method_exists($this,'htmlLabels')){
        $afieldstr=$this->picLabels();
        $rs=explode(',',$afieldstr);
      }
      return $rs;
    } 


  protected function getJsonField() {
    $rs=array();
    if(method_exists($this,'jsonLabels')){
      $rs=explode(',',$this->jsonLabels());
    }
    return $rs;
  }

function mb_unserializea($str) {
  if(!is_array($str))
  if((strpos($str,"s:")>0)||empty($str)){
       $data=$str;
       $str=@unserialize($str);
       if (!$str) {
            $str =$this->mb_unserializeb($data);
       }
    }
   return $str;
}

function serializekey() {
    return '|s\:(\d+)\:"(.*?)"|';
}

function mb_unserializebk($serial_str) {
    $out = preg_replace_callback($this->serializekey(),
    function ($matches){
        return "s:".strlen($matches[2]).":\"$matches[2]\"";
    },
    $serial_str);
    return unserialize($out);
}
 
function mb_unserializeb($serial_str) { 
    $serial_str = preg_replace_callback('/s:(\d+):"([\s\S]*?)";/', function($matches) {
        return 's:'.strlen($matches[2]).':"'.$matches[2].'";';
      }, $serial_str);
    return unserialize($serial_str);  
}

protected function update_log($tname) {
    return 0;
    $dm=$this->attributeLabels();
    $tmp0=sql_findall('SHOW FULL COLUMNS FROM '.$tname);
    $key="";
    foreach($tmp0 as $v)
    {
        if($v['Key']=='PRI'){
            $key=$v['Field'];
            break;
        }
    }
    $val=$this->{$key};
    $tmp2=$this->find($key."='".$val."'");
    $data=array();
    foreach($tmp0 as $v)
    {
        $k=$v['Field'];
        if(isset($this->{$k})){
          $s1=$tmp2->{$k};
          $s2=$this->{$k};
          if(!($s1==$s2)){
              $data[$k]=array($s1,$s2);
          }
        }
    }
 //   save_change($tname,0,$data,$key,$val);//0修改 1 删除
  //  save_change_table($tname);
}

//扩充 对象转换成数组
 protected function objtoArray($afieldstr) {
      $arr=array();
      $afields=array();
      $r=0;
      $val=$this->attributes;
      $afieldstmp=explode(',',$afieldstr);
      foreach($afieldstmp as $v1){
        $a=explode(':',$v1);
        $afields[$a[0]]=$a[0];
        $aval[$a[0]]='<null>';
        if(isset($a[1])) $afields[$a[0]] = $a[1];//有别名
         $arr[$a[0]]='';                 
        if(isset($a[2])) $arr[$a[0]]= $a[2];//默认值
        if(isset($val[$a[0]])) $arr[$a[0]]= $val[$a[0]];//表的值
      }
      return $arr;
  }

   //扩充 对象转换成数组
   protected function objAddtoArray(&$v,$afieldstr,$tmp) {
        $arr=$this->objtoArray($afieldstr);
        $afieldstmp=explode(',',$afieldstr);
        foreach($afieldstmp as $v1){
          $v[$v1]='';
        }
        if(!empty($tmp)){
          foreach($afieldstmp as $v1){
            if(isset($tmp->{$v1})){
              
            };
          }
        }
    }
   //扩充 对象转换成数组
   public function readValue($w1,$fieldstr,$r='') {
        $tmp=$this->find($w1);
        if($tmp)
        if(isset($tmp->{$fieldstr})){
          $r=$tmp->{$fieldstr};
        };
        return $r;
    }

  public  function gridHead($fs='',$wd='') {
    $s1="";
    set_Session("setDelete",'1');
    $dm=$this->getFields($fs);
    $wds=$this->tdWidth(count($dm),$wd);
    $i=0; 
    foreach($dm as $k)
    {
      $v=$k;
      $d1=explode(":",$k.":");
      $k=$d1[0];
      $s2=$k;
      if($s2<'zzz') $s2=$this->getAttributeLabel($k);
      if(indexOf($v,'%')>0) $wds[$i]=$this->getTdWidth($d1); 
      $s1.='<th '.$wds[$i].' align="center" >'.$s2.'</th>';
      $i++;
    }
    return $s1;
   } 

  public  function getTdWidth($data){
    $rs="";
    foreach($data as $k){ 
      if(indexOf($k,'%')>0){
        $rs=$this->getTdstyle($k);
        break;
       }
    }
    return $rs;
   }

  public  function getTdstyle($wd){
    return "style='text-align: center;width:".$wd.";'";;
   }

  public function tdWidth($n,$wdstr){
    $rs=BaseLib::model()->emptyArray($n);
    if(!empty($wdstr)){
      $data=explode(',',$wdstr);
      foreach($data as $v){
         $ds=explode(':',$v);
         $rs[$ds[0]]=$this->getTdstyle($ds[1]);
      }
    }
    return $rs;
  }
 

  public  function gridRow($fs='',$data=array(),$rows='') {
    $s1="";
    if(!empty($fs)){
      $dm=$this->getFields($fs);
      foreach($dm as $k)
      {   
        $d1=explode(":",$k.":");
        $k=$d1[0];
        $s1.=$this->toTdstr($this->{$k},$rows,$d1[1]);
      }
    }
    if(!empty($data)){
      foreach($data as $k=>$s2)
        { 
          $s1.=$this->toTdstr($s2);
        }
    }   
    return $s1;
   }
/*
 $show_type=pic '图片'，YN=0显示否  1显示是
 */
 public  function toTdstr($s2,$rows='',$show_type='') {
     if((indexof($s2,'uploads/temp')>=0) || ($show_type=='pic')){
         $s2='<img src="'.$s2.'" height="60px" width="60px">';
       }
      if($show_type=='YN'){
         $s2=(empty($s2)) ?'否' : '是';
       } 
       return '<td '.$rows.'>'.$s2.'</td>';
   }

  public  function getFields($r) {
    if(empty($r))  $r=$this->gridLabels();
    return explode(',',$r);
   }

  public  function getcount($w1='1'){
    $tmp=$this->findAll($w1);
    return count($tmp);
   }

  public  function toRec($tmp,$fieldstr){
    return $this->getFrom($tmp,$fieldstr);
   }
//从TMP对象设置值
  public  function getFrom($tmp,$fieldstr){
    $dm=explode(",",$fieldstr);
    foreach($dm as $v)
    {
      $d1=explode(":",$v);
      $s0=$d1[0];$s1=$s0;
      if(isset($d1[1])) 
       if(!empty($d1[1])) $s1=$d1[1];
      if(isset($this->{$s0})&&isset($tmp->{$s1})){
        $v0=$tmp->{$s1};
        if(isset($d1[2])) $v0=$d1[2];
        $this->{$s0}=$v0;
       }
    }
   }
   //从$tmp数组设置值
  public  function setFromArray($tmp,$fieldstr){
    $dm=explode(",",$fieldstr);
    foreach($dm as $v)
    {
      $d1=explode(":",$v);
      $s0=$d1[0];$s1=$s0;
      if(isset($d1[1])) $s1=$d1[1];
      if(isset($this->{$s0}) && isset($tmp[$s1]) ){
        $v0=$tmp[$s1];
        if(isset($d1[2])) $v0=$d1[2];
        $this->{$s0}=$v0;
       }
    }
 }
 

    protected function gListData($condition='1',$key) {  
      return $this->findAll($condition.' order by '.$key);
    }

    protected function gDatas() { 
      $d=$this->keySelect();
      return array($this->gListData($d[0],$d[1]),$d[2]);
    }

    public function downSelect($form,$m,$atts,$onchange='',$noneshow=''){//update
     $data=$this->gDatas();
     return BaseLib::model()->selectByData($form,$m,$atts,$data[0],$data[1]);
    }
   
    public function downSearch($title,$filedname){//index
       $data=$this->gDatas();
       return BaseLib::model()->searchBy($title,$filedname,$data[0],$data[1]);
    }

}
