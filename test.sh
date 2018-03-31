#!/bin/bash
URL=http://127.0.0.1:8000
curl  -c cookiefile  $URL/login_check --data '_username=test-admin&_password=pass-admin'
#curl 'http://127.0.0.1:8000/login_check' -H 'Pragma: no-cache' -H 'Origin: http://127.0.0.1:8000' -H 'Accept-Encoding: gzip, deflate, br' -H 'X-CookiesOK: I explicitly accept all cookies' -H 'Accept-Language: de-DE,de;q=0.9,en-US;q=0.8,en;q=0.7' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.167 Safari/537.36' -H 'Content-Type: application/x-www-form-urlencoded' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8' -H 'Cache-Control: no-cache' -H 'Referer: http://127.0.0.1:8000/login' -H 'Cookie: PHPSESSID=n2ds4rb8i8aq160e2h94ne2h90' -H 'Connection: keep-alive' --data '_csrf_token=AMZS32bTGsEA_FsKlrBl3POiCy99YElONOR60ce6W6I&_username=sven&_password=blub1234&_submit=security.login.submit' --compressed ;


#curl  -b  cookiefile  -H 'Accept:application/json' $URL/api/v1/user
echo create
curl  -v -b  cookiefile --data 'title=Hallo&description=ABC&lon=12.7&lat=9.8&typeId=12'  -H 'Accept:application/json' $URL/api/v1/danger_point/
echo ''
echo entry 3:
curl  -b  cookiefile  -H 'Accept:application/json' $URL/api/v1/danger_point/3
echo ''
echo put entry 3:
curl  -b  cookiefile   -X PUT --data "title=XYZ$$" -H 'Accept:application/json' $URL/api/v1/danger_point/3
echo ''
echo entry 3:
curl  -b  cookiefile  -H 'Accept:application/json' $URL/api/v1/danger_point/3
echo ''
echo list
curl  -b  cookiefile  -H 'Accept:application/json' $URL/api/v1/danger_point
echo ''
echo delete 4
curl  -b  cookiefile -X DELETE -H 'Accept:application/json' $URL/api/v1/danger_point/4
curl  -b  cookiefile  -H 'Accept:application/json' $URL/logout >/dev/null

rm cookiefile
#curl  -b  cookiefile  -H 'Accept:application/json' $URL/api/v1/user
