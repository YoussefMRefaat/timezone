# Timezone - Watch Shop

## Introduction

I built this project using ***Laravel*** to practice on what I had learned in backend development.

## Idea

This API serves a web application of a watches shop called Timezone to help in selling the watches online.


### Check [Reference Documentation](https://github.com/YoussefMRefaat/timezone/wiki) for details about endpoints

## Features

There are four types of roles in this application :-
- Moderator
- Admin
- User
- Guest


 Moderators' accounts are provided by the developer.

#### All authenticated accounts can :-
1- Update their information and password <br>
2- Verify their email <br>
3- Logout

#### Moderators can :-
1- Create, read, and delete accounts of admins <br>
2- all admins' features

#### Admins can :-
1- Create, update, read, and delete watches <br>
2- Read users' information and their orders <br>
3- Read all orders <br>
4- Update orders to be shipped, delivered, or cancelled

#### Users can :-
1- Read watches (in less details than admins) <br>
2- Add watches to the cart <br>
3- Show cart's details <br>
4- Update the quantity of a watch in the cart  <br>
5- Delete watches from the cart <br>
6- Make an order <br>
7- Show and track his orders <br>

#### Guests can :-
1- Signup <br>
2- Login <br>
3- Reset password <br>
4- Read watches

## Entity relationship diagram
![ERD](ERD.png)

## License

[MIT license](https://opensource.org/licenses/MIT).


