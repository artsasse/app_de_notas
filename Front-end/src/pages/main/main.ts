import { Component } from '@angular/core';
import { Annotation, AnnotationService } from '../../app/services/annotation/annotation';
import { ToastController, AlertController, Loading, LoadingController, IonicPage, NavController, App } from 'ionic-angular';
/**
 * Generated class for the MainPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-main',
  templateUrl: 'main.html',
})
export class MainPage {
  loader: Loading;
  annotations: Annotation[] = [];
  CanEdit: boolean;
  markedAnnotation: Annotation;
  constructor(
    private annotationService: AnnotationService,
    private alertCtrl: AlertController,
    private toastCtrl: ToastController,
    public loadingCtrl: LoadingController,
    public app:App,
    public navCtrl: NavController,
    
    
    ){
  }
  
  ngOnInit() {
    this.initLoader();
    this.loadAnnotations();  
    this.canEdit();
    
   
  }
  
  showInputAlert() {
    let prompt = this.alertCtrl.create({
      title: 'Adicionar novos itens',
      message: "Adicionar novas tarefas para nossa lista",
      inputs: [ 
      { name: 'title', placeholder: 'Escreva o título aqui' },
      { name:'content', placeholder: 'Escreva o conteúdo aqui'}
    ],
      buttons: [
        { text: 'Cancelar' },
        {
          text: 'Adicionar',
          handler: data => {
            this.annotationService.add(data.title, data.content).subscribe(
              response => {
                if(data.title == "" || data.title == null || data.content == "" || data.content == null){
                  return;
                }
                let annotation: Annotation = {
                  name: data.title,
                  done: false,
                  content: data.content
                };
                this.annotations.unshift(annotation)
              }
            );
          }
        }
      ]
    });
    prompt.present();
  }
  deleteAction(){
    this.annotations = this.annotations.filter((annotation: Annotation) => !annotation.done);
    this.annotationService.saveAll(this.annotations).subscribe(
      done => {
        this.presentToast(
          "Os itens foram deletados"
        )
      } 
    );
  }
  canDelete(): boolean {
    return !!this.annotations && !!this.annotations.find(annotation => annotation.done);   
   
  }
  canEdit():boolean{
    this.CanEdit = !!this.annotations && this.annotations.filter((annotation: Annotation) => annotation.done).length == 1;   
    return this.CanEdit;  
  }
  updateItemState(evt:any, annotation: Annotation) {  
    if(evt){
      let index: number = this.annotations.indexOf(annotation);
      if (~index){
        if (annotation.done == true) {      
          annotation = this.annotations[index]
          this.annotations.splice(index, 1);
          this.annotations.push(annotation);
          
        }
        this.annotationService.saveAll(this.annotations).subscribe(
          done => {
            this.presentToast(
              "O item foi " + (annotation.done ? "marcado" : "desmarcado")
            )
          }
        );
        
      }
      
    } 
    
  }
  
  private presentToast(message: string) {
    this.toastCtrl.create({message: message, duration: 500}).present();
  }

  private initLoader() {
    this.loader = this.loadingCtrl.create({
      content: "Carregando itens"
    });
    
  }
  
  private loadAnnotations() {
    this.loader.present().then(() => {
      this.annotationService.fetch().subscribe(
        data => {
          this.annotations = data;
          this.loader.dismiss();
        }
      );
    })
  }
  showEditAlert() {
    let prompt = this.alertCtrl.create({
      title: 'Editar item atual',
      message: "Editar tarefa(s) marcada(s)",
      inputs: [
        { name: 'title', placeholder: 'Escreva o título aqui' },
        { name:'content', placeholder: 'Escreva o conteúdo aqui'},
      ],
      buttons: [
        { text: 'Cancelar' },
        {
          text: 'Concluir',
          handler: data => {
            if(data.title == "" || data.title == null || data.content == "" || data.content == null){
              return;
            }
            this.annotations = this.annotations.filter((annotation: Annotation) => !annotation.done);
            this.annotationService.saveAll(this.annotations)
            this.annotationService.add(data.title, data.content).subscribe(
              response => {
                let annotation: Annotation = {
                  name: data.title,
                  done: false,
                  content: data.content

                };
                this.annotations.unshift(annotation)
              }
            );
          }
        }
      ]
    });
    prompt.present();
  }
  

  
}
