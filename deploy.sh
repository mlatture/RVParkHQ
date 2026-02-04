#!/bin/bash

# =============================================================================
# Deploy Script - Commit to GitHub and Deploy to Hostinger
# =============================================================================

set -e  # Exit on any error

# Configuration
SSH_HOST="45.89.207.87"
SSH_PORT="65002"
SSH_USER="u409912258"
REMOTE_PATH="domains/rvparkhq.com/public_html"
BRANCH="main"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Deployment Script${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""

# Get commit message from argument or prompt
COMMIT_MSG="$1"

# =============================================================================
# Step 1: Git Operations (Local)
# =============================================================================

echo -e "${YELLOW}Step 1: Checking git status...${NC}"

# Check if there are changes to commit
if [[ -n $(git status --porcelain) ]]; then
    echo "Changes detected:"
    git status --short
    echo ""

    # If no commit message provided as argument, prompt for one
    if [[ -z "$COMMIT_MSG" ]]; then
        read -p "Enter commit message (or 'skip' to skip commit): " COMMIT_MSG
    fi

    if [[ "$COMMIT_MSG" != "skip" && -n "$COMMIT_MSG" ]]; then
        echo -e "${YELLOW}Adding and committing changes...${NC}"
        git add -A
        git commit -m "$COMMIT_MSG"
        echo -e "${GREEN}Changes committed successfully${NC}"
    else
        echo -e "${YELLOW}Skipping commit${NC}"
    fi
else
    echo "No local changes to commit"
fi

# =============================================================================
# Step 2: Push to GitHub
# =============================================================================

echo ""
echo -e "${YELLOW}Step 2: Pushing to GitHub ($BRANCH branch)...${NC}"

# Check if there are commits to push
LOCAL=$(git rev-parse @)
REMOTE=$(git rev-parse @{u} 2>/dev/null || echo "")

if [[ "$LOCAL" != "$REMOTE" || -z "$REMOTE" ]]; then
    git push origin $BRANCH
    echo -e "${GREEN}Pushed to GitHub successfully${NC}"
else
    echo "Already up to date with remote"
fi

# =============================================================================
# Step 3: Deploy to Hostinger via SSH
# =============================================================================

echo ""
echo -e "${YELLOW}Step 3: Deploying to Hostinger...${NC}"
echo "Connecting to $SSH_USER@$SSH_HOST:$SSH_PORT"
echo ""

# SSH into Hostinger and run deployment commands (will prompt for password)
ssh -o StrictHostKeyChecking=no -p $SSH_PORT $SSH_USER@$SSH_HOST << 'ENDSSH'
    set -e

    echo "Connected to Hostinger"
    echo ""

    # Navigate to project directory
    cd ~/domains/rvparkhq.com/public_html
    echo "Current directory: $(pwd)"
    echo ""

    # Enable maintenance mode
    echo "Enabling maintenance mode..."
    php artisan down || true

    # Pull latest changes from GitHub
    echo ""
    echo "Pulling latest changes from GitHub..."
    git pull origin main

    # Install/update composer dependencies
    echo ""
    echo "Installing composer dependencies..."
    # Clear composer cache to ensure fresh install
    composer2 clear-cache || true
    # Install with verbose output to catch issues
    composer2 install --no-dev --optimize-autoloader --no-interaction

    # Regenerate autoload files to fix any class loading issues
    echo ""
    echo "Regenerating autoload files..."
    composer2 dump-autoload --optimize

    # Verify vendor directory exists
    if [ ! -d "vendor" ]; then
        echo "ERROR: vendor directory not created!"
        php artisan up || true
        exit 1
    fi
    echo "Vendor directory verified"

    # Run database migrations
    echo ""
    echo "Running database migrations..."
    php artisan migrate --force

    # Clear and rebuild caches
    echo ""
    echo "Clearing caches..."
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan route:clear

    # Rebuild optimized caches
    echo ""
    echo "Rebuilding optimized caches..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    # Disable maintenance mode
    echo ""
    echo "Disabling maintenance mode..."
    php artisan up

    echo ""
    echo "========================================"
    echo "  Deployment completed successfully!"
    echo "========================================"
ENDSSH

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Deployment Complete!${NC}"
echo -e "${GREEN}========================================${NC}"
