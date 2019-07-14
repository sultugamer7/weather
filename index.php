<!doctype html>
<html>
<head>
<title>Forecast Weather using OpenWeatherMap with PHP</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style>
.report-container {
    border: #E0E0E0 1px solid;
    padding: 20px 40px 40px 40px;
    border-radius: 2px;
    width: 550px;
    margin: 0 auto;
}

.weather-icon {
    vertical-align: middle;
    margin-left: -10px;
}

.weather-forecast {
    color: #212121;
    font-size: 1.2em;
    font-weight: bold;
    margin: 20px 0px;
}

span.min-temperature {
    margin-left: 15px;
    color: #929292;
}

.time {
    line-height: 25px;
}
</style>

</head>
    <body style="background: black;">
        <div class="container">
            <div class="row" style="padding-top: 50px;">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <span class="align-middle">
                        <form method="post" action="index.php" class="form-group">
                            <input type="text" autocomplete="off" name="cityName" id="cityName" placeholder="Town/City Name..." class="form-control-lg" style="width: 100%;">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4" style="margin-top: 14.2px;">
                                    <input type="submit" name="getWeather" value="Get Weather" class="btn btn-danger btn-lg">
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            
                        </form>
                    </span>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </body>
</html>

<?php
    if(isset($_POST['getWeather'])){
        $apiKey = "6fa0c449c57a3989b2272ef364daba68";
        $cityName = $_POST['cityName'];
        $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . $cityName . "&lang=en&units=metric&APPID=" . $apiKey;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);
        $data = json_decode($response);
        $currentTime = time();
        echo '
            <div class="container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
            ';
            if(isset($data->name)){
                echo '
                    <div class="jumbotron" style="background: cornsilk;">
                        <h2>'.$data->name.'\'s Weather :</h2>

                        <div style="color: crimson; margin-bottom: -10px; font-family: -webkit-body; margin-left: -2px;">
                            <h3>
                                <b>Temperature :</b> '.$data->main->temp.'&deg;C
                                <img src="http://openweathermap.org/img/w/'.$data->weather[0]->icon.'.png"
                                    class="weather-icon" />
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div><b>Day :</b></div>
                                <div><b>Date :</b></div>
                                <div><b>Weather description :</b></div>
                                <div><b>Humidity :</b></div>
                                <div><b>Wind :</b></div>
                            </div>
                            <div class="col-md-6">
                                <div>'.date("l", $currentTime).'</div>
                                <div>'.date("jS F, Y",$currentTime).'</div>
                                <div>'.ucwords($data->weather[0]->description).'</div>
                                <div>'.$data->main->humidity.' %</div>
                                <div>'.$data->wind->speed.' km/h</div>
                            </div>
                        </div>
                        
                    </div>
                ';
            }else{
                echo '
                    <div class="jumbotron" style="background: cornsilk;">
                        <h4>Invalid Town/City Name!!!</h4>
                    </div>
                ';
            }
                        
            echo '
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        ';
    }
?>