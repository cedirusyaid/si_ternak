#!/bin/bash

# Auto detect current branch
BRANCH=$(git rev-parse --abbrev-ref HEAD)

# Get today's date in YYMMDD format
YYMMDD=$(date +"%y%m%d")

# If no argument is passed, use a default standard format commit message
if [ -z "$1" ]; then
  COMMIT_MESSAGE="$YYMMDD - [mod]: Automated commit"
else
  COMMIT_MESSAGE="$YYMMDD - $1"
fi

# Add all changes to the staging area
git add .

# Commit the changes with the formatted message
git commit -m "$COMMIT_MESSAGE"

# Push the changes to the remote repository
git push origin "$BRANCH"

if [ $? -eq 0 ]; then
  echo "Changes successfully added, committed, and pushed to $BRANCH."
else
  echo "An error occurred during git operations."
fi