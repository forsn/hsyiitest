<?php 
   $title=array('','议案处理跟进','刷新');
   $schcmd='议案=PC:list(Supervise),关键字=keyword';
   $coumnName='code,title,type,proposal_time,company_name,supervision_company,proposal_update';
   $hw='';//0:5%,1:5%,2:5%,3:5%,4:10%,5:30%,6:5%,6:20%,6:5%';//每列的宽度
   $index=0;//是否显示序号 0 不显示  1 显示//html_entity_decode
   $idName='id';//关键字的属性名称//
   //cmd=内部名称：动作：图片：标题
   $cmd='编辑:update::编辑,详情:Supervise/preview::详情';//,题目:PisaExamsData/index::题目';//操作的命令
   $data=array($index,$idName,$coumnName,$hw,$cmd);
   hsYii_indexShow($this,$model, $title,$schcmd,$data,$arclist,$pages); 
?>
<script>
    function preview(id) {
        $.dialog.open('<?php echo $this->createUrl("Supervise/preview"); ?>&id=' + id, {
            id: 'id',
            lock: true,
            opacity: 0.3,
            title: '预览',
            width: '70%',
            height: '100%',
            close: function() {we.reload();}
        });
    }
</script> 