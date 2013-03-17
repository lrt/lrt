#!/bin/bash
echo "Cleanup command for removing .git folders in vendors"

find ./vendor -name ".git*" -exec rm -rf {} \;