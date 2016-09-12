<?php
/* @var $this AccountsController */
/* @var $dataProvider CActiveDataProvider */

$isInternetExlporer = false;
if (preg_match('/(?i)msie [1-8]/', $_SERVER['HTTP_USER_AGENT'])) {
    $isInternetExlporer = true;
}


$mondayDt = date("Y-m-d H:i:s", strtotime("monday this week"));
$tuesdayDt = date("Y-m-d H:i:s", strtotime("tuesday this week"));
$wednesdayDt = date("Y-m-d H:i:s", strtotime("wednesday this week"));
$thursdayDt = date("Y-m-d H:i:s", strtotime("thursday this week"));
$fridayDt = date("Y-m-d H:i:s", strtotime("friday this week"));
$saturdayDt = date("Y-m-d H:i:s", strtotime("saturday this week"));
$sundayDt = date("Y-m-d H:i:s", strtotime("sunday this week"));


/* Week count */
$mondayCount = BlackListedMobile::getSubmittedBlackListedMobileCount($mondayDt);
$tuesdayCount = BlackListedMobile::getSubmittedBlackListedMobileCount($tuesdayDt);
$wednesdayCount = BlackListedMobile::getSubmittedBlackListedMobileCount($wednesdayDt);
$thursdayCount = BlackListedMobile::getSubmittedBlackListedMobileCount($thursdayDt);
$fridayCount = BlackListedMobile::getSubmittedBlackListedMobileCount($fridayDt);
$saturdayCount = BlackListedMobile::getSubmittedBlackListedMobileCount($saturdayDt);
$sundayCount = BlackListedMobile::getSubmittedBlackListedMobileCount($sundayDt);

$totalBlackListedCount = 0;
$totalBlackListedCount += intval($mondayCount);
$totalBlackListedCount += intval($tuesdayCount);
$totalBlackListedCount += intval($wednesdayCount);
$totalBlackListedCount += intval($thursdayCount);
$totalBlackListedCount += intval($fridayCount);
$totalBlackListedCount += intval($saturdayCount);
$totalBlackListedCount += intval($sundayCount);

?>
<style type="text/css">
    .total-black-listed-count-label {
        border-radius: 5px;
        text-align: center;
        background-color: #f3f3f3;
        -moz-box-shadow: 0 0 6px 2px #b0b2ab;
        -webkit-box-shadow: 0 0 6px 2px #b0b2ab;
        box-shadow: 0 0 6px 2px #b0b2ab;
        margin: 30px;
        padding: 12px 0px;
    }

    .total-black-listed-count-label h3 {
        margin: 0px;
        padding-top: 13px;
    }

    .total-black-listed-count-label hr {
        margin-top: 0px;
    }

    .total-black-listed-count-label strong {
        font-size: 47px;
    }
</style>

<div class="row-fluid">


    <div class="offset1 span6">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => '<i class="fa fa-cut"></i> DNC module',
        ));
        ?>
        <div class="summary">
            <ul>
                <li style="margin: 25px 0px;">
          		<span class="summary-icon">
          			<h2 style="margin-top: 1px;margin-left: 6px;">
                        <i class="fa fa-plus"></i>
                    </h2>
                </span>
                    <a href="<?php echo $this->createUrl('/blacklist/default') ?>">
                        <span class="summary-number">Add DNC</span>
                        <span class="summary-title"> Add records to DNC</span>
                    </a>
                </li>
                <li style="margin: 35px 0px;">
            	<span class="summary-icon">
          			<h2 style="margin-top: 0px;margin-left: 4px;">
                        <i class="fa fa-cut"></i>
                    </h2>
                </span>
                    <a href="<?php echo $this->createUrl('/whitelist/default') ?>">
	                <span class="summary-number">
	                	De-dupe Records
	                </span>
                        <span class="summary-title">De duplicate records againts DNC record</span>
                    </a>
                </li>
            </ul>
        </div>
        <?php
        $this->endWidget();
        ?>
    </div>
    <div class="span3">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => 'Export DNC',
        ));
        ?>

        <div class="summary">
            <ul>
                <li style="margin: 25px 0px;">
          		<span class="summary-icon">
          			<h2 style="margin-top: 1px;margin-left: 6px;">
                        <i class="fa fa-download"></i>
                    </h2>
                </span>
                    <a href="<?php echo $this->createUrl('/blacklist/exportAll') ?>">
                        <span class="summary-number">Export DNC</span>
                        <span class="summary-title">Exports all DNC Record</span>
                    </a>
                </li>
            </ul>
        </div>



        <?php
        $this->endWidget();
        ?>
    </div>

