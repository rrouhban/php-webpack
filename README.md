php-webpack
===========

# basic command with docker-compose
- build containers: `make build`
- build and run containers: `make up`
- start container if already build: `make start`
- stop containers without remove containers: `make stop`
- stop and remove containers: `make down`
- display log for all containers: `make log`
- run bash inside container app: `make bash-app`
- run bash inside container node: `make bash-node`
- run composer inside container app: `make composer "COMMAND"`
- run npm inside container node: `make npm "COMMAND"`
- run yarn inside container node: `make yarn "COMMAND"`