export class Worker {
    constructor(id, naam, van, CN, farm_id) {
        this.id = id;
        this.naam = naam;
        this.van = van;
        this.CN = CN;
        this.farm_id = farm_id;
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

    farm_id() {
        return this.farm_id;
    }

}