</div>
</div>

<hr>

<!-- end of middle panel -->


<!-- Chart Panel -->
<div class="row">
    <div class="span11 offset1">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => 'Blacklisted Mobile Submittion over Weekend',
        ));
        ?>
        <div class="">
            <div class="span4">
                <div class='total-black-listed-count-label'>
                    <h3>
                        This Week's Submittion
                    </h3>
                    <hr>
                    <strong>
                        <?php echo number_format($totalBlackListedCount) ?>
                    </strong>
                </div>
            </div>
        </div>
        <hr>

        <?php
        $this->widget(
            'yiiwheels.widgets.highcharts.WhHighCharts',
            array(
                'pluginOptions' => array(
                    "chart" => array(
                        "type" => "column"
                    ),
                    'title' => array('text' => 'Weekly Report on Submitted Blacklist Mobile'),
                    'xAxis' => array(
                        // 'categories' => array('Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday','Sunday')
                        'categories' => array('Submitted')
                    ),
                    'yAxis' => array(
                        'title' => array('text' => 'Number of Submittion')
                    ),
                    'series' => array(
                        array('name' => 'Monday', 'data' => array(intval($mondayCount))),
                        array('name' => 'Tuesday', 'data' => array(intval($tuesdayCount))),
                        array('name' => 'Wednesday', 'data' => array(intval($wednesdayCount))),
                        array('name' => 'Thursday', 'data' => array(intval($thursdayCount))),
                        array('name' => 'Friday', 'data' => array(intval($fridayCount))),
                        array('name' => 'Saturday', 'data' => array(intval($saturdayCount))),
                        array('name' => 'Sunday', 'data' => array(intval($sundayCount)))
                    )
                )
            )
        );
        ?>
        <?php
        $this->endWidget();
        ?>
    </div>
</div>
<!-- END of Chart Panel -->


<!-- SEARCH submitted today Blacklisted Mobile -->
<div class="row">
    <div class="span11 offset1">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => 'Search Blacklisted Mobile Submittion over Weekend',
        ));
        ?>
        <div class="">
            <?php

//            $this->widget('zii.widgets.grid.CGridView', array(
//                'dataProvider' => $dataProvider,
//            ));

            $this->widget('yiiwheels.widgets.grid.WhGridView', array(
                "id"=>"jkasdjkasd",
                "ajaxUpdate"=>false,
                'fixedHeader' => true,
                'headerOffset' => 40, // 40px is the height of the main navigation at bootstrap
                'type' => 'striped bordered',
                'dataProvider' => $model->thisWeekSubmittion(),
                'filter'=>$model,
                'template' => "{summary}\n{items}\n{pager}\n{summary}",
                'columns' => array(
                    array('name' => 'rec_id', 'header' => '#'),
                    array('name' => 'mobile_number', 'header' => 'Mobile Number'),
                    array('name' => 'date_created', 'header' => 'Date Submitted'),
//                    array(
//                        'class' => 'bootstrap.widgets.TbButtonColumn',
//                        'htmlOptions' => array('style' => 'width: 50px'),
//                    ),
                ),
            ));

            ?>
        </div>
        <?php
        $this->endWidget();
        ?>
    </div>
</div>
<!-- END of Submitted today BLACKLISTED -->


