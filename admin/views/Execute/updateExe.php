 <?php
  //$title='议案交办';
  $title=array('议案交办','返回:indexExe');
  //$title=array('','议案交办','刷新,返回:indexExe');
  $inputCmd='1:2=title:label,code:label;type:label:1:2,submit_time:label;company_name:label,company_header:list(fcnary);supervision_company:label,proposal_supervisor:list(fcnary);allocation_remark:1:5';//,'暂时离开:index'
  //$comstr='保存:baocun,交办完成并继续:updateExe';//保存的个相关操作，标题:命令
  $comstr=array('保存:baocun,交办完成并继续:updateExe','取消:indexExe');
  hsYii_updateData( $this,$model,$inputCmd,$title,$comstr);
 ?>