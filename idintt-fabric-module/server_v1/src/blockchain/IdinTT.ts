const hfc = require('fabric-client');
const utils = require('fabric-client/lib/utils.js');
/* tslint:disable */
const Peer = require('fabric-client/lib/Peer.js');
const Orderer = require('fabric-client/lib/Orderer.js');
const User = require('fabric-client/lib/User.js');
/* tslint:enable */
const config = require('../../resources/config.json');
const copService = require('fabric-ca-client/lib/FabricCAClientImpl.js');

export class IdinTT {
    private admin: any;
    private client: any = new hfc();
    private chain: any = this.client.newChain(config.chainName);
    private caService: any = new copService(config.caserver.ca_url);
    private caClient: any = this.caService._fabricCAClient;

    public constructor() {
        this.chain.addOrderer(new Orderer(config.orderer.orderer_url));
        for (let i = 0; i < config.peers.length; i++) {
            this.chain.addPeer(new Peer(config.peers[i].peer_url));
        }

        hfc.newDefaultKeyValueStore({
            path: config.keyValueStore
        }).then((store) => {
            this.client.setStateStore(store);
            return this.registerAdmin();
        }).then((admin) => {
            console.info('Successfully obtained admin user.');
            this.admin = admin;
        }).catch((err) => {
            console.error('Failed with error:' + err.stack ? err.stack : err);
        });
    }

    private registerAdmin(): Promise<any> {
        const users = config.users;
        const username = users[0].username;
        const password = users[0].secret;
        return this.enroll(username, password);
    }

    public register(username: string): Promise<any> {
        return this.caClient.register(username, 'user', 'group', [], this.admin.getName());
    }

    public enroll(username: string, secret: string): Promise<any> {
        let member;
        return this.client.getUserContext(username)
            .then((user) => {
                if (user && user.isEnrolled()) {
                    console.info('Successfully loaded member from persistence');
                    return user;
                } else {
                    // need to enroll it with CA server
                    return this.caService.enroll({
                        enrollmentID: username,
                        enrollmentSecret: secret
                    }).then((enrollment) => {
                        console.info('Successfully enrolled user \'' + username + '\'');

                        member = new User(username, this.client);
                        return member.setEnrollment(enrollment.key, enrollment.certificate);
                    }).then(() => {
                        return this.client.setUserContext(member);
                    }).then(() => {
                        return member;
                    }).catch((err) => {
                        console.error('Failed to enroll and persist user. Error: ' + err.stack ? err.stack : err);
                        throw new Error('Failed to obtain an enrolled user');
                    });
                }
            });
    }
}
