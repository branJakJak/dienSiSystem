<?php
$totalDncRecords = BlackListedMobile::model()->count();
?>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- Be sure to leave the brand out there if you want it shown -->
            <a class="brand" href="/"><?php echo Yii::app()->name ?></a>

            <div class="nav-collapse">
                <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'htmlOptions' => array('class' => 'pull-right nav'),
                        'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                        'itemCssClass' => 'item-test',
                        'encodeLabel' => false,
                        'items' => array(
                            array('label'=>'Dashboard','url'=>array('/site/index'), 'visible' => Yii::app()->user->getId() === 'administrator'  ),
			    array('label'=>'DNC Records '.'<span class="label label-info">'.$totalDncRecords.'</span>' , 'url'=>array('/blackListedMobile/admin') , 'visible'=>Yii::app()->user->getId() === 'administrator'  ),
                            array('label'=>'Client Portal','url'=>array('/client_portal/default'), 'visible' => !Yii::app()->user->isGuest ),
    			            array('label'=>'De-dup Records '.'<span class="label label-success">'.WhitelistJobQueue::model()->count().'</span>','url'=>array('/de-dupe') , 'visible' => Yii::app()->user->getId() === 'administrator'),
                            array('label' => 'IP Firewall', 'url' => "http://ip.dncsystem.website/", 'visible' => Yii::app()->user->getId() === 'administrator'),
                            array('label' => 'Message board', 'url' => array('/messageBoard/updateStatus'), 'visible' => Yii::app()->user->getId() === 'administrator'),
                            array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                            array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                    ));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <?php if (  false   ): ?>
            <?php //if (  MessageBoard::isUnderConstruction()   ): ?>
                <h3 style="color: red;">
                    <i class="fa fa-asterisk"></i>
                    <?php echo MessageBoard::model()->find()->messageStatus ?>
                    <small>
                        <?php echo MessageBoard::model()->find()->fullMessage ?>
                    </small>
                </h3>
            <?php endif ?>

        </div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->
