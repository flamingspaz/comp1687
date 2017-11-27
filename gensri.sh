openssl dgst -sha384 -binary api/static/js/maps-handler.js | openssl base64 -A
echo "\n"
openssl dgst -sha384 -binary api/static/js/eu_cookie_banner.js | openssl base64 -A
