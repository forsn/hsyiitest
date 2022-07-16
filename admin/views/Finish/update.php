 <?php  
  $title='议案结案';
  $inputCmd='1:3=title:label,code:label;type:label,company_name:label;department_point:list(yn):1:7;department_remark:1:7;';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  hsYii_updateData( $this,$model,$inputCmd,$title,$comstr);
 ?>
