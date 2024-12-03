import { Component, inject, Inject } from '@angular/core';
import { MaterialModule } from '../../../shered/material/material.module';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Level } from '../../../../model/level';
import { ReactiveFormsModule } from '@angular/forms';
import { MatSnackBar } from '@angular/material/snack-bar';
import { LevelService } from '../../../../service/level.service';

@Component({
  selector: 'app-modal-register-level',
  imports: [MaterialModule, ReactiveFormsModule],
  templateUrl: './modal-register-level.component.html',
  styleUrl: './modal-register-level.component.scss'
})
export class ModalRegisterLevelComponent {
  formulario: FormGroup;

  level?: Level
  private _snackBar = inject(MatSnackBar);

  constructor(private levelService: LevelService,
              public dialogRef: MatDialogRef<ModalRegisterLevelComponent>, 
              private fb: FormBuilder, 
              @Inject(MAT_DIALOG_DATA) public data: Level) { 

    this.formulario = this.fb.group({
      nivel: ['',[Validators.required, Validators.maxLength(50)]]
    });

    if(data){
      this.level = data
      this.loadForm()
    }
  }

  close(): void {
    this.dialogRef.close();
  }
  
  save(){
    if (this.formulario.valid) {
      let form = this.formulario.value
      let level = new Level(null,form.nivel)

      if(this.level?.id){
        this.levelService.update(level, this.level?.id).subscribe({
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

      this.levelService.save(level).subscribe({
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
    this.formulario.controls['nivel'].setValue(this.level?.nivel)
  }

}
