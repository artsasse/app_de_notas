import { Component } from '@angular/core';
import { IonicPage, NavParams, Nav } from 'ionic-angular';
import { MainPage } from '../main/main';
import { HelpPage } from '../help/help';

import { Tabs } from 'ionic-angular/components/tabs/tabs';
@IonicPage()
@Component({
  selector: 'page-tabs',
  templateUrl: 'tabs.html',
})
export class TabsPage {
  param:boolean;
  tab1Root: any = 'MainPage';
  tab2Root: any = 'HelpPage';
  myIndex: number;
  
  constructor(
    public navParams: NavParams, 
    private nav:Nav
  ){
    // selecionar o index da tab ativa baseada no menu
    this.myIndex = navParams.data.tabIndex || 0;
  }


  
}