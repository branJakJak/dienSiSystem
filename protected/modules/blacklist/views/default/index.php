<?php
/* @var $this DefaultController */
/* @var $model JobQueue */

$model = JobQueue::model();
$model->unsetAttributes();

$this->breadcrumbs = array(
    $this->module->id,
);

$this->breadcrumbs=array(
    ucwords($this->module->id),
    'Job Queues',
);



$this->menu=array(
    array('label'=>'View Uploaded DNC Files', 'url'=>array('/dnc')),
    array('label'=>'List Blacklisted Mobilenumbers <span class="label label-info pull-right">'.number_format(BlackListedMobile::getTotalBlacklistedCount()).'</span>', 'url'=>array('/blacklist/list')),
);



$dataprovider = $model->search();
$dataprovider->pagination = false;


Yii::app()->user->setFlash('sideBarEtc' , $this->renderPartial('sideBar', null , true )   );



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
        'randomQueue': jQuery("#inputRandomQueue").val(),
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
        tempTotalInsertedContainer = tempTotalInsertedContainer + data.numOfInsertedData;
        tempTotalDuplicateFound = tempTotalDuplicateFound + data.numOfDeletedData;

        if (allData.length <= 0) {
            jQuery("button[type='submit']").html("Sending complete");

            jQuery("#afterAjaxUploadMessage").show();

            // summaryMessage = "<strong>Inserted : <small>"+tempTotalInsertedContainer+"</small></strong> <br> <strong> Duplicate : <small>"+tempTotalDuplicateFound+"</small></strong>  ";
            // jQuery("#afterAjaxUploadMessageMessageContainer").html(summaryMessage);

            setPieValue(tempTotalInsertedContainer , tempTotalDuplicateFound);
            setTimeout(function () {
              jQuery("button[type='submit']").html("Submit");
            }, 2000);
        }else{
            jQuery("button[type='submit']").html("<i class='fa fa-spinner fa-spin' style='font-size: 19px;'></i> Sending data... ( "+currentPartition.length+" )  items left");
        }
      },
      complete:function(dt,statasu){
        updateBlackListRecord();
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

function updateBlackListRecord () {
    $.fn.yiiListView.update("yw0",{});
}
EOL;
Yii::app()->clientScript->registerScript('partitionUploadCode', $partitionUploadCode, CClientScript::POS_END);
/*end of code */




/*pie chart*/
$pieChartCode = <<<EOL

function setPieValue(uploaded , duplicates){
    var data = [
                { label: uploaded+" Uploaded record(s)",  data: uploaded, color: "#88bbc8"},
                { label: duplicates+" Duplicate record(s)",  data: duplicates, color: "#ed7a53"}
            ];

    $.plot(
        $(".uploadResult"), 
        data, 
        {
            series: {
                pie: { 
                    show: true,
                    highlight: {
                        opacity: 0.1
                    },
                    stroke: {
                        color: '#fff',
                        width: 3
                    },
                    startAngle: 2,
                    label: {
                        radius:1
                    }
                },
                grow: { active: false}
            },
            legend: { 
                position: "ne", 
                labelBoxBorderColor: null
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            tooltip: true, //activate tooltip
            tooltipOpts: {
                content: "%s : %y.1",
                shifts: {
                    x: -30,
                    y: -50
                }
            }
    });
}//end of function
EOL;
Yii::app()->clientScript->registerScript('pieChartCode', $pieChartCode, CClientScript::POS_END);

/*end of pie chart*/



?>
<div class="row">
    <div class="span9 offset1"> 
        <h1>ADD RECORDS TO DNC</h1>
        <hr>
        <div class="row">
            <div class="alert alert-info">
                <a class="close" data-dismiss="alert">&times;</a>
                <strong>Tip : </strong> Download sample file here <a href="?downloadSampleFile=true">Download</a>
            </div>
            <div class="" id='afterAjaxUploadMessage' style='display: none'>
                <span id="afterAjaxUploadMessageMessageContainer">
                    <div class="">
                        <?php
                            $this->beginWidget('zii.widgets.CPortlet', array(
                                'title'=>'<i class="fa fa-pie-chart"></i> Upload Report ',
                            ));
                        ?>
                            <div class="uploadResult" style="height: 170px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
                        <?php
                            $this->endWidget();
                        ?>
                    </div>

                </span>
            </div>
        </div>
        <div class="row">
            <?php
                $this->widget('bootstrap.widgets.TbAlert', array(
                    'fade'=>true,
                    'closeText'=>'×',
                    'alerts'=>array(
                        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
                        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
                        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
                    ),
                    'htmlOptions'=>array('class'=>'span9')
                ));
            ?>
        </div>
        <?php
            $this->beginWidget( 'CClipWidget', array('id' => 'manualinput' ) ); // start clipping 
        ?>
            <form action="?" method="POST" class='row'>
                <br>
                <div class="span8  offset2">
                    <label for="">Manual Input</label>
                    <input type="hidden" name="randomQueue" id="inputRandomQueue" class="form-control" value="<?php echo uniqid(); ?>">
                    <?php echo CHtml::textArea('massiveTextArea', '', array('style'=>"width: 485px; margin: 0px 0px 9px; height: 199px;")); ?>
                    <hr>
                    <button type="submit" class=" btn btn-primary btn-lg btn-block">Submit</button>
                </div>
            </form>
        <?php
            $this->endWidget(); // stop clipping
        ?>

        <?php
            $this->beginWidget( 'CClipWidget', array( 'id' => 'upload' ) ); // start clipping 
        ?>

            <form action="?" method="POST" enctype="multipart/form-data" class='row'>
                <br>
                <div class="span8  offset2">
                    <label for="">Upload Bulk</label>
                    <input type="file" name="blackListedFile" />
                </div>
                <div class="span8  offset2">
                    <hr>
                    <button type="submit" class=" btn btn-primary btn-lg btn-block">Submit</button>
                </div>
            </form>        
        <?php
            $this->endWidget(); // stop clipping
        ?>

    <?php 
        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                '<i class=\'fa fa-keyboard-o\'></i> Manual Input' => $this->clips['manualinput'],
                '<i class=\'fa fa-upload\'></i> Upload File' => $this->clips['upload'],
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            'htmlOptions'=>array(
                'class'=>'row'
            ),
        ));
    ?>

    </div>
</div>
