#!/bin/bash

sudo su
apt-get update

# installing java
apt-get install openjdk-8-jdk
apt-get install maven
JAVA_HOME="/usr/lib/jvm/open-jdk"
PATH=$PATH:JAVA_HOME/bin

# installing docker & docker-compose
apt-get install curl -y
wget -qO- https://get.docker.com/ | sh
sudo service docker stop
nohup sudo docker daemon --api-cors-header="*" -H tcp://0.0.0.0:2375 -H unix:///var/run/docker.sock&
curl -L https://github.com/docker/compose/releases/download/1.8.0/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
docker-compose --version

# downloading files
mkdir fabric-docker
cd fabric-docker
mkdir orderer-fix
curl -o docker-compose.yml https://raw.githubusercontent.com/notarynodes/idintt/master/fabric-docker/docker-compose.yml
curl -o peer.yml https://raw.githubusercontent.com/notarynodes/idintt/master/fabric-docker/peer.yml
curl -o init.sh https://raw.githubusercontent.com/notarynodes/idintt/master/fabric-docker/init.sh
curl -o orderer-fix/Dockerfile https://raw.githubusercontent.com/notarynodes/idintt/master/fabric-docker/orderer-fixed/Dockerfile

# setting up docker fabric
bash ./init.sh
docker-compose up

# cd /vagrant/fabric-sdk-java-master
# mvn install
# javac -cp "/vagrant/fabric-sdk-java-master/target/fabric-java-sdk-1.0-SNAPSHOT.jar" Hello.java
