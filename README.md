# KitchenHelper
This is a PHP&Javascript based Web Application for a local Intranet to manage a Dinning hall for a small business.

Requires:
- Codeigniter Version 3.0.6 (tested and developed on this version)
- PHP 5.6.21 (Developed) or PHP 7 (Tested)
- MySQL (Tested and developed on mysql Version 15.1 Distrib 10.0.22-MariaDB, for Linux (x86_64) using readline 5.)
- [cron](https://de.wikipedia.org/wiki/Cron)

Makes use of:
- jQuery 2.2.0
- Bootstrap v3.3.5
- jQuery UI - v1.12.0-rc.2 - 2016-04-21

# Installation KitcheHelper

## Installation of Codeigniter
(*follow the instructions:  [Codeigniter Installation Guide](http://www.codeigniter.com/user_guide/installation/index.html) or:*)
1. Download [Codeigniter](https://codeigniter.com/download)
2. Unpack it in the future destination of the KitchenHelper. *Unpack only the system folder because the application/ comes with the kitchenhelper and the index.php as well*

## Installation of the programm itself

1. Download the KitcheHelper
2. unpack/clone the folder
3. navigate via the terminal of your choice to the main folder `($ cd /srv/www/htdocs/)`
4. make sure that: **/application/config/config.php** is writeable and readable for the current user. if not use [chmod](http://www.computerhope.com/unix/uchmod.htm) to change it (Under Linux)
5. make sure that: **/application/config/database.php** is writeable and readable for the current user. if not use [chmod](http://www.computerhope.com/unix/uchmod.htm) to change it (Under Linux)
6. type in the following command `php Installer.php` and follow the instructions.
7. after the installation assitent finished it will delete: **/install_data** and **Install.php** if not make sure they are deleted.
8. You have to change the line `RewriteBase /folder/` in the .htaccess file to the current path of the installation of the programm (KitchenHelper)

**For further information how to install the KitchenHelper please check the wiki**









