 <?php  
  $title='议案交办';
  $inputCmd='1:2=title:label,code:label;type:label:1:2,submit_time:label;company_name:label,company_header:list(fcnary);supervision_company:label,proposal_supervisor:list(fcnary);allocation_remark:1:5';
  $comstr='保存:baocun,交办:Supervise/index';//保存的个相关操作，标题:命令
  hsYii_updateData( $this,$model,$inputCmd,$title,$comstr);
 ?>
