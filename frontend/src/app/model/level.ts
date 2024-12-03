export class Level {
    id: number | null = null
    nivel: string = ""

    constructor(
        id: number | null, 
        nivel: string
    ){
        this.id = id
        this.nivel = nivel
    }

}
