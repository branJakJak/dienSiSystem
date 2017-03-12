<?php
/**
 * Created by JetBrains PhpStorm.
 * User: EMAXX-A55-FM2
 * Date: 2/16/15
 * Time: 5:40 PM
 * To change this template use File | Settings | File Templates.
 */
class ReloadBlackListMobileCommand extends CConsoleCommand{
    public function actionIndex($fileName)
    {
        Yii::import("application.models.*");
        //get the latest idle cron job
        $dataFolderPath = Yii::getPathOfAlias("application.data");
        $filePath = $dataFolderPath . DIRECTORY_SEPARATOR .$fileName;
        $errorLogFile = $dataFolderPath . DIRECTORY_SEPARATOR  . 'RELOAD-LOG.txt';


        /*check filename availability*/   
        if (file_exists($filePath) && is_file($filePath) ) {
            $contents = file_get_contents($filePath);
            /*read each content of file*/
            $fp = fopen($filePath,"rb");
            while(!feof($fp))
            {
                $currentLine = fgets($fp);
                $currentLine = trim($currentLine);
                $currentLine = "0".$currentLine;

                $newBlacklist = new BlackListedMobile;
                $newBlacklist->mobile_number = $currentLine;

                /*check if current mobile number is valid , 07321654987 */
                /*if valid save to database*/
                if ($newBlacklist->save()) {
                    echo $currentLine .' SAVED!'.PHP_EOL;
                }else{
                    file_put_contents($errorLogFile, "ERROR WITH : $newBlacklist->mobile_number : ERROR MESSAGE : ".implode(":", $newBlacklist->getErrors("mobile_number"))." HAVING value : $newBlacklist->mobile_number".PHP_EOL, FILE_APPEND);
                    // echo "ERROR WITH : $currentLine : ERROR MESSAGE : ".CHtml::errorSummary($newBlacklist).PHP_EOL;
                    echo "ERROR WITH : $newBlacklist->mobile_number : ERROR MESSAGE : ".implode(":", $newBlacklist->getErrors("mobile_number"))." HAVING value : $newBlacklist->mobile_number".PHP_EOL;
                }
            }
        }
        echo PHP_EOL."RELOADING..... DONE \n";
    }
}