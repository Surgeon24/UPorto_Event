# PA: Product and Presentation

> Project vision.

## A9: Product

> Brief presentation of the product developed.  

### 1. Installation

> Link to the release with the final version of the source code in the group's Git repository.  
> Include the full Docker command to start the image available at the group's GitLab Container Registry using the production database.  

### 2. Usage

> URL to the product: http://lbaw22122.lbaw.fe.up.pt  

#### 2.1. Administration Credentials

> Administration URL: URL  

| Username | Password |
| -------- | -------- |
| admin@example.com    |   1234 |

#### 2.2. User Credentials

| Type          | Username  | Password |
| ------------- | --------- | -------- |
| authenticated user | user@example.com    |   123456 |
| news editor   | user 1    | password |

### 3. Application Help

Help has been implemented in forms, giving the user a real time feedback about the inputs he typed, if they were wrong, and displaying a message on what was supposed to be submitted.

There is also a FAQ (Frequently Asked Questions) page where the user can see a couple of questions that would help him use the app.

### 4. Input Validation


Input data validation was used in the forms, adding the pattern attribute which displays an error message in case the input was not according to what was expected (Validation Rule). 


For example: when a user is creating an account he has to create a password that contain special characters, numbers, lower and upper case letters. In the server side, there is a verification if the input received is correct by using validators or checking if it is null.


### 5. Check Accessibility and Usability

> Provide the results of accessibility and usability tests using the following checklists. Include the results as PDF files in the group's repository. Add individual links to those files here.
>
> Accessibility: https://ux.sapo.pt/checklists/acessibilidade/  
> Usability: https://ux.sapo.pt/checklists/usabilidade/  

### 6. HTML & CSS Validation

> Provide the results of the validation of the HTML and CSS code using the following tools. Include the results as PDF files in the group's repository. Add individual links to those files here.
>   
> HTML: https://validator.w3.org/nu/  
> CSS: https://jigsaw.w3.org/css-validator/  

### 7. Revisions to the Project

> Describe the revisions made to the project since the requirements specification stage.  

### 8. Implementation Details

#### 8.1. Libraries Used

> Include reference to all the libraries and frameworks used in the product.  
> Include library name and reference, description of the use, and link to the example where it's used in the product.  

Libraries used:
* Laravel's notification library (https://laravel.com/docs/master/notifications#database-notifications)

* alpine.js

#### 8.2 User Stories

> This subsection should include all high and medium priority user stories, sorted by order of implementation. Implementation should be sequential according to the order identified below. 
>
> If there are new user stories, also include them in this table. 
> The owner of the user story should have the name in **bold**.
> This table should be updated when a user story is completed and another one started. 

