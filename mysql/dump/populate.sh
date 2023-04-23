#!/usr/bin/env bash

mysql -u test -ptest -h localhost test_db < /dump/test_db.sql
