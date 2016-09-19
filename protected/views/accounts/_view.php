<?php
$model = Accounts::model();
/* @var $this AccountsController */
/* @var $data Accounts */
/* @var $model Accounts*/
/* @var $recordMdl Records*/

$recordMdl = Records::model();
$recordMdl->account_id = $data->account_id;


$newBaseUrl = Yii::app()->baseUrl;

/*Add style*/
$newStyle = <<<EOL
.site-availability-indicator{
    height: 36px;
    background-color: green;
    float: right;
    width: 36px;
    border-radius: 81px;
    position: relative;
    top: -16px;
    margin-bottom: -31px;
    padding: 6px;
    text-align: center;
    vertical-align: middle;
    height: 35px;
    width: 45px;
    padding: 6px;
    text-align: center;
    vertical-align: middle;
    height: 35px;
    padding-top: 15px;
    width: 45px;
    margin: 10px;
    color: white;
}
.site-online{
  background-color: green;
}
.site-offline{
  background-color: red;
}
EOL;
Yii::app()->clientScript->registerCss("circle-ness", $newStyle);



    /*Check class */
    $sc = new ServerCheck($data->websiteURL);
    if ($sc->getServerStatus() === "OFFLINE") {
      $classname = "site-offline";
      //report to sir about the incident
        $mailer = new YiiMailer;
        $mailer->setView('contact');
        $mailer->setData(array(
             "websiteURL"     => $data->websiteURL,
             "accountName" => $data->claimAccountName,
             "description" => "We cant seem to ping these website please double check these website.",
        ));
        $mailer->setFrom("claimsdatastorage@ezfastloans4u.com");
        $mailer->setTo("hellsing357@gmail.com");
        $mailer->setSubject(" {$data->claimAccountName}- Went Down");
        $mailer->send();
    }else{

    }
    $applicationStatus = ($data->application_status == Accounts::OK) ? "site-online":"site-offline";
    $dataBaseApplication = ($data->database_status == Accounts::OK) ? "site-online":"site-offline";
?>


<div class="view span4">

    <h3 class="pull-left" style="display: inline-block;width: 215px;">
	<?php if($data->websiteURL == "whatsmyclaimworth.in"):?>
		<a href="#" onclick='return false;' >
			<?php echo CHtml::encode($data->claimAccountName);?>
		</a>
	<?php endif ?>
	<?php if($data->websiteURL !== "whatsmyclaimworth.in"): 
?>
	        <a href="http://<?php echo $data->websiteURL?>" target="_blank"><?php echo CHtml::encode($data->claimAccountName)?></a>
	<?php endif; ?>
    </h3>

    <div class="site-availability-indicator  <?php echo $applicationStatus ?>" style="">
        <i class="fa fa-desktop" style="font-size: 26px;"></i>
    </div>

    <div class="site-availability-indicator  <?php echo $dataBaseApplication ?>" style="">
        <i class="fa fa-database" style="font-size: 26px;"></i>
    </div>
  <table class='table table-bordered'>
      <tr>
        <td>Submitted Today</td>
        <td>
          <p class='totalNumofEntriesToday'>
            <?php echo $recordMdl->getTotalNumberOfEntriesToday(); ?>
          </p>
        </td>
      </tr>
      <tr>
        <td>Total This Week</td>
        <td>
            <p class='totalEntriesThisWeek'>
              <?php echo $recordMdl->getThisWeekreport(); ?>
            </p>
        </td>
      </tr>
      <tr>
        <td>
          Total Entries
        </td>
        <td class='totalNumberOfEntries'>
          <?php echo $recordMdl->getTotalNumberOfEntries(); ?>
        </td>
      </tr>
  </table>



  <div class="pull-left hidden">
    <a data-accountid="<?php echo $data->account_id ?>" class="btn liveStatsModalButton" data-toggle="modal" href="#liveStatsModal">
      <i class='icon icon-user'></i>
      Visitor Stats
    </a>
  </div>
  <div class="btn-group pull-left" style="clear:left;margin-top: 10px;">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">
        <div class="btn btn-small">
           <i class='icon-download-alt'></i> Export Claims
          <b class="caret"></b>
        </div>
    </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo $newBaseUrl;?>/export/exportAll?accountID=<?php echo $data->account_id ?>">All</a></li>
        <li><a href="<?php echo $newBaseUrl;?>/export/exportWeek?accountID=<?php echo $data->account_id ?>">This Week</a></li>
        <li><a href="<?php echo $newBaseUrl;?>/export/exportToday?accountID=<?php echo $data->account_id ?>">Today</a></li>
        <li><a data-accountid="<?php echo $data->account_id ?>" class='rangeButton' class="" data-toggle="modal" href="#myModal">Range</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo $newBaseUrl;?>/export/mobile?accountID=<?php echo $data->account_id ?>"> <i class="fa fa-mobile"></i> Mobile #</a></li>
    </ul>
  </div>  

  <div class=" pull-right">
      <a class="btn settingsButton" data-toggle="modal" href="#settingsModal" data-accountid="<?php echo $data->account_id ?>">
        <i class='icon  icon-wrench'></i>
      </a>
  </div>

</div>



