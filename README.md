# Simple PHP wrapper for official Prague transport API and RSS feeds

## Instalation

```bash
composer require mistrfilda/pid-api 
```

## Golemio

Currently supports V2 of API - ```https://api.golemio.cz/v2``` - more about api on https://golemioapi.docs.apiary.io/

### Usage

- Obtain access token - https://golemioapi.docs.apiary.io/
- Use new instance of prepared class with endpoints

```php
$golemioService = new \Mistrfilda\Pid\Api\GolemioService('Your access token');
```

#### Supported endpoints with methods:
Each response returns data value object with obtained response. For example, get stops returns [Stop response object](https://github.com/Mistrfilda/pid-api/blob/master/src/Stop/StopResponse.php)
- GTFS stops (https://golemioapi.docs.apiary.io/#reference/public-transport/gtfs-stops/get-all-gtfs-stops) - ```$golemioService->sendGetStopsRequest();```
- GTFS trips (https://golemioapi.docs.apiary.io/#reference/public-transport/gtfs-trips/get-all-gtfs-trips) - ```$golemioService->sendGetStopTripsRequest();```
- GTFS stoptimes (https://golemioapi.docs.apiary.io/#reference/public-transport/gtfs-stops-times/get-gtfs-stop-times) - ```$golemioService->sendGetStopTimesRequest();```
- Vehicle positions (https://golemioapi.docs.apiary.io/#reference/public-transport/vehicle-positions/get-all-vehicle-positions) - ```$golemioService->sendGetVehiclePositionRequest();```

## RSS feeds