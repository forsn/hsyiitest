 <?php  
  $title='人员信息管理';
  $inputCmd='1:3=code,name;age:list(age),gender:list(gender);company,department;edu:list(edu_degree):1:3,position;';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  hsYii_updateData( $this,$model,$inputCmd,$title,$comstr);
 ?>
