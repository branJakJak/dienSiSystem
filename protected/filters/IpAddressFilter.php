<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 5/11/15
 * Time: 10:17 PM
 * To change this template use File | Settings | File Templates.
 */

class IpAddressFilter extends CFilter{

    protected function preFilter($filterChain)
    {
        $isValid = true;
        //if localhost , skip this checking
        $localhostIp = array(
            '127.0.0.1',
            '::1'
        );
        if(in_array($_SERVER['REMOTE_ADDR'], $localhostIp)){
            $isValid = true;
        }else{
            $criteriaSettings = new CDbCriteria();
            $criteriaSettings->compare("setting_key", "enabled");
            $criteriaSettings->compare("setting_value", "true");
            $ipBlockFeatureisEnabled  = Settings::model()->exists($criteriaSettings);
            $ipAddress = Yii::app()->request->getUserHostAddress();
            $criteria = new CDbCriteria;
            $criteria->compare("ip_address", $ipAddress);
            $ipExists = Ip::model()->exists($criteria);
            if ( !$ipExists && $ipBlockFeatureisEnabled) {
                throw new CHttpException(403, "You are unauthorized to access this site");
                $isValid = true;         
            }
        }
        return $isValid;
    }




}