# Vantiv DevHub PHP SDK

[![Build Status](https://travis-ci.org/steveoliver/vantiv_devhub_sdk_php.svg?branch=master)](https://travis-ci.org/steveoliver/vantiv_devhub_sdk_php) [![Coverage Status](https://coveralls.io/repos/github/steveoliver/vantiv_devhub_sdk_php/badge.svg?branch=master)](https://coveralls.io/github/steveoliver/vantiv_devhub_sdk_php?branch=master)

This repository contains a PHP implementation of the Vantiv DevHub API.

## Installation
 - ```composer install``` to install dev dependencies like PhpUnit.
 - Optional: configure php with xdebug for code coverage analysis.

## Testing
### Unit testing
  - Set environment variable ```VANTIV_DEVHUB_LICENSE``` to a valid Vantiv DevHub license key suitable for testing.
  - Run ```./vendor/bin/phpunit --testsuite Unit_Test```, optionally with xdebug enabled to generate code coverage reports in build/logs/clover.xml.

### Certification testing
  - Copy ```tests/example.config.ini``` to ```tests/config.ini``` and edit with your application's license key.
  - Run tests with ```./vendor/bin/phpunit```, optionally with xdebug enabled to generate code coverage reports in builds/logs/clover.xml.
  - See build/logs/devhubresults*.txt files for the results of DevHub certification tests.

## Usage
 - Instantiate a ```Vantiv\Configuration``` object with an array of config parameters:
   - api_version
   - base_url
   - license
 - Instantiate a ```Vantiv\Request``` object with the ```Configuration``` object.
 - Call the ```Request->send()``` method with the following parameters:
   - ```body```
     - An array representing the DevHub request
   - ```category```
     - 'payment', 'boarding', etc.
   - ```proxy```
     - 'credit', 'check', 'services', etc.
   - ```endpoint```
     - 'authorization', authorizationCompletion', 'credit', 'sale', 'return', 'void', 'force', 'reversal', 'verification', etc.
   - ```method```
     - The HTTP method
   - ```query```
     - Optional HTTP query parameters
