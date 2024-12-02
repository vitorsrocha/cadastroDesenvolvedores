import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Developer } from '../model/developer';
import { map, Observable, tap } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DeveloperService {
  private apiUrl = 'http://localhost:81/api/developer';

  constructor(private http: HttpClient) {}

  getDevelopers(): Observable<Developer[]> {
    return this.http.get<Developer[]>(this.apiUrl)
  }
}
