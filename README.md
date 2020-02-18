# Simple PHP wrapper for official Prague transport API

Currently supports V2 of API - ```https://api.golemio.cz/v2``` - more about api on https://golemioapi.docs.apiary.io/

## Usage

- Obtain access token - https://golemioapi.docs.apiary.io/
- Use new instance of prepared class with endpoints

```php
$pidService = new \Mistrfilda\Ofce\Pid\Api\PidService('Your access token');
```

Supported endpoints with methods:
- gtfs/stops - ```$pidservice->sendGetStopsRequest();```
- gtfs/trips - ```$pidservice->sendGetStopTripsRequest();```
- gtfs/stoptimes - ```$pidservice->sendGetStopTimesRequest();```
- vehiclepositions - ```$pidservice->sendGetStopTripsRequest();``` 
