#!/bin/bash

# http://askubuntu.com/questions/762999/how-to-install-java-8-in-ubuntu-16-04

sudo apt-get update
sudo apt-get install openjdk-8-jdk
sudo apt-get install maven

sudo su
JAVA_HOME="/usr/lib/jvm/open-jdk"
PATH=$PATH:JAVA_HOME/bin
cd /vagrant/fabric-sdk-java-master
mvn install

# javac -cp "/vagrant/fabric-sdk-java-master/target/fabric-java-sdk-1.0-SNAPSHOT.jar" Hello.java
