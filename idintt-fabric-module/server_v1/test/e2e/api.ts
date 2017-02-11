import * as supertest from 'supertest';
import 'mocha';
import * as chai from 'chai';

const should = chai.should();
const expect = chai.expect;
const server = supertest.agent('http://localhost:8080');

describe('the running server', () => {

    let token = '';
    it('should register a user', (done) => {
        server
            .post('/api/v1/user')
            .send({bin: 'TESTBIN12', vendorId: 'harry', name: 'Ben Bontje'})
            .expect(200)
            .expect('Content-Type', /json/)
            .end((err, res) => {
                console.log(res.body);
             //   expect(res.body);
                done(err);
            });
    });
});