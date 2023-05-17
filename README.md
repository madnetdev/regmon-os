# REGmon (Open Source)
This project ...


## Table of Contents
 1. [Requirements](#requirements)
 3. [Installation](#installation)
 3. [Use with Docker](#Use-with-Docker)
 4. [FAQs](#faqs)
  4.1 [How to set my Database configuration](#How-to-set-my-Database-configuration)
  4.2 [How to set my Email configuration](#How-to-set-my-Email-configuration)


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
    in this case you need to set the following in your config file
    ```
    $CONFIG['REGmon_Folder'] = 'appFolder/';
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

    you can use the files **"extra/_vendor.zip"** and **"extra/_node_modules.zip"** and extract them on your app folder (you can delete those files afterwards)


3. Copy or rename the file **".env.sample"** to a new file **".env"**

    Here you set the Password for the ROOT user of the MYSQL Server
    ``
    MYSQL_ROOT_PASSWORD=root
    ``


4. Copy or rename the file **"_config.regmon.sample.php"** to a new file **"__config.regmon.php"**


5. Edit the configuration file and set your database and your email configuration


6. Create Database and Import :

    use **"extra/_regmondb_init_v3.012_en.sql"** or **"extra/_regmondb_init_v3.012_de.sql"** file for a new installation
    
    First you may want to replace the **"email@domain.com"** with your email address


7. Go to http://localhost/ 


8. Use the following accounts to login :

    admin, DemoLocation, DemoGroupAdmin, DemoGroupAdmin2

    password for all: DemoPass


9. You can resister some Athletes and Trainers accounts once you setup your Email configuration





## Use with Docker
1. Download repository to a directory:
    ```
    git clone https://github.com/madnetdev/regmon-os.git regmon
    ```

    ```
    cd regmon
    ```

2. Copy or rename the file **".env.sample"** to a new file **".env"**


3. Edit the file and set the Password for the ROOT user of the MYSQL Server
    The Password for the ROOT user will be set to this in the "db" Docker container
    ``
    MYSQL_ROOT_PASSWORD=root
    ``


3. Copy or rename the file **"_config.regmon.sample.php"** to a new file **"__config.regmon.php"**


4. Edit the configuration file and set your database and your email configuration


5. Use docker-compose to Build, Start and Stop Docker containers:

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


6. Go to http://localhost/ 


7. Use the following accounts to login :

    admin, DemoLocation, DemoGroupAdmin, DemoGroupAdmin2

    password for all: DemoPass


8. You can resister some Athletes and Trainers accounts once you setup your Email configuration




## FAQ's

### How to set my Database configuration
1. Edit the following lines in **"__config.regmon.php"** file:
    ```
    $CONFIG['DB_Host'] = "localhost";    //Database Hostname ex. localhost
    $CONFIG['DB_Name'] = "regmondb";     //Database Name ex. regmondb
    $CONFIG['DB_User'] = "root";         //Database User ex. root
    $CONFIG['DB_Pass'] = "";             //Database Password ex. root
    ```

### How to set my Email configuration
1. Edit the following lines in **"__config.regmon.php"** file:
    ```
    $CONFIG['EMAIL'] = [
        'Host'       => 'domain.com',      //SMTP server (localhost)
        'SMTPSecure' => 'tls',             //ssl, tls - ssl(465) - tls(587)
        'Port'       => '587',             //SMTP port for the server (25, 465, 587)
        'Username'   => 'info@domain.com', //SMTP account username
        'Password'   => 'userpassword',    //SMTP account password
    ]
    ```
