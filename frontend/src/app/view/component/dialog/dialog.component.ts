import { Component, Inject, inject } from '@angular/core';
import { MaterialModule } from '../../shered/material/material.module';
import { MAT_DIALOG_DATA, MatDialogClose, MatDialogContent, MatDialogRef, MatDialogTitle } from '@angular/material/dialog';

@Component({
  selector: 'app-dialog',
  imports: [MaterialModule, MatDialogClose, MatDialogTitle, MatDialogContent],
  templateUrl: './dialog.component.html',
  styleUrl: './dialog.component.scss'
})
export class DialogComponent {
  readonly dialogRef = inject(MatDialogRef<DialogComponent>);

  constructor(@Inject(MAT_DIALOG_DATA) public data: { title: string; message: string }) {}

}
