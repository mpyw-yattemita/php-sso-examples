#!/bin/sh

cd "$(dirname "$0")"
php -S localhost:8085 & pid=$!
php -S localhost:8086
kill $pid
