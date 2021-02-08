export class Farm {
    constructor(id, naam, afkorting) {
        this.id = id;
        this.naam = naam;
        this.afkorting = afkorting;
    }

    id() {
        return this.id;
    }

    naam() {
        return this.naam;
    }

    afkorting() {
        return this.afkorting;
    }

}