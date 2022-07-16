<?php
  $title='议案详情';  
  //$title=array('议案详情','刷新');
  $inputCmd='1:2=title:label,workstate:label;code:label,type:label;author:label,submit_time:label;company_name:label,company_header:label;supervision_company:label,proposal_supervisor:label;content:1:5:label;proposal_time:1:5:label;allocation_remark:1:5:label;';
  $comstr='取消';//保存的个相关操作，标题:命令
  hsYii_updateData( $this,$model,$inputCmd,$title,$comstr);

  // type:1:1::list(party)
 ?>    

 