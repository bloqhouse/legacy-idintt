'use strict';

import {LoggerInstance} from 'winston';
import {BlockchainInvokeRequest} from './BlockchainInvokeRequest';
import {BlockchainQueryRequest} from './BlockchainQueryRequest';
import {UserConfig} from '../ChaincodeEnvironmentConfiguration';
import {Member, RegistrationRequest, Chain} from 'hfc/lib/hfc';

export class BlockchainClient {
  public constructor(private chaincodeID: string,
                     private chain: Chain,
                     private logger: LoggerInstance) { }

  public async invoke(chaincodeFunctionName: any, args: string[], blockchainUsername: string): Promise<any> {
    let invokeRequest = new BlockchainInvokeRequest(this.chaincodeID, chaincodeFunctionName, args, this.logger, blockchainUsername, this.chain);

    return await invokeRequest.getResult();
  }

  public async query(chaincodeFunctionName: any, args: string[], blockchainUsername: string): Promise<any> {
    let queryRequest = new BlockchainQueryRequest(this.chaincodeID, chaincodeFunctionName, args, this.logger, blockchainUsername, this.chain);

    return await queryRequest.getResult();
  }

  public async getUser(enrollId: string): Promise<Member> {
    return new Promise<Member>((resolve: (member: Member) => void, reject: (error: Error) => void) => {
      this.chain.getMember(enrollId, (err: Error, member?: Member) => {
        if (err) {
          reject(err);
        }
        resolve(member);
      });
    });
  }

  public async registerAndEnrollUser(enrollId: string, attributes?: any[]): Promise<void> {
    const affiliation = 'institution_a';
    const role = '';

    this.chain.getUser(enrollId, (err: any, userObject: Member) => {
      if (err) {
        this.logger.error('[SDK] Error getting user ', enrollId, err.message + '\n' + err.stack);
        throw new Error('Unable to retrieve user');
      }

      if (userObject.isEnrolled()) {
        this.logger.info('[SDK] User ' + enrollId + ' is already enrolled');
        return Promise.resolve();
      }

      // User is not enrolled yet, so perform both registration and enrollment
      let registrationRequest = <RegistrationRequest> {
        enrollmentID: enrollId,
        affiliation: affiliation,
        account: '',
        attributes: attributes || [],
        roles: [role]
      };

      this.chain.registerAndEnroll(registrationRequest, (err: Error) => {
        if (err) {
          this.logger.info('[SDK] Could not register and enroll user ', enrollId, ' (ignoring...)', err.message);
          return Promise.resolve();
        }
        this.logger.info('[SDK] User ' + enrollId + ' successfully registered and enrolled');

        return Promise.resolve();
      });
    });
  }

}