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
        $verdict = true;
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
            $verdict = false;
        }
        return $verdict;
    }




}