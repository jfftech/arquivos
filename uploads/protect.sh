#!/bin/bash

# Define the directory to protect
PROTECTED_DIR="/DPQ"

# Check if the current user is trying to remove the protected directory
if [[ "$1" == "rm" && "$2" == "-rf" && "$3" == "$PROTECTED_DIR" ]]; then
    echo "Error: Cannot remove the protected directory: $PROTECTED_DIR"
    exit 1
fi

# If the user is not trying to remove the protected directory, execute the command as usual
"$@"