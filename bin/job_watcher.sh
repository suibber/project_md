#!/bin/bash

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
source ${DIR}/../spider/.env/bin/activate
supervisord -c ${DIR}/supervisord.conf
