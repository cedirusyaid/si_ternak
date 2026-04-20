#!/bin/bash

# Pull the latest changes from the remote repository (assuming 'origin' and 'main' branch)
git pull origin main

if [ $? -eq 0 ]; then
  echo "Latest changes successfully pulled."
else
  echo "An error occurred during git pull operation."
fi