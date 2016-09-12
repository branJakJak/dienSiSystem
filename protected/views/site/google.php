<?php 
  Yii::app()->clientScript->registerScriptFile('http://www.google.com/jsapi', CClientScript::POS_HEAD);
  Yii::app()->clientScript->registerScriptFile('/js/gadash-1.0.js', CClientScript::POS_HEAD);
  Yii::app()->clientScript->registerScriptFile('http://apis.google.com/js/client.js?onload=gadashInit', CClientScript::POS_HEAD);

?>
  <!-- Add Google Analytics authorization button -->
  <button id="authorize-button" style="visibility: hidden">
        Authorize Analytics</button>

  <!-- Div element where the Line Chart will be placed -->
  <div id='line-chart-example'></div>

  <!-- Load all Google JS libraries -->
  <script>
    // Configure these parameters before you start.
    var API_KEY = 'b6-e0hPFNDVYGzf9PrwwUKCT';
    var CLIENT_ID = '201152460993-v139hrccrim6o4segssqle44s0afs52t.apps.googleusercontent.com';
    var TABLE_ID = 'ga:53649953';
    // Format of table ID is ga:xxx where xxx is the profile ID.

    gadash.configKeys({
      'apiKey': API_KEY,
      'clientId': CLIENT_ID
    });

    // Create a new Chart that queries visitors for the last 30 days and plots
    // visualizes in a line chart.
    var chart1 = new gadash.Chart({
      'type': 'LineChart',
      'divContainer': 'line-chart-example',
      'last-n-days':30,
      'query': {
        'ids': TABLE_ID,
        'metrics': 'ga:visitors',
        'dimensions': 'ga:date'
      },
      'chartOptions': {
        height:600,
        title: 'Visits in January 2011',
        hAxis: {title:'Date'},
        vAxis: {title:'Visits'},
        curveType: 'function'
      }
    }).render();
  </script>
