import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Level } from '../model/level';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LevelService {
  private apiUrl = 'http://localhost:81/api/level';

  constructor(private http: HttpClient) {}

  listlevel(): Observable<Level[]> {
    return this.http.get<Level[]>(this.apiUrl)
  }

  save(level: Level): Observable<Level> {
    return this.http.post<Level>(this.apiUrl, level)
  }

  update(level: Level, id: number): Observable<Level> {
    return this.http.put<Level>(this.apiUrl + `?id=${id}`, level)
  }

  delete(id: number): Observable<boolean> {
    return this.http.delete<boolean>(this.apiUrl + `?id=${id}`)
  }
  
  filter(value: string): Observable<Level[]> {
    return this.http.get<Level[]>(this.apiUrl + `/filter?value=${value}`)
  }
}
