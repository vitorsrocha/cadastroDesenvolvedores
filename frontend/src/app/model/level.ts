export class Level {
    id: number | null = null
    nivel: string = ""
    qtdeDev?: number;

    constructor(
        id: number | null, 
        nivel: string,
        qtdeDev?: number
    ){
        this.id = id
        this.nivel = nivel
        this.qtdeDev = qtdeDev
    }

}
