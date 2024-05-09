#!/bin/bash

echo "Enter commit message:"
read -r message

# Check if the commit message is empty
if [ -z "$message" ]; then
    echo "Commit message cannot be empty. Exiting."
    exit 1
fi

git add .
git commit -m "$message"
