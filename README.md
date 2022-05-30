## Project's description

A simple web-application aimed to help solve cipher-based crossword


## Prepare local environment

Before clone and run this application be sure that [NPM](https://www.npmjs.com/) (js package manager) and PHP (including [Composer](https://getcomposer.org/) package manager) are installed on your local machine

## Installation guide

Enter below commands in the following order

Before entering command placed below you have to create .env file with variables of your local environment.
Example which environment variables .env file have to store showed in .env.example.


```
git clone https://github.com/ArtemiyMalau/PHPCrosswordCipherSolver
```
*Command copy this repository to your local machine*

```
composer update
```
*Load all PHP dependencies to vendor local directory*

```
npm install
```
*Load all JavaScript dependencies to node_modules local directory*

```
npm run watch
```
*Runs npm webpack scripts, wrapped into Laravel Mix package for compile front-end assets*

```
php artisan cache:clear
```
*Run this command to clear cache files. Useful when you have to sure that all files is up to dated*

```
php artisan serve
```
*Command starting artisan server for receiving http requests and passing them further to Laravel app*


After go to localhost url for checking is the application actually work