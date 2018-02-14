import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { MenuPage } from '../menu/menu';
import { WelcomePage} from '../welcome/welcome'
import { UserService } from '../../app/services/user/user.service'
import { User } from '../../app/services/user/user'
import { AlertController } from 'ionic-angular';
/**
 * Generated class for the LoginPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {
  isEnable:boolean;
  user: User;
  constructor(
    public navCtrl: NavController, 
    private alertCtrl: AlertController, 
    private userService: UserService,
  ){

  }
  username:string;
  password:string;

  doLogin() {
    this.user = {
      username: this.username,
      name: "",
      password:this.password
    }
    if(!this.username || !this.password){
      this.presentAlert("Erro", "Todos os campos são obrigatórios")
      this.navCtrl.setRoot(WelcomePage);
    }
    else if(this.userService.loginUser(this.user)){
      this.presentAlert("Login", "Seu login foi um sucesso") 
      this.navCtrl.setRoot(MenuPage);
    }
    else{
      this.presentAlert("Erro", "Credenciais inválidas")
      this.navCtrl.setRoot(WelcomePage);
    }
    
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
