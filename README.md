## Snapp Express Interview Test
## Table of Contents

* [Usage](#usage)

## Usage

``` sh
DOCKER_APP_NAME=snapp-test-app
# Directory path for docker configs
DOCKER_DIR=.etc/docker
```


* For containers, make the env file from `$DOCKER_DIR/.env.example` .
* Then from root of project, run:

``` sh
docker-compose --env-file $DOCKER_DIR/$ENV_FILE -f $DOCKER_DIR/docker-compose.yml up --build
```
