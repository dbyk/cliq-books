#!/bin/bash

docker-compose -f docker-compose.yml -f docker-compose-k6.yml run --rm -T k6 run -e BASE_URL='http://php:8080/api' /tests/tests.js