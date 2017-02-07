# idintt
Dutch Blockchain Hackathon contribution team iDINtt

## Instructions
Download git and vagrant

(go to your working directory of choice)  
$ git clone https://github.com/notarynodes/idintt.git  
$ cd idintt  
$ vagrant up --provider virtualbox  

Now a vagrant box with java, maven, docker & docker-compose is created.  
SSH into the box to run the fabric dockers provided by yeasy.  

$ vagrant ssh  
$ sudo chmod u+x /vagrant/fabric-docker/init.sh  
$ sudo /vagrant/fabric-docker/init.sh  

## Directory structure

### fabric docker
Fabric 1.0 docker compose files to launch the fabric CA, peer and orderer (by yeasy)

### fabric-sdk-java-master
Fabric 1.0 java library developed Hyperledger fabric team

### idin-library-java1.041
Java library developed by iDIN

### idintt-fabric-module
The Hackathon contribution, development starts after the opening on Friday February 10th!!
