import {Post, JsonController, Body, Res, Controller} from 'routing-controllers';
import {Container} from 'typedi';
import {LoggerFactory} from '../../utils/LoggerFactory';
import {BlockchainClient} from '../../blockchain/client/blockchainClient';
import * as winston from 'winston';
import * as fs from 'fs';
import {ChaincodeLocalConfig} from '../../blockchain/ChaincodeLocalConfig';

class RegistrationRequest {
    public bin: string;
    public name: string;
    public vendorId: string;
    public uid: string;
}

class UserInfo {
    public constructor(public name: string) {}
}

@JsonController('/user')
export class UserController {
    private logger: winston.LoggerInstance = Container.get(LoggerFactory).create();
    private blockchainClient: BlockchainClient = Container.get(BlockchainClient);

    @Post('/')
    public async post(@Body() registrationRequest: RegistrationRequest, @Res() response: any): Promise<any> {
        return new Promise<any>((resolve: (data: any) => void, reject: (error: Error) => void) => {
            const userId = `${registrationRequest.vendorId}_${registrationRequest.bin}`.replace(/\W/g, '');
            this.logger.info(`Registering ${userId} (${registrationRequest.name}) at certificate authority`);
            registrationRequest.name = registrationRequest.name || 'Test gebruiker';
            const name = registrationRequest.name.replace(/\W/g, '');
            this.logger.info(name);

            if (!registrationRequest.bin || !registrationRequest.vendorId || !registrationRequest.name) {
                return Promise.reject('bin, vendorId, name are required');
            }
            console.log(registrationRequest);
            try {
                this.blockchainClient.registerAndEnrollUser(userId, [
                    {name: 'name', value: registrationRequest.name},
                ]).then(member => {
                    const filename = __dirname +
                        '/../../' + new ChaincodeLocalConfig().getConfiguration().chaincode.keyValStorePath +
                        '/member.' + userId;

                    fs.readFile(filename, 'utf8', (err: Error, data: any) => {
                        if (err) {
                            throw err;
                        }
                        console.log('OK: ' + filename);
                        let obj = JSON.parse(data);
                        obj.uid = registrationRequest.uid;
                        return resolve(obj);
                    });
                });
            } catch (err) {
                this.logger.info(err);
                return reject(err);
            }
        });
    }
}
