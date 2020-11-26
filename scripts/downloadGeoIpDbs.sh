#!/usr/bin/env bash

if [[ ! ":$PWD:" == *"/scripts"* ]]; then
    cd ./scripts
fi

curl -s -o "GeoLite2-ASN.tar.gz" "https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-ASN&license_key=Y8lebp6EG7Iifbmj&suffix=tar.gz"
curl -s -o "GeoLite2-City.tar.gz" "https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=Y8lebp6EG7Iifbmj&suffix=tar.gz"
curl -s -o "GeoLite2-Country.tar.gz" "https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-Country&license_key=Y8lebp6EG7Iifbmj&suffix=tar.gz"

ls Geo*.tar.gz | xargs -n1 tar -xzf
cp ./GeoLite*/*.mmdb ./../data/geoip/ && rm -rf ./Geo*

if [ ! -f ./../data/geoip/GeoLite2-ASN.mmdb ] || [ ! -f ./../data/geoip/GeoLite2-City.mmdb ] || [ ! -f ./../data/geoip/GeoLite2-Country.mmdb ]; then
    echo "Failed to download all GeoIp files!"
    exit 1;
else
    echo "Successfully downloaded GeoIP files"
    exit 0;
fi
