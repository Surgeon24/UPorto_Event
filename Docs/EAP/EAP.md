# EAP: Architecture Specification and Prototype
## A7: Web Resources Specification
/*
   **_all comments to be deleted before delivery_**

   **If you want to change/add anything - ask or JUST TO IT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!** (c) David

   */

//need to be changed according to the specific of our project

This artifact documents the  architecture of the "UPorto event", indicating the catalog of resources, permissions used in the modules, and the format of JSON responses and defining specifications using OpenAPI standard.



### 1. Overview

This section provides a short description of the web part of the 
application, in which all modules are defined and briefly described. More information about web resources associated with each module can be found in each module's separate documentation in the OpenAPI specification.



|   Module   | Description    |
| --------- | ---------- |
|  M01 - Authentication and Individual Profile    | Web component that concerns itself with the user's authentication and each user's profile. It covers, inter alia, login/logout, registration and view and edit profile data. 	|
|  M02 - Events   | Web component that deals with event creation, management and promotion. Among others, contains Polls, Tags and Comments APIs. 	|
|  M03 - Notifications   | Web component that handles notifications. |
|  M04 - User Administration and Static pages   | Web resources associated with user management such as view, search and delete users, view and change user information, manage reports and user support tickets. Web resources with static content are associated with this module: dashboard, search, contact, about. 	|




### 2. Permissions

This section defines the permissions used by each module, required to access its data and features.

// PAR permission added. Opinions?

|  Abbreviation   |  Permission type | Description |
| --------- | ---------- | ---------- |
|  **PUB**   | Public	| Unauthenticated users  |
|  **USR**   | User	| Authenticated users, have priviliges over their profile pages  |
|  **OWN**   | Owner	| Users who created events, have priviliges on their own events |
|  **COM**   | Comment Author | User who authored an comment can delete it |
|  **PAR**   | Event participant | User who take part in an event |
|  **ADM**   | Administrator	| Users with extended permissions, system managers, super users |

### 3. OpenAPI Specification

This section describes the web application's web resources with OpenAPI specification in YAML format.


[OpenAPI](https://git.fe.up.pt/lbaw/lbaw2223/lbaw22122/-/blob/main/Docs/EAP/a7_openapi.yml)

[On swaggerhub](https://app.swaggerhub.com/apis/lbaw22122_Event/UPortoEvent/1.0)



## A8: Vertical Prototype
The Vertical Prototype is intended to validate the presented architecture, as well as to familiarize yourself with the technologies used in the project. It contains implementation of main features  that are represented in requirements documents.

### 1. Implemented Features

#### 1.1. Implemented User Stories



|ID   | Actor    | Name      |Priority | Description |
| --- | -----    | ----      | ------- | ----------- |
|vi01 | Visitor  | Log In    | High    | As a visitor, I want to be able to log-in, to get a status of authenticated user. |
|au04 |Auth. user| Log Out   | High    | As an authenticated user, I want to be able to log out from service for privacy purposes. |
|vi02 | Visitor  | Sign Up   | High    |As a visitor, I want to be able to create my profile on the site to become an authenticated user. |


#### 1.2. Implemented Web Resources


**M01 - Authentication and Individual Profile**

| Web Resource Reference | URL |
|  ------------------    | --- |

**M02 - Events**


| Web Resource Reference | URL |
| ---------------------- | --- |


**M03 - Notifications**

| Web Resource Reference | URL |
| ---------------------- | --- |


**M04 - User Administration and Static pages**

| Web Resource Reference | URL |
| ---------------------- | --- |


### 2. Prototype


## Revision history

1. 
2. 
***
GROUP21122, 20/11/2022

* João Sousa, up201904739@up.pt    
* Mikhail Ermolaev, up202203498@up.pt
* David Burchakov, up202203777@up.pt
* Válter Castro, up201706546@up.pt
