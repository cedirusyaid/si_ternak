#!/bin/bash

# Add all changes to the staging area
git add .

# Get current timestamp
TIMESTAMP=$(date +"%Y-%m-%d %H:%M:%S")

# Generate a default commit message with the timestamp
COMMIT_MESSAGE="$TIMESTAMP - Automated commit"

# Commit the changes with the generated message
git commit -m "$COMMIT_MESSAGE"

# Push the changes to the remote repository (assuming 'origin' and 'main' branch)
git push origin main

if [ $? -eq 0 ]; then
  echo "Changes successfully added, committed, and pushed."
else
  echo "An error occurred during git operations.""
fi