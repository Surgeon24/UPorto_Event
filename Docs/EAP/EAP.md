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
|  M01 - Authentication and Individual Profile    | Web component that concerns itself with the user's authentication and each user's profile. It covers, inter alia, login/logout, registration, credential recovery and view and edit profile data. 	|
|  M02 - Events   | Web component that deals with event creation, management and promotion. 	|
|  M03 - Notifications   | Web component that handles notifications. Namely, notification pop-ups. |
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


* Link to the a7_openapi.yaml file in the group's repository.

**// please add link to file called _a7_openapi.yml_ cause I don't remember how**

https://app.swaggerhub.com/apis/lbaw22122_Event/UPortoEvent/1.0



## A8: Vertical Prototype
The Vertical Prototype is intended to validate the presented architecture, as well as to familiarize yourself with the technologies used in the project. It contains implementation of main features  that are represented in requirements documents.

### 1. Implemented Features

#### 1.1. Implemented User Stories



| User Story | Name | Priority | Description |
| ---------- | ---- | -------- | ----------- |
|            |     	|          |             |

#### 1.2. Implemented Web Resources

// something that will be added in the future. Idk where to specify

// invite member API

// Social Media Module, including search users by username

// Reset password UI

**M01 - Authentication and Individual Profile**


// URLs filled without links. Don't know how to associate with UIs and even if we have to do that. Please clarify


| Web Resource Reference | URL |
|  ------------------    | --- |
|  R101: Sign In Form    | GET /login |
|  R102: Sign In Action  | POST /login |
|  R103: Logout Action   | POST /logout |
|  R104: Sign Up Form    | GET /register  |
|  R105: Sign Up Action  | POST /register |
|  R106: View User Profile | GET /users/{id} |
|  R107: Edit Profile    | PATCH /users/{id}/edit  |
|  R108: Delete Account  | DELETE /users/{id} |
|  R109: View Account Settings | GET /settings |
|  R110: Edit Account Settings | PATCH /settings |
|  R111: Get Avatar      | GET /users/id/avatars/{img} |


**M02 - Events**


| Web Resource Reference | URL |
| ---------------------- | --- |
| R201: Search Events API | GET /api/events |
| R202: Create Event     | POST /api/events |
| R203: Get Event Information | GET /api/events/{id} |
| R204: Leave Event      | DELETE /api/events/event_id/{user_id} |
| R205: View Event Overview | GET /events/{id}/overview |
| R206: View Event Preferences | GET /events/{id}/preferences |
| R207: Edit Event       | PATCH /events/{id}/preferences |
| R208: Delete Event     | DELETE /events/{id}/preferences |
| R209: Get Tags         | GET /api/events/{id}/tag |
| R210: Create Tag       | POST /api/events/{id}/tag |
| R211: Delete Tag       | DELETE /api/events/{id}/tag |
| R212: Get Comments     | GET /api/events/{id}/comments |
| R213: Add a comment    | POST /api/{events}/{id}/comments |
| R214: Delete Comment   | DELETE /api/events/{id}/comments/{comment} |
| R215: View a Polls Detail | GET /api/events/id/polls/{poll_id} |
| R216: Vote on an Choice | POST /api/events/id/polls/{poll_id}/choices/{choice_id} |
| R217: List All Polls   | GET /api/events/id/polls |
| R218: Create a New Poll | POST /api/events/id/polls |


**M03 - Notifications**

| Web Resource Reference | URL |
| ---------------------- | --- |
| R301: list of all notifications by user | GET /notifications |
| R302: Create a notification | POST /notifications |
| R303: get a notification | GET /notifications/id |
| R304: delete a notification | DELETE /notifications/id |

**M04 - User Administration and Static pages**

| Web Resource Reference | URL |
| ---------------------- | --- |
| R401: View Homepage (Landing Page) | GET / |  
| R402: View Contacts Page | GET /contacts |
| R403: View User Support Page | GET /support |
| R404: Send Support Ticket Action | POST /support |
| R405: View About page | GET /about |
| R406: View dashboard | GET /dashboard |
| R407: View search page | GER /search |
| R408: View User Management Page | GET /admin/users |
| R409: View Event Management Page | GET admin/events |
| R410: Deletes a user   | DELETE /admin/users/{user_id} |

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
