export class OutDeveloper {
    id?: number | null = null
    nivel_id?: number = 0
    nome?: string = ""
    sexo?: string = ""
    data_nascimento?: string = ""
    hobby?: string = ""

    constructor(
        id?: number | null,
        nivel_id?: number,
        nome?: string,
        sexo?: string,
        data_nascimento?: string,
        hobby?: string
    ){

        this.id = id;
        this.nivel_id = nivel_id;
        this.nome = nome;
        this.sexo = sexo;
        this.data_nascimento = data_nascimento;
        this.hobby = hobby
    }
}