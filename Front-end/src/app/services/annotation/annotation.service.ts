import { Injectable } from "@angular/core"
import { Observable } from "rxjs/rx"
import { Annotation, AnnotationLocalStorageService } from "../annotation/annotation"

@Injectable()
export class AnnotationService {
    constructor(private driver: AnnotationLocalStorageService) {
    }

    fetch(): Observable<Annotation[]> {
        return this.driver.fetch()
    }

    add(title: string, content: string): Observable<boolean> {
        return this.driver.add(title, content);
    }

    saveAll(annotations: Annotation[]): Observable<boolean> {
        return this.driver.saveAll(annotations);
    }
}