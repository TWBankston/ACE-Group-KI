#!/bin/bash
# ACE Group KI Deployment Script (Linux/Mac)
# Deploys theme and plugins to staging server via SFTP

set -e

CONFIG_FILE="${1:-deploy-config.local.json}"
THEME_ONLY="${2:-false}"
PLUGIN_ONLY="${3:-false}"
PLUGIN_NAME="${4:-}"

# Check if config file exists
if [ ! -f "$CONFIG_FILE" ]; then
    echo "Error: Configuration file not found: $CONFIG_FILE"
    echo "Please copy deploy-config.example.json to $CONFIG_FILE and update with your credentials"
    exit 1
fi

# Parse JSON config (requires jq)
if ! command -v jq &> /dev/null; then
    echo "Error: jq is required. Install with: brew install jq (Mac) or apt-get install jq (Linux)"
    exit 1
fi

HOST=$(jq -r '.host' "$CONFIG_FILE")
PORT=$(jq -r '.port' "$CONFIG_FILE")
USERNAME=$(jq -r '.username' "$CONFIG_FILE")
PASSWORD=$(jq -r '.password' "$CONFIG_FILE")
REMOTE_PATH=$(jq -r '.remotePath' "$CONFIG_FILE")
SSH_KEY=$(jq -r '.sshKeyPath' "$CONFIG_FILE")
THEME_PATH=$(jq -r '.themePath' "$CONFIG_FILE")
PLUGIN_PATHS=$(jq -r '.pluginPaths[]' "$CONFIG_FILE")

# Check if lftp is installed
if ! command -v lftp &> /dev/null; then
    echo "Error: lftp is required. Install with: brew install lftp (Mac) or apt-get install lftp (Linux)"
    exit 1
fi

# Create temporary script for lftp
TEMP_SCRIPT=$(mktemp)
trap "rm -f $TEMP_SCRIPT" EXIT

echo "set sftp:auto-confirm yes" > $TEMP_SCRIPT
echo "set sftp:connect-program \"ssh -a -x -oHostKeyAlgorithms=+ssh-rsa -oPubkeyAcceptedKeyTypes=+ssh-rsa\"" >> $TEMP_SCRIPT

if [ -n "$SSH_KEY" ] && [ -f "$SSH_KEY" ]; then
    echo "open -u $USERNAME, sftp://$HOST:$PORT" >> $TEMP_SCRIPT
    echo "Using SSH key authentication"
else
    echo "open -u $USERNAME,$PASSWORD sftp://$HOST:$PORT" >> $TEMP_SCRIPT
    echo "Using password authentication"
fi

# Deploy theme
if [ "$THEME_ONLY" != "true" ] && [ "$PLUGIN_ONLY" != "true" ]; then
    echo "Deploying theme..."
    echo "cd $REMOTE_PATH/themes" >> $TEMP_SCRIPT
    echo "rm -rf acegroupki" >> $TEMP_SCRIPT
    echo "mirror -R $THEME_PATH acegroupki" >> $TEMP_SCRIPT
fi

# Deploy plugins
if [ "$PLUGIN_ONLY" = "true" ] && [ -n "$PLUGIN_NAME" ]; then
    PLUGIN_PATHS="wp-content/plugins/$PLUGIN_NAME"
fi

if [ "$THEME_ONLY" != "true" ]; then
    for PLUGIN_PATH in $PLUGIN_PATHS; do
        PLUGIN_NAME=$(basename "$PLUGIN_PATH")
        echo "Deploying plugin: $PLUGIN_NAME..."
        echo "cd $REMOTE_PATH/plugins" >> $TEMP_SCRIPT
        echo "rm -rf $PLUGIN_NAME" >> $TEMP_SCRIPT
        echo "mirror -R $PLUGIN_PATH $PLUGIN_NAME" >> $TEMP_SCRIPT
    done
fi

echo "quit" >> $TEMP_SCRIPT

# Execute deployment
echo "Connecting to $HOST:$PORT..."
lftp -f $TEMP_SCRIPT

echo "Deployment completed successfully!"

