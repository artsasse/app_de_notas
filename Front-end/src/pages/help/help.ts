import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, AlertController } from 'ionic-angular';

/**
 * Generated class for the HelpPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-help',
  templateUrl: 'help.html',
})
export class HelpPage {

  constructor(public navCtrl: NavController, public navParams: NavParams, public alertCtrl:AlertController) {
  }
  helpAdd(){
    this.presentAlert("Adicionar um elemento", "Este botão simplesmente adiciona uma anotação em nossa lista")
  }
  helpDelete(){
    this.presentAlert("Excluir elemento(s)", "Este botão exclui um ou mais elementos selecionados")
  }
  helpEdit(){
    this.presentAlert("Editar um elemento", "Este botão só pode ser ativado quando somente um elemento é selecionado podendo edita-lo")
  }
  helpCheckBox(){
    this.presentAlert("Marca elemento(s)", "Este botão marca um ou mais elementos para fazer as operações acima")
  }
  presentAlert(title:string, subTitle:string) {
    let alert = this.alertCtrl.create({
      title: title,
      subTitle: subTitle,
      buttons: ['ok']
    });
    alert.present();
  }
}
