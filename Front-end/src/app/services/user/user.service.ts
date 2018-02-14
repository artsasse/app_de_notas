import { Injectable } from '@angular/core';
import { User } from './user';

@Injectable()
export class UserService {
  constructor() {

  }
  users: User[] = [];
    
  addUser(user: User){
    this.users.push(user);
  }
  allUsers(){
    return this.users;
  }
  loginUser(user: User){
    return !!this.users && !!this.users.length 
     && this.users.every((otherUser:User)=>{
        return otherUser.username == user.username && otherUser.password == user.password;
          
      });
  }
  
}


