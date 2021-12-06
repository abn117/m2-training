#!/bin/bash

# Check if the nginx syntax is fine, then launch
nginx -t

exec "$@"
