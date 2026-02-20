#!/usr/bin/env bash
set -e

# Check if the user passed any arguments (like 'update' or 'require')
if [ $# -gt 0 ]; then
    # Run the specific command the user typed
    exec composer "$@" --ignore-platform-reqs
else
    # Default behavior if no arguments are provided
    echo "--- 🚚 No arguments provided, running default install ---"
    exec composer install --ignore-platform-reqs --no-interaction
fi