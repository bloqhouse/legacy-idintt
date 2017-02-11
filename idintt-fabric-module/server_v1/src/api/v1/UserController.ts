import {Post, JsonController, Body} from 'routing-controllers';
import {IdinTT} from '../../blockchain/IdinTT';
import {Container} from 'typedi';

class RegistrationRequest {
    public bin: string;
}

@JsonController('/user')
export class UserController {

    @Post('/')
    public async post(@Body() registrationRequest: RegistrationRequest): Promise<any> {
        const idinTT = Container.get(IdinTT);
        console.log('-------- Registering user');
        const secret = await idinTT.register(registrationRequest.bin);
        console.log('SECRET', secret);
        return idinTT.enroll(registrationRequest.bin, secret);
    }
}