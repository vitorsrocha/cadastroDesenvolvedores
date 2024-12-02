import { Routes } from '@angular/router';
import { ListDeveloperComponent } from './view/page/developer/list-developer/list-developer.component';
import { ListLevelComponent } from './view/page/level/list-level/list-level.component';

export const routes: Routes = [
    { path: 'desenvolvedores', component: ListDeveloperComponent},
    { path: 'niveis', component: ListLevelComponent},
    { path: '', redirectTo: '/desenvolvedores', pathMatch: 'full' }, 
    { path: '**', redirectTo: '/desenvolvedores' }
];
