#!/bin/bash

# Define variables
LOCAL_PORT=3306
REMOTE_HOST="webdevServer"
REMOTE_PORT=3306

# Start the SSH tunnel in the background
ssh -f -N -L $LOCAL_PORT:$REMOTE_HOST:$REMOTE_PORT $REMOTE_HOST &

# Get the PID of the last background process (SSH tunnel)
SSH_TUNNEL_PID=$!

# Function to clean up when script exits
cleanup() {
    # Kill the SSH tunnel
    kill $SSH_TUNNEL_PID
}

# Set up trap to call cleanup function on script exit
trap cleanup EXIT

# Listen on local port 3306 and forward traffic to SSH tunnel
socat TCP-LISTEN:$LOCAL_PORT,fork TCP:localhost:$LOCAL_PORT | tee /dev/stderr
