#!/usr/bin/env bash

rm build.zip

cd package
zip -q -r ../build.zip .

cd ..
zip -q -g build.zip main.py
