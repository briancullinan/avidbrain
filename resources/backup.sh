#!/bin/bash
mysqldump -u root -p  avidbrain > amozek.sql
mysqldump -u root -p  qa_avidbrain > qa_amozek.sql

echo 'Backup Complete';
