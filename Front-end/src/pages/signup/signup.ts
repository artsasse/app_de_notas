import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';
import { AlertController } from 'ionic-angular';
import { UserService } from '../../app/services/user/user.service'
import { User } from '../../app/services/user/user'
import { WelcomePage } from '../welcome/welcome';
/**
 * Generated class for the SignupPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
@IonicPage()
@Component({
  selector: 'page-signup',
  templateUrl: 'signup.html',
})
export class SignupPage {

  name:string;
  username:string;
  password1:string;
  password2:string;
  user:User;
  
  constructor(
    private alertCtrl: AlertController, 
    public navCtrl: NavController, 
    private userService: UserService,
  
  ){

  }
  signUp(){
    if(!this.name || !this.username || !this.password1 || !this.password2){
      this.presentAlert("Erro", "Todos os campos são obrigatórios");  
      this.navCtrl.setRoot(WelcomePage);
    }
    else if(!this.userService.allUsers() || !this.userService.allUsers().length || 
      this.userService.allUsers().every((user:User)=>{
          return (user.name != this.name);
      })
    ){
      if(this.password1 == this.password2){
        this.user = {
          name: this.name,
          username: this.username,
          password: this.password1

        }
        this.userService.addUser(this.user);
        this.presentAlert("Conta Criada", "Usuário criado com sucesso");
        this.navCtrl.setRoot(WelcomePage);
      }
      else{
        this.presentAlert("Erro", "As senhas não conferem");  
        this.navCtrl.setRoot(WelcomePage);
      }

    }
    else{
      this.presentAlert("Erro", "Esse usuário já existe");   
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

