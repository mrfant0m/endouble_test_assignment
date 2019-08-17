Steps to setup application:

1) Clone repository:

git clone https://github.com/mrfant0m/endouble_test_assignment.git

2) Loading composer repositories:
 
composer install

3) Run symfony local web server:

bin/console server:start

 [OK] Server listening on http://127.0.0.1:8000         
 
4) possible to do console tests with curl.

curl -X POST -H "Content-Type: application/json" -d '{"sourceId":"space","year":2013,"limit":2}'  http://127.0.0.1:8000/

curl -X POST -H "Content-Type: application/json" -d '{"sourceId":"space","year":2017,"limit":3}'  http://127.0.0.1:8000/

curl -X POST -H "Content-Type: application/json" -d '{"sourceId":"comics","year":2015,"limit":2}'  http://127.0.0.1:8000/                                                                


Description:
I was thinking of making a smart request algorithm for data from the comics API, but then I decided to use cache for all data.
The first request for each source will put all articles in to cache.  
Then all requests for this source api you can get from filesystem cache adapter without any request to source API.

1) To add new source api: You need just create one independent api request component which will collect all data from new source API.
2) I think there is a problem with provided requests\response:
Request number 3 have json sourceId = comics, but response was provided from space API. 