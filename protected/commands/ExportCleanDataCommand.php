<?php



/**
* ExportCleanData
*/
class ExportCleanDataCommand  extends CConsoleCommand
{
    /**
     * Export the cleaned data into a file
     * @param  string $exportFileLocation The location of export file
     * @param  string $queue_id           Id of queue to export.
     * @return string                     The path to file containing the cleaned data
     */
	public function actionIndex($exportFileLocation=null ,$queue_id = null)
	{
		echo "Export is about to start \n";
		Yii::import('application.models.*');
		Yii::import('application.modules.dnc.components.*');
		if (is_null($exportFileLocation)) {
			echo "Export file location is required \n";
			die();
		}
		if (is_null($queue_id)) {
			echo "Queue id of whitelist queue is required";
			die();
		}
		//get path of alias application.data
		$exportFileLocation = Yii::getPathOfAlias("application.data").'/'.$exportFileLocation;
		$fileRes = fopen($exportFileLocation, "w+");
		fclose($fileRes);
		echo "Starting any moment now \n";
		$cleanedData = DncUtilities::exportCleanToFile($exportFileLocation , $queue_id);
		echo "Process started \n";
		echo "Exitting \n";
	}

}