# Requirements
- Docker
- Docker Compose

# Start the containers
Run the below comand in the root of this project (smrtbio_container/)
```bash
docker-compose up --build -d
```

# Access the site

- Drupal site: http://localhost:8080

- phpMyAdmin: http://localhost:8081
	- Username: root
	- Password: root

# **Required!!!** Rebuilding the Database

> ⚠️⚠️⚠️ IMPORTANT: 
> PLEASE NEVER USE CMD OR POWERSHELL TO RUN THE BELOW COMMAND. USE ONLY GIT BASH ON WINDOWS MACHINE.

> WHY? 
> CMD AND POWERSHELL CHANGES THE UTF CODE TO UTF-16 LE WHICH LEADS TO THE SITE BREAKING. THANK YOU!!

If you make changes to the Drupal site and want to export the database:
```bash
docker exec -i mariadb mysqldump -u root -proot smrtbio > db-init/smrtbio.sql
```

# Cleaning Up

To stop and remove containers:
``` bash 
docker-compose down -v
```



# When Facing error of there being no files folder under sites/default and permission problems under folder:
``` bash
cd drupal/web/sites/default
mkdir -p files
chmod 775 files
chmod 664 settings.php
cd ..
chown -R www-data:www-data default/
```
