#!/bin/bash

apt-get update

# installing java & maven
apt-get install -y openjdk-8-jdk
JAVA_HOME="/usr/lib/jvm/open-jdk"
PATH=$PATH:JAVA_HOME/bin
apt-get install -y maven

# installing docker
apt-get install curl -y
wget -qO- https://get.docker.com/ | sh
sudo service docker stop
nohup sudo docker daemon --api-cors-header="*" -H tcp://0.0.0.0:2375 -H unix:///var/run/docker.sock&

# installing docker-compose
curl -L https://github.com/docker/compose/releases/download/1.8.0/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
docker-compose --version