| US Identifier | Name    | Module | Priority                       | Team Members               | State  |
| ------------- | ------- | ------ | ------------------------------ | -------------------------- | ------ |
|  US01          | US Name 1 | Module A | High/Mandatory | **John Silva**, Ana Alice   |  100%  |
|  US02          | US Name 2 | Module A | Medium/Important | **Ana Alice**, John Silva                 |   75%  | 
|  US03          | US Name 3 | Module B | Low/Optional | **Francisco Alves**                 |   5%  | 
|  US04          | US Name 4 | Module A | Low/Optional | -                 |   0%  | 
| us01 | User | Search | High |As a user, I want to search for public events by name, organizer or tags to join them. | v0.1 |
| us02 | User | View Event | High | As a User, I want to navigate through a specific public event so I can see more detailed information | v0.1 |
| us03 | User | About us | Medium|As a user, I want to access the about page, where I can find a description of the site and its creators. |v0.4|
| us04 | User | FAQ | Medium|As a user, I want to access the FAQ page, where I can get answers to common questions about the site.|v0.4|
|vi01| Visitor | Log In | High | As a visitor, I want to be able to log-in, to get a status of authenticated user. | v0.1|
|vi02| Visitor | Sign Up | High  |As a visitor, I want to be able to create my profile on the site to become an authenticated user. |v0.1|
| au01 | Auth. user | Home | High | As an authenticated user, I want to access my home page, where I can see all information about the website. | v0.1 |
| au02 | Auth. user | Events | High | As an authenticated user, I want to see all the events that I participate in, so I can manage them. | v0.1 |
| au03 | Auth. user | Create Event | High | As an authenticated user, I want to create new events by myself to become an event organizer. | v0.1 |
| au04 | Auth. user | Log Out | High | As an authenticated user, I want to be able to log out from service for privacy purposes. | v0.1 |
| au05 | Auth. user | Participate | High | As an authenticated user, I want to show my interest in an event and be able to send a request for participating. | v1.0 |
| au06 | Auth. user | Edit Profile | High | As an authenticated user, I want to edit my profile whenever I please, to keep it up to date.| v0.1 |
| au07 | Auth. user | Delete Profile | High | As an authenticated user, I want to delete my profile if I feel like it. | v0.1 |
| au08 | Auth. user | View Profile | High | As an authenticated user, I want to see my profile and others to check information I want. | v0.1 | 
| au09 | Auth. user | Recover Password | High | As an authenticated user, I want to recover my password in case I can´t remember it. | v0.1 |
| au10 | Auth. user | Preferences | High| As an authenticated user, I want to be able to change my password or customize my notifications, to maintain a comfortable environment on the service for myself.|v0.2|
| au11 | Auth. user | Notifications | Medium | As an autenticated user, I want to recieve notifications about an event that I joined, from an answer to my comment or about my status, so I can stay tuned and connected with the website. | v0.2 |
| au12 | Auth. user | Comment | Medium | As an authenticated user, I want to ask any questions I’d like about an event, even if I'm not a member of this event yet. | v0.2 |
| au13 | Auth. user | Invite | Medium | As an authenticated user, I want to Invite a user to an event, so we can participate together. | v0.2 |
| em01 | Moderator | Announcement | Medium | As a moderator of an event, I want to create new announcements on the events page, to inform members about changes in the event. | v0.2 |
| em02 | Moderator | Add/Accept User | Medium | As a moderator, If the event is private, I should be able to add new users and accept them, so more people can join. | v0.3 |
| em03 | Moderator | Create Polls | Medium | As a moderator, I want to create polls about diffrent subjects related to the event, so that out attendes and interact an communicate with the organization in an interactive way | v0.3 |
| em04 | Moderator | Block User | Low |As a moderator, I want to be able to ban users in the particular event, if they improperly behave|v1.0|
| em05 | Moderator | Block Content | Low |As a moderator, I want to remove a comment, so that I can remove inappropriate content in comments. |v1.0|
| ee01 | Organizer (Owner) | Event Changes| Medium | As an organizer of an event, I want to be able to edit the details of the event and delete it, to keep all information up to date. | v1.0 |
| ep01 | event participant | vote in polls | Medium | As a participant of an event, I want to be able to participate in decisions about event and vote in polls, that were created for the members of the event. | v1.0 |
| ad01 | Admin | Delete Event | High | As an administrator, I want to be able to delete events on the site, if they violate the rules of the service. | v1.0 |
| ad02 | Admin | Block, Unblock, Delete | High | As an administrator, I have to be able to block, unblock or delete users accounts so I can manage the site properly and resist potential user violations. | v1.0 |
| ad03 | Admin | Message | Low | As an administrator, I want to be able to write to users via their home pages, to warn them about violation of the rules or answer their questions regarding the use of the service. | v1.1 |


---


## A10: Presentation
 
> This artefact corresponds to the presentation of the product.

### 1. Product presentation

> Brief presentation of the product and its main features (2 paragraphs max).  
>
> URL to the product: http://lbaw22122.lbaw.fe.up.pt  
>
> Slides used during the presentation should be added, as a PDF file, to the group's repository and linked to here.


### 2. Video presentation

> Screenshot of the video plus the link to the lbaw21gg.mp4 file  

> - Upload the lbaw21gg.mp4 file to the video uploads' [Google folder](https://drive.google.com/drive/folders/1-fPoSR3lXyPI38UgpWf6iQBe2Lk_ckoT?usp=sharing "Videos folder"). You need to use a Google U.Porto account to upload the video.   
> - The video must not exceed 2 minutes.
> - Include a link to the video on the Google Drive folder.


---


## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUP21gg, DD/MM/2021

* João Sousa, up201904739@up.pt    
* Mikhail Ermolaev, up202203498@up.pt
* David Burchakov, up202203777@up.pt (editor)
* Válter Castro, up201706546@up.pt
