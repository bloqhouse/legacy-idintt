Install vagrant:
https://www.vagrantup.com/downloads.html


############### Already provided ###################
$ curl -o docker-compose.yml https://raw.githubusercontent.com/yeasy/docker-compose-files/master/hyperledger/1.0/docker-compose.yml

$ curl -o peer.yml https://raw.githubusercontent.com/yeasy/docker-compose-files/master/hyperledger/1.0/peer.yml

$ curl -o setup_fabric_1.0.sh https://raw.githubusercontent.com/yeasy/docker-compose-files/master/hyperledger/1.0/setup_fabric_1.0.sh

$ vagrant init ubuntu/trusty64
############### /Already provided ###################


$ vagrant up --provider virtualbox

$ vagrant ssh

vagrant@vagrant-ubuntu-trusty-64:~$ sudo su

root@vagrant-ubuntu-trusty-64:/home/vagrant# cd /vagrant

root@vagrant-ubuntu-trusty-64:/vagrant# bash setup_fabric_1.0.sh
