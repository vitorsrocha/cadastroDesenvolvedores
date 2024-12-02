import { Component } from '@angular/core';
import { MaterialModule } from '../../../shered/material/material.module';
import { HttpClientModule } from '@angular/common/http';
import { DeveloperService } from '../../../../service/developer.service';

export interface UsersElement {
  id: number,
  nivel: string,
  nome: string;
  sexo: string;
  dataNascimento: string
}

const ELEMENT_DATA: UsersElement[] = [
  {id: 1, nivel: 'junior', nome: "vitor", sexo: 'M', dataNascimento: '16/12/1996'},
  {id: 2, nivel: 'pleno', nome: "vitor rocha", sexo: 'M', dataNascimento: '16/12/1996'},
];

@Component({
  selector: 'app-list-developer',
  standalone: true,
  imports: [MaterialModule , HttpClientModule],
  templateUrl: './list-developer.component.html',
  styleUrl: './list-developer.component.scss',
})
export class ListDeveloperComponent {
  displayedColumns: string[] = ['id', 'nivel', 'nome', 'sexo', 'dataNascimento', "opcoes"];
  dataSource = ELEMENT_DATA;

  constructor(private developerService: DeveloperService){    
    this.listAll()
  }

  listAll(){
    console.log("res",this.developerService.getDevelopers())
  }

  edit(element: UsersElement){
    console.log(element);
    
  }

  delete(element: UsersElement){
    console.log(element);
  }
}
