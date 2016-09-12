<?php
/* @var $this DefaultController */
/* @var $model JobQueue */

$model = JobQueue::model();
$model->unsetAttributes();

$this->breadcrumbs = array(
    $this->module->id,
);

$this->breadcrumbs = array(
    ucwords($this->module->id),
    'Job Queues',
);







/*register submit event listener*/
$registerSubmitListener = <<<EOL
jQuery("form:first").submit(function(event) {
    if (  $("#massiveTextArea").val().length > 0 ) {
        submitPartition()
        event.preventDefault();
        return false;
    }
});
EOL;
Yii::app()->clientScript->registerScript('registerSubmitListener', $registerSubmitListener, CClientScript::POS_READY);
/*end of register submit*/

/*begin partition upload of from texterea*/
$partitionUploadCode = <<<EOL
var tempTotalInsertedContainer = 0;
var tempTotalDuplicateFound = 0;
/**
 * Todo attach this before submit . make sure to change submit text 
 * @return 
 */
function submitPartition() {
    // check if multiline has data 
    if (jQuery("#massiveTextArea").val().length > 0) {
        // if has data retrieve it and send data to current url , 50 000  per transaction 
        allData = jQuery("#massiveTextArea").val().split("\\n");
        sendPartitionToServer(allData);
    }
}
/*end of function*/

function sendPartitionToServer (currentPartition) {
    if (currentPartition.length <= 0) {
        return false;
    }
    dataToBeSent = currentPartition.splice(0,20000);
    jQuery.ajax({
      url: window.location.href,
      type: 'POST',
      async:true,
      data: {
        'copyPasteFileName': jQuery("#copyPasteFileNameField").val(),
        'massiveTextArea': dataToBeSent.join("\\r\\n")
      },
      beforeSend:function(){
        if (currentPartition.length  > 0 ) {
            jQuery("button[type='submit']").html("<i class='fa fa-spinner fa-spin' style='font-size: 19px;'></i> Sending data... ( "+currentPartition.length+" )  items left");
        }
      },
      success: function(data, textStatus, xhr) {
        //called when successful
        console.log("data sent successfully");
        // tempTotalInsertedContainer = tempTotalInsertedContainer + data.numOfInsertedData;
        // tempTotalDuplicateFound = tempTotalDuplicateFound + data.numOfDeletedData;

        if (currentPartition.length <= 0) {
            jQuery("button[type='submit']").html("Sending complete");

            // jQuery("#afterAjaxUploadMessage").show();

            // summaryMessage = "<strong>Inserted : <small>"+tempTotalInsertedContainer+"</small></strong> <br> <strong> Duplicate : <small>"+tempTotalDuplicateFound+"</small></strong>  ";
            // jQuery("#afterAjaxUploadMessageMessageContainer").html(summaryMessage);

            
            setTimeout(function () {
              jQuery("button[type='submit']").html("Submit");
            }, 2000);
        }else{
            jQuery("button[type='submit']").html("<i class='fa fa-spinner fa-spin' style='font-size: 19px;'></i> Sending data... ( "+currentPartition.length+" )  items left");
        }
      },
      complete:function(dt,statasu){
        updateWhitelistRecord();
        sendPartitionToServer(currentPartition);
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
        console.error(xhr);
        console.error(textStatus);
        console.error(errorThrown);
      }
    });
  return true;
}

function updateWhitelistRecord () {
    $.fn.yiiListView.update("whitelistMobileList",{});
}
EOL;
Yii::app()->clientScript->registerScript('partitionUploadCode', $partitionUploadCode, CClientScript::POS_END);
/*end of code */










?>
<style type="text/css">
div.items {
      margin: 5px 13px;
}
</style>



<div class="row">
    <div class="span10" style='margin-left: 26px;'>



        <?php
            $this->widget('bootstrap.widgets.TbAlert', array(
                'fade' => true,
                'closeText' => '×',
                'alerts' => array(
                    'success' => array('block' => true, 'fade' => true, 'closeText' => '×'),
                    'error' => array('block' => true, 'fade' => true, 'closeText' => '×'),
                ),
                'htmlOptions' => array('class' => 'span7')
            ));
        ?>
    </div>

    <div class="span10">


        <?php $this->beginClip('copyPaste')?>
            <div class="" id='afterAjaxUploadMessage' style='display: none'>
                <span id="afterAjaxUploadMessageMessageContainer">
                    <div class="">
                        <?php
                            $this->beginWidget('zii.widgets.CPortlet', array(
                                'title'=>'<i class="fa fa-pie-chart"></i> Upload Report ',
                            ));
                        ?>
                            <div class="uploadResult" style="height: ;width:100%;margin-top:15px; margin-bottom:15px;"></div>
                        <?php
                            $this->endWidget();
                        ?>
                    </div>
                </span>
            </div>

            <h2>DE-Dupe Against DNC</h2>
            <hr>
            <form action="?" method="POST">
                Filename : 
                <input type="text" name="copyPasteFileName" id="copyPasteFileNameField" class="form-control" value=""  required='required' title="" placeholder=''>
                <div class="">
                    <label for="">Mobile number</label>
                    <textarea style="width: 95%; margin: 0px 0px 9px; height: 199px;" name="massiveTextArea"
                              id="massiveTextArea"></textarea>
                    <hr>
                    <button type="submit" class=" btn btn-primary btn-lg btn-block">Submit</button>
                </div>
            </form>
        <?php $this->endClip()?>
        <!-- copy paste -->



        <?php $this->beginClip('upload')?>
            <form action="?" method="POST" enctype="multipart/form-data" >
                <br>
                <div>
                    <div class="">
                        <label for="">Upload Bulk</label>
                        <input type="file" name="dncFile" />
                    </div>
                </div>
                <div>
                    <div>
                        <hr>
                        <button type="submit" class=" btn btn-primary btn-lg btn-block">Upload</button>
                    </div>
                </div>
            </form>
        <?php $this->endClip()?>
        <!-- end of upload -->

        <?php
            $this->widget('zii.widgets.jui.CJuiTabs',array(
                'tabs'=>array(
                    // '<i class="fa fa-copy"></i> Copy/Paste '=>$this->clips['copyPaste'],
                    '<i class=\'fa fa-copy\'></i>Copy/Paste '=>$this->clips['copyPaste'],
                    // '<i class="fa fa-upload"></i> Upload'=>$this->clips['upload'],
                    '<i class=\'fa fa-upload\'></i>Upload'=>$this->clips['upload'],
                ),
                'options'=>array(
                    'collapsible'=>true,
                ),
            ));
        ?>
 


    </div>
</div>


