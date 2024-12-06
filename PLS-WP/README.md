# PLS-WP

This is the theme for the PLS Wordpress site.

# Reccommended Tools for Development

 - Local (formerly Flywheel)
 - Node 18
 - VSCode

# Development Instructions
 - Pull correct environment (dev/staging/prod) with Local from WPEngine
 - Navigate to the site's root folder, and then to wp-content/themes
 - Remove the current theme folder for PLS-WP (rm -rf PLS-WP)
 - git clone this repo into the current folder (wp-content/themes)
 - cd into PLS-WP
 - yarn (install dependencies)
 - yarn watch (live-reload/hot-editing)

# Deployment Instructions / Notes
 - yarn dev to build for deployment
 - push to github
 - github action will build and deploy to the theme folder of wp-engine's correct environment

// 
