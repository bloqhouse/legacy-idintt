#!/bin/bash
####################################
#
# Pull images and docker-compose to run ca, orderer and peer
#
####################################

curl -o docker-compose.yml https://raw.githubusercontent.com/yeasy/docker-compose-files/master/hyperledger/1.0/docker-compose.yml
curl -o peer.yml https://raw.githubusercontent.com/yeasy/docker-compose-files/master/hyperledger/1.0/peer.yml

docker pull yeasy/hyperledger-fabric-base:latest \
  && docker pull yeasy/hyperledger-fabric-peer:latest \
  && docker pull yeasy/hyperledger-fabric-orderer:latest \
  && docker pull yeasy/hyperledger-fabric-ca:latest \
  && docker pull yeasy/blockchain-explorer:latest \
  && docker tag yeasy/hyperledger-fabric-peer hyperledger/fabric-peer \
  && docker tag yeasy/hyperledger-fabric-orderer hyperledger/fabric-orderer \
  && docker tag yeasy/hyperledger-fabric-ca hyperledger/fabric-ca \
  && docker tag yeasy/hyperledger-fabric-base hyperledger/fabric-baseimage \
  && docker tag yeasy/hyperledger-fabric-base hyperledger/fabric-ccenv:x86_64-1.0.0-snapshot-preview

docker-compose up -d
