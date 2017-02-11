import {Post, JsonController, Body} from 'routing-controllers';
import {Container} from 'typedi';
import {LoggerFactory} from '../../utils/LoggerFactory';
import {BlockchainClient} from '../../blockchain/client/blockchainClient';
import * as winston from 'winston';
import {TCert} from 'hfc/lib/hfc';

class RegistrationRequest {
    public bin: string;
    public name: string;
    public vendorId: string;
}

class UserInfo {
    public constructor(public name: string) {}
}

@JsonController('/user')
export class UserController {
    private logger: winston.LoggerInstance = Container.get(LoggerFactory).create();
    private blockchainClient: BlockchainClient = Container.get(BlockchainClient);

    @Post('/')
    public async post(@Body() registrationRequest: RegistrationRequest): Promise<any> {
        const userId = `${registrationRequest.vendorId}_${registrationRequest.bin}`;
        this.logger.info(`Registering ${userId} at certificate authority`);

        if (!registrationRequest.bin || !registrationRequest.vendorId || !registrationRequest.name) {
            return Promise.reject('bin, vendorId, name are required');
        }

        try {
            let member = await this.blockchainClient.registerAndEnrollUser(userId, [
                {name: 'name', value: registrationRequest.name},
            ]);
            return new Promise<any>((resolve: (res: any) => void, reject: (error: Error) => void) => {
                member.getNextTCert([], (err: Error, tcert?: TCert) => {
                    if (err) {
                        this.logger.info(err.message);
                        return reject(err);
                    }
                    return resolve({
                        priv: tcert.privateKey,
                        publ: tcert.publicKey,
                        success: true
                    });
                });
            });
        } catch (err) {
            this.logger.info(err);
        }
    }
}
