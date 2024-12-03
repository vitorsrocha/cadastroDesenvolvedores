import { AfterViewInit, Component, inject, ViewChild } from '@angular/core';
import { MaterialModule } from '../../../shered/material/material.module';
import { Level } from '../../../../model/level';
import { LevelService } from '../../../../service/level.service';
import { ModalRegisterLevelComponent } from '../modal-register-level/modal-register-level.component';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatTableDataSource } from '@angular/material/table';
import { MatSort } from '@angular/material/sort';
import { DialogComponent } from '../../../component/dialog/dialog.component';
import { FormControl, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-list-level',
  standalone: true,
  imports: [MaterialModule, ReactiveFormsModule],
  templateUrl: './list-level.component.html',
  styleUrl: './list-level.component.scss'
})
export class ListLevelComponent implements AfterViewInit {
  displayedColumns: string[] = ['id', 'nivel', 'qtdeDev', "opcoes"];
  levels: Level[] = [];
  dataSource: MatTableDataSource<Level>
  filterControl = new FormControl('');

  private _snackBar = inject(MatSnackBar);

  @ViewChild(MatSort) sort!: MatSort;

  constructor(private levelService: LevelService,
    private dialog: MatDialog
  ) {
    this.dataSource = new MatTableDataSource(this.levels);
    this.listAll()
  }

  ngAfterViewInit() {
    if (this.sort) {
      this.dataSource.sort = this.sort;
    }
  }

  listAll() {
    this.levelService.listlevel().subscribe({
      next: (data: Level[]) => {
        this.levels = data;
        this.dataSource.data = data;
      }, error: (error) => {
        console.error(error);
      }
    });
  }

  register() {
    this.dialog.open(ModalRegisterLevelComponent, {
      disableClose: true,
      width: "800px",
      data: ""
    }).afterClosed().subscribe(() => {
      this.listAll()
    });
  }

  edit(element: Level) {
    this.dialog.open(ModalRegisterLevelComponent, {
      disableClose: true,
      width: "800px",
      data: element
    }).afterClosed().subscribe(() => {
      this.listAll()
    });

  }

  delete(id: number) {
    this.levelService.delete(id).subscribe({
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
        title: 'Excluir nivel',
        message: 'Deseja realmente excluir o nivel?'
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
    this.levelService.filter(this.filterControl.value?? "").subscribe({
      next: (data: Level[]) => {        
        this.levels = data;
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
