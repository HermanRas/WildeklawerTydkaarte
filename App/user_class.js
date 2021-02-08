export class User {
    constructor(id, naam, van, CN, pwd, farm_id, accesslevel) {
        this.id = id;
        this.naam = naam;
        this.van = van;
        this.CN = CN;
        this.pwd = pwd;
        this.farm_id = farm_id;
        this.accesslevel = accesslevel;
    }

    id() {
        return this.id;
    }

    naam() {
        return this.naam;
    }

    van() {
        return this.van;
    }

    CN() {
        return this.CN;
    }

    pwd() {
        return this.pwd;
    }

    farm_id() {
        return this.farm_id;
    }

    accesslevel() {
        return this.accesslevel;
    }

}