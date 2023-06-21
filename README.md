## Usage

- git clone
- copy .env.example to .env
- change default mysql docker volume location (DOCKER_MYSQL_VOLUME variable can point to ramdisk directory)
- make sure port 800 is free
- run **./sample** without arguments for usage information
- run **./sample -u** to start the app
- point your browser to http://0.0.0.0:800 (http://localhost:800)
- try sample query and mutation from graphql.txt file
