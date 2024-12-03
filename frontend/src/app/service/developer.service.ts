import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { OutDeveloper } from '../model/out-developer';
import { InDeveloper } from '../model/in-developer';

@Injectable({
  providedIn: 'root'
})
export class DeveloperService {
  private apiUrl = 'http://localhost:81/api/developer';

  constructor(private http: HttpClient) {}

  listAll(): Observable<OutDeveloper[]> {
    return this.http.get<OutDeveloper[]>(this.apiUrl)
  }

  save(developer: OutDeveloper): Observable<OutDeveloper> {
    return this.http.post<InDeveloper>(this.apiUrl, developer)
  }

  update(developer: OutDeveloper, id: number): Observable<OutDeveloper> {
    return this.http.put<InDeveloper>(this.apiUrl + `?id=${id}`, developer)
  }

  delete(id: number): Observable<boolean> {
    return this.http.delete<boolean>(this.apiUrl + `?id=${id}`)
  }

  filter(value: string): Observable<OutDeveloper[]> {
    return this.http.get<OutDeveloper[]>(this.apiUrl + `/filter?value=${value}`)
  }
}