 <?php  
  $title='议案处理跟进';
  $inputCmd='1:3=title:label:1:7;code:label,type:label;company_header:label,proposal_supervisor;proposal_action:html:1:7;proposal_update:date:1:7';
  $comstr='保存:baocun';//保存的个相关操作，标题:命令
  hsYii_updateData( $this,$model,$inputCmd,$title,$comstr);
 ?>