#!/bin/bash
DATE=`date +%Y-%m-%d:%H:%M:%S`;
mysqldump -h 7b9488aeb86ce5dc0843d7298b2b70b44ddeb574.rackspaceclouddb.com -u brainiac -p'ipi}nGaN6P4QAEJtxJ3W^Xc%Q9aforDBwnpFk}B' avidbrain > /var/www/avidbrain.com/resources/avidbrain.$DATE.sql
echo 'Backup Complete';
