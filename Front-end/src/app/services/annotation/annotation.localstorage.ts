import { Injectable } from "@angular/core";
import { Observable } from "rxjs/rx"
import { Annotation, AnnotationService } from "../annotation/annotation"

@Injectable()
export class AnnotationLocalStorageService {
    storageKey: string = "annotations";
    fetch() : Observable<Annotation[]> {
        return Observable.of(this.fetchRaw());
    }

    add(title: string, content: string): Observable<boolean> {
        let data: Annotation = {
            name: title,
            content: content,
            done: false,
        };

        let annotations: Annotation[] = this.fetchRaw();
        annotations.unshift(data);

        return Observable.of(this.saveAnnotations(annotations));
    }

    saveAll(annotations: Annotation[]): Observable<boolean> {
        let saved: boolean = this.saveAnnotations(annotations);

        return Observable.of(saved);
    }

    private fetchRaw(): Annotation[] {
        let annotations: any = localStorage.getItem('annotations');
        let items: Annotation[] = annotations ? JSON.parse(annotations) : [];

        return items;
    }

    private saveAnnotations(annotations: Annotation[]): boolean {
        if ( ! annotations || annotations.length < 0) {
            return false;
        }

        localStorage.setItem(this.storageKey, JSON.stringify(annotations));
        return true;
    }
}