# REGmon (Open Source)
This project ...


## Table of Contents
 1. [Requirements](#requirements)
 2. [Installation](#installation)
 3. [FAQs](#faqs)

 3.1 [How to set my Database configuration](#How-to-set-my-Database-configuration)
 
 3.2 [How to set my Email configuration](#How-to-set-my-Email-configuration)


## Requirements
* Web-server (Apache, Nginx...)
* PHP
* MySQL 

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
    composer install --no-dev
    ```
    for js :
    ```
    npm install
    ```
    or 

    you can use the files **"extra/_vendor.zip"** and **"extra/_node_modules.zip"** and extract them on your app folder (you can delete those files afterwards)

3. Create Database and Import :

    use **"extra/_regmondb_init v3.006.sql"** file for a new installation
    
    use **"extra/_regmondb_update_to_v3.002.sql"** file for update from a v3.000 installation

    use **"extra/_regmondb_update_to_v3.006.sql"** file for update from a v3.002 installation

4. Create a folder for exports/imports and users uploads.

    It should NOT be under DOCUMENT_ROOT, so it is not accessible from outside
    ex.: **"../regmon_files/"**   

5. Copy or rename the file **"_config.regmon.sample.php"** to a new file **"__config.regmon.php"**

6. Edit the configuration file and set your database and your email configuration

7. Go to http://localhost/ 

8. Use the following accounts to login :

    admin, DemoLocation, DemoGroupAdmin, DemoGroupAdmin2

    password for all: DemoPass

9. You can resister some Athletes and Trainers accounts once you setup your Email configuration



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
