#!/bin/bash
URL=http://127.0.0.1:8000
USERNAME=test-admin
PW=pass-admin
curl  -c cookiefile  $URL/login_check --data "_username=${USERNAME}&_password=${PW}"

#curl  -b  cookiefile  -H 'Accept:application/json' $URL/api/v1/user
echo create
curl  -v -b  cookiefile --data 'title=Hallo&description=ABC&lon=12.7&lat=9.8&typeId=12'  -H 'Accept:application/json' $URL/api/v1/danger_point/

echo create with json
curl  -v -b  cookiefile --data '{"title":"allo", "description":"xyz", "lon":10, "lat":53, "typeId":12 }' -H 'Accept:application/json' -H 'Content-Type:application/json' $URL/api/v1/danger_point

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
