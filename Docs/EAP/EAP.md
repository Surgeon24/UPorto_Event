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

**//** Comments and Polls are inside Events. You can change/add the description **(c) David.**
|   Module   | Description    |
| --------- | ---------- |
|  M01 - Authentication and Individual Profile    | Web component that concerns itself with the user's authentication and each user's profile. It covers, inter alia, login/logout, registration, credential recovery and view and edit profile data. 	|
|  M02 - Events   | Web component that deals with event creation, management and promotion. 	|
|  M03 - Notifications   | Web component that handles notifications. Namely, notification pop-ups. |
|  M04 - Administration   | Web component connected with user and system control(management). Specifically: user deletion, changing system static information (i.e. about, contacts, home etc.), managing user reports. 	|


### 2. Permissions

This section defines the permissions used by each module, required to access its data and features.

|  Abbreviation   |  Permission type | Description |
| --------- | ---------- | ---------- |
|  **PUB**   | Public	| Unauthenticated users  |
|  **USR**   | User	| Authenticated users, have priviliges over their profile pages  |
|  **OWN**   | Owner	| Users who created events, have priviliges on their own events |
|  **COM**   | Comment Author | User who authored an comment can delete it |
|  **ADM**   | Administrator	| Users with extended permissions, system managers, super users |

### 3. OpenAPI Specification

* OpenAPI specification in YAML format to describe the vertical prototype's web resources.

* Link to the a7_openapi.yaml file in the group's repository.




## A8: Vertical Prototype
The Vertical Prototype is intended to validate the presented architecture, as well as to familiarize yourself with the technologies used in the project. It contains implementation of main features  that are represented in requirements documents.

### 1. Implemented Features

#### 1.1. Implemented User Stories

// Please fill User Stories (c) David

| User Story | Name | Priority | Description |
| ---------- | ---- | -------- | ----------- |
|            |     	|          |             |

#### 1.2. Implemented Web Resources

**M01 - Authentication and Individual Profile**


| Web Resource Reference | URL |
|  ------------------    | --- |
|  R101: Sign In Form    | --- |
|  R102: Sign In Action  | --- |
|  R103: Logout Action   | --- |
|  R104: Sign Up Form    | --- |
|  R105: Sign Up Action  | --- |
|  R106: View User Profile | --- |
|  R107: Edit Profile    | --- |
|  R108: Delete Account  | --- |
|  R109: View Account Settings | --- |
|  R110: Edit Account Settings | --- |
|  R111: Get Avatar      | --- |


**M02 - Events**

| Web Resource Reference | URL |
| ---------------------- | --- |
| R201: Serach Event API | --- |

**M03 - Comments**

| Web Resource Reference | URL |
| ---------------------- | --- |

**M04 - Polls**

| Web Resource Reference | URL |
| ---------------------- | --- |

**M05 - Notifications**

| Web Resource Reference | URL |
| ---------------------- | --- |

**M06 - Administration**

| Web Resource Reference | URL |
| ---------------------- | --- |

### 2. Prototype


## Revision history

1. template was created. Some comments were added. // [ Isn't revision needed for changes after deadline? ] (c) David.
2. 
***
GROUP21122, 16/11/2022

* João Sousa, up201904739@up.pt    
* Mikhail Ermolaev, up202203498@up.pt
* David Burchakov, up202203777@up.pt
* Válter Castro, up201706546@up.pt
