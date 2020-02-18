# Simple PHP wrapper for official Prague transport API

Currently supports V2 of API - ```https://api.golemio.cz/v2``` - more about api on https://golemioapi.docs.apiary.io/

## Usage

There is prepared service class, which takes only access token as parameter by default (more info on https://golemioapi.docs.apiary.io/)

```php

$pidService = new \Mistrfilda\Ofce\Pid\Api\PidService('Your access token');

```

Supported endpoints:
- gtfs/stops - ```$pidservice->sendGetStopsRequest();```
- gtfs/trips - ```$pidservice->sendGetStopTripsRequest();```
- gtfs/stoptimes - ```$pidservice->sendGetStopTimesRequest();```
- vehiclepositions - ```$pidservice->sendGetStopTripsRequest();``` 
