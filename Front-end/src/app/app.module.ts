import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';
import { SplashScreen } from '@ionic-native/splash-screen';
import { StatusBar } from '@ionic-native/status-bar';
import { MyApp } from './app.component';
import { AnnotationService, AnnotationLocalStorageService } from "./services/annotation/annotation";
import { SignupPage } from '../pages/signup/signup';
import { TabsPage } from '../pages/tabs/tabs';
import { MenuPage } from '../pages/menu/menu';
import { UserService } from './services/user/user.service';
import { LoginPage } from '../pages/login/login'
@NgModule({
  declarations: [
    MyApp,
    SignupPage,
    MenuPage,
    LoginPage
  ],
  imports: [
    BrowserModule,
    IonicModule.forRoot(MyApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    SignupPage,    
    LoginPage,
    MenuPage,
  ],
  providers: [
    StatusBar,
    SplashScreen,
    AnnotationService,
    AnnotationLocalStorageService,
    UserService,
    {provide: ErrorHandler, useClass: IonicErrorHandler},
  ]
})
export class AppModule {}
