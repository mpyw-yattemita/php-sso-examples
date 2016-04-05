#!/bin/sh

cd "$(dirname "$0")"
php -S localhost:8080 & pid=$!
php -S 127.0.0.1:8081
kill $pid
