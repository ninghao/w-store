# ninghao-docker-wordpress
Running WordPress in Docker container.

## .env
Create a file in root directory called .env, put following content in the file.
Modify this file content according to your needs.

```
WORDPRESS_VERSION=5.0.3
WORDPRESS_PORT=8083

WORDPRESS_DB_USER=wordpress
WORDPRESS_DB_PASSWORD=A7yXSYuJBSIixu
WORDPRESS_DB_NAME=wordpress
```

## Run
Open your system terimal, go to the project directory, and run following command.

```
docker-compose up -d
```

![Install WordPress](https://github.com/ninghao/ninghao-docker-wordpress/blob/master/public/screenshot-install-wp.png?raw=true "Screenshot for install WordPress")


