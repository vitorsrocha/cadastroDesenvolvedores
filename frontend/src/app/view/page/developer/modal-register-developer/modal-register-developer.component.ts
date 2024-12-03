import { Component, inject, Inject } from '@angular/core';
import { MaterialModule } from '../../../shered/material/material.module';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Level } from '../../../../model/level';
import { DeveloperService } from '../../../../service/developer.service';
import { ReactiveFormsModule } from '@angular/forms';
import { InDeveloper } from '../../../../model/in-developer';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  selector: 'app-modal-register-developer',
  imports: [MaterialModule, ReactiveFormsModule],
  templateUrl: './modal-register-developer.component.html',
  styleUrl: './modal-register-developer.component.scss'
})
export class ModalRegisterDeveloperComponent {
  formulario: FormGroup;

  levels?: Level[]
  developer?: InDeveloper
  private _snackBar = inject(MatSnackBar);

  constructor(private develperService: DeveloperService,
              public dialogRef: MatDialogRef<ModalRegisterDeveloperComponent>, 
              private fb: FormBuilder, 
              @Inject(MAT_DIALOG_DATA) public data:{ levels: Level[], developer: InDeveloper }) { 

    this.formulario = this.fb.group({
      nome: ['', [Validators.required, Validators.maxLength(50)]],
      sexo: ['', Validators.required],
      data_nascimento: ['', Validators.required],
      hobby: ['',[Validators.required, Validators.maxLength(50)]],
      nivel: ['', Validators.required]
    });

    this.levels = data.levels
    if(data.developer){
      this.developer = data.developer
      this.loadForm()
    }
  }

  close(): void {
    this.dialogRef.close();
  }
  
  save(){
    if (this.formulario.valid) {
      let form = this.formulario.value
      let developer = new InDeveloper(
        null,
        form.nivel,
        form.nome,
        form.sexo,
        form.data_nascimento,
        form.hobby
      )

      if(this.developer?.id){
        this.develperService.update(developer, this.developer?.id).subscribe({
          next: () => {
            this.close()
            this._snackBar.open("Alterado com sucesso!", "Sair", {
              duration: 3000
            });
          },
          error: (error) => {
              console.error(error);
              this._snackBar.open(`Erro ao alterar, ${error.error}`, "Sair", {
                duration: 3000
              });
          }
        });  
        return
      }

      this.develperService.save(developer).subscribe({
        next: () => {
          this.close()
          this._snackBar.open("Salvo com sucesso!", "Sair", {
            duration: 3000
          });
        },
        error: (error) => {
            console.error(error);
            this._snackBar.open(`Erro ao salvar, ${error.error}`, "Sair", {
              duration: 3000
            });
          }
        });  
      
    } else {
      this._snackBar.open("Formulario invalido!", "Sair", {
        duration: 3000
      });
    }
  }

  loadForm(){
    this.formulario.controls['nome'].setValue(this.developer?.nome)
    this.formulario.controls['sexo'].setValue(this.developer?.sexo)
    this.formulario.controls['data_nascimento'].setValue(this.developer?.data_nascimento)
    this.formulario.controls['nivel'].setValue(this.developer?.nivel?.id)
    this.formulario.controls['hobby'].setValue(this.developer?.hobby)

  }

}
