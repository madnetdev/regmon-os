# REGmon (Open Source)


## Table of Contents
 1. [Requirements](#requirements)
 2. [Installation](#installation)
 3. [Use with Docker](#Use-with-Docker)
 4. [After Install](#After-Install)


## Requirements
* Web-server (Apache, Nginx...)
* PHP
* MySQL 
* or Docker


## Installation
1. Download repository in your DOCUMENT_ROOT directory:
    ```
    git clone https://github.com/madnetdev/regmon-os.git .
    ```
    This is not going to work if the ROOT directory is not empty.

    You can also download the repository in a zip file and extract it into your DOCUMENT_ROOT directory

    Another option is to clone in a new directory inside your DOCUMENT_ROOT directory
    ```
    git clone https://github.com/madnetdev/regmon-os.git appFolder
    ```


 2. You can install dependencies using the following

    for php :
    ```
    composer install
    ```
    for js :
    ```
    npm install
    ```
    or 

    you can use the files **"extra/_vendor.zip"** and **"extra/_node_modules.zip"** and extract them on your app folder


3. Create Database and User for the Database :

    to continue the instalation you will need :
    ```
    DB_NAME
    DB_USER
    DB_PASS
    ``` 


4. Go to http://localhost/ or http://localhost/appFolder/ 


5. Follow the installation script to create :
    - ".env" file
    - Admin User 
    - Basic Data (Location 1, Group 1)
    - Basic Admin Users (LocationAdmin, GroupAdmin, GroupAdmin2)
    - Sample Dropdown Data
    - Sports Select Dropdown Data (en, de)


6. Setup Application Email configuration
    - go to config.php page
    - test your Email configuration
    - save configuration




## Use with Docker
1. Download repository to a directory:
    ```
    git clone https://github.com/madnetdev/regmon-os.git regmon
    ```

    ```
    cd regmon
    ```


2. Use docker-compose to Build, Start and Stop Docker containers:

    For building the images for the containers.
    
    Also if you make any changes to Dockerfile you will need to build again the images.
    ```
    docker-compose build
    ```
    
    For running containers and see live logs of services (exit with Ctrl+C)
    ```
    docker-compose up
    ```
    
    For running containers as deamon and take the console back
    ```
    docker-compose up -d
    ```
    
    For stoping containers
    ```
    docker-compose down
    ```

    For a list of running containers
    ```
    docker-compose ps
    ```


3. When the containers are up and running :

    - Go to http://localhost:8000/ for the application

    - Go to http://localhost:8888/ for phpMyAdmin


5. Follow the application installation script to create :
    - ".env" file
    - Admin User 
    - Basic Data (Location 1, Group 1)
    - Basic Admin Users (LocationAdmin, GroupAdmin, GroupAdmin2)
    - Sample Dropdown Data
    - Sports Select Dropdown Data (en, de)


6. Setup Application Email configuration
    - go to config.php page
    - test your Email configuration
    - save configuration



## After Install

### Now you are ready to :
    - create some Locations
    - create some Groups
    - create some Forms
    - create some Categories 
    - assign some Forms to Categories
    - assign some Forms to Groups
    - create some Dropdown Menus
    - create new Sports and new Sports Categories 
    - register some Athletes and Trainers accounts 
    - aprove new Users to the Group
    - manage Group Users
    - assign Athletes to Trainers 
    - give permissions to Trainers on Athletes Forms Data
    - fill Forms and collect Data
    - export Data 
    - create new Data from Raw data with excel like format
    - create Interval Data from Raw data with excel like format
    - draw Results in Diagrams/Charts
    - create Form Results Templates
    - create Results Templates
    - ...
