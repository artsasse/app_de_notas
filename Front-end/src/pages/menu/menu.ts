import { Component, ViewChild } from '@angular/core';
import { IonicPage, Nav, NavController, NavParams, App } from 'ionic-angular';
import { WelcomePage } from '../welcome/welcome';
import { MainPage } from '../main/main';
import { HelpPage } from '../help/help';

export interface PageInterface {
  title: string;
  pageName: string;
  tabComponent?: any;
  index?: number;
  icon: string;
}

@IonicPage()
@Component({
  selector: 'page-menu',
  templateUrl: 'menu.html',
})
export class MenuPage {
  // Para carregar as tab
  rootPage = 'TabsPage';

  // Referência para nossa root nav
  @ViewChild(Nav) nav: Nav;

  pages: PageInterface[] = [
    { title: 'Notas', pageName: 'TabsPage', tabComponent: 'MainPage', index: 0, icon: 'home' },
    { title: 'Help', pageName: 'TabsPage', tabComponent:'HelpPage', index: 1, icon: 'help'},
   
  ];

  constructor(public navCtrl: NavController, 
    public app:App, 
    public navParams: NavParams, 
  ){
     
   }
  
  openPage(page: PageInterface) {
    let params = {};
    // O indice corresponde a ordem que criamos na nossa interface
    if (page.index) {
      params = { tabIndex: page.index };
    }

    // A página ativa em nossa navegacao por Tabs
    if (this.nav.getActiveChildNav() && page.index != undefined) {
      this.nav.getActiveChildNav().select(page.index);
    } else {
      // Se as Tabs nao estao ativas entao mudar para a pagina atual
      this.nav.setRoot(page.pageName, params);
      
    }
  }

  isActive(page: PageInterface) {
    // Check se está ativa
    let childNav = this.nav.getActiveChildNav();
  
    if (childNav) {
      if (childNav.getSelected() && childNav.getSelected().root === page.tabComponent) {
        return 'primary';
      }
      return;
    }

    // Para selecionar a cor
    if (this.nav.getActive() && this.nav.getActive().name === page.pageName) {
      return 'primary';
    }
    return;
  }
  logout(){
    // Remover token da api 
    // const root = this.app.getRootNav();
    // root.popToRoot();
    this.navCtrl.setRoot(WelcomePage);
  }
 
}
