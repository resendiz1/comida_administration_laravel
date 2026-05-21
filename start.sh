#!/bin/bash
DIR="$(cd "$(dirname "$0")" && pwd)"
exec php -S 0.0.0.0:8080 -t "$DIR/public"
