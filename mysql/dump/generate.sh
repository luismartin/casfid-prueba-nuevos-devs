#!/usr/bin/env bash

mysqldump --no-tablespaces -u test -ptest test_db > /dump/test_db.sql
