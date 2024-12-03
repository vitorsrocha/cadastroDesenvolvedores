import { AfterViewInit, ChangeDetectionStrategy, Component, inject, ViewChild } from '@angular/core';
import { MaterialModule } from '../../../shered/material/material.module';
import { DeveloperService } from '../../../../service/developer.service';
import { MatDialog } from '@angular/material/dialog';
import { ModalRegisterDeveloperComponent } from '../modal-register-developer/modal-register-developer.component';
import { LevelService } from '../../../../service/level.service';
import { Level } from '../../../../model/level';
import { InDeveloper } from '../../../../model/in-developer';
import { OutDeveloper } from '../../../../model/out-developer';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { DialogComponent } from '../../../component/dialog/dialog.component';
import { FormControl, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-list-developer',
  standalone: true,
  imports: [MaterialModule, ReactiveFormsModule],
  templateUrl: './list-developer.component.html',
  styleUrl: './list-developer.component.scss',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ListDeveloperComponent implements AfterViewInit {
  displayedColumns: string[] = ['id', 'nivel', 'nome', 'sexo', 'dataNascimento', 'hobby', "opcoes"];
  developers: OutDeveloper[] = [];
  dataSource: MatTableDataSource<OutDeveloper>
  filterControl = new FormControl('');

  private levels: Level[] = []
  private _snackBar = inject(MatSnackBar);

  @ViewChild(MatSort) sort!: MatSort;


  constructor(private developerService: DeveloperService,
    private levelService: LevelService,
    private dialog: MatDialog) {
    this.dataSource = new MatTableDataSource(this.developers);
    this.listAll()
    this.listAllLevel()
  }

  ngAfterViewInit() {
    if (this.sort) {
      this.dataSource.sort = this.sort;
    }
  }

  listAll() {
    this.developerService.listAll().subscribe({
      next: (data: OutDeveloper[]) => {
        this.developers = data;
        this.dataSource.data = data;
      },
      error: (error) => {
        console.error(error);
        this._snackBar.open(`Erro ao listar desenvolvedores, ${error.error}`, "Sair", {
          duration: 3000
        });
      }
    });
  }

  listAllLevel() {
    this.levelService.listlevel().subscribe({
      next: (data: Level[]) => {
        this.levels = data;
      },
      error: (error) => {
        console.error(error);
        this._snackBar.open(`Erro ao listar nivel, ${error.error}`, "Sair", {
          duration: 3000
        });
      }
    });
  }

  register() {
    this.dialog.open(ModalRegisterDeveloperComponent, {
      disableClose: true,
      width: "800px",
      data: {
        levels: this.levels,
        developer: []
      }
    }).afterClosed().subscribe(() => {
      this.listAll()
    });
  }

  edit(element: InDeveloper) {
    this.dialog.open(ModalRegisterDeveloperComponent, {
      disableClose: true,
      width: "800px",
      data: {
        levels: this.levels,
        developer: element
      }
    }).afterClosed().subscribe(() => {
      this.listAll()
    });

  }

  delete(id: number) {
    this.developerService.delete(id).subscribe({
      next: () => {
        this._snackBar.open("Excludo com sucesso!", "Sair", {
          duration: 3000
        });

        if (this.dataSource.data.length == 1) {
          this.dataSource.data = []
          return
        }

        this.listAll()
      },
      error: (error) => {
        console.error(error);
        this._snackBar.open(`Erro ao excluir, ${error.error}`, "Sair", {
          duration: 3000
        });
      }
    });
  }

  openDialog(id: number) {
    this.dialog.open(DialogComponent, {
      width: '250px',
      data: {
        title: 'Excluir desenvolvedor',
        message: 'Deseja realmente excluir o desenvolvedor?'
      }
    }).afterClosed().subscribe(result => {
      if (result) {
        this.delete(id)
      }
    });
  }

  search(){    
    if(this.filterControl.value == ""){
      this.listAll()
      return
    }
    this.developerService.filter(this.filterControl.value?? "").subscribe({
      next: (data: OutDeveloper[]) => {        
        this.developers = data;
        this.dataSource.data = data;

        if(data.length <= 0){
          this._snackBar.open(`Nenhum registro encontrado.`, "Sair", {
            duration: 3000
          });
        }
        
      },
      error: (error) => {
        console.error(error);
        this._snackBar.open(`Erro ao listar desenvolvedores, ${error.error}`, "Sair", {
          duration: 3000
        });
      }
    });
  }
}
