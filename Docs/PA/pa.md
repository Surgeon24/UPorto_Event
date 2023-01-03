# PA: Product and Presentation

UPorto Event is the new essential web platform for event management, allowing users to better plan and promote events mainly connected with academic life of Universidade do Porto.


## A9: Product

UPorto Event is a Portugal-based international web service that focuses on creation and development of small and/or large-scale events mostly connected with U.Porto academic life.

The main goal of the project is to provide assistance in event creation and management to University of Porto's community. UPorto Event is a centralized service approved by the university officials. 

Events creation, management and promotion is assisted bt UPorto event service, offering easy to grasp system, user-friendly interface, unique features and attractive design.

### 1. Installation

> Link to the release with the final version of the source code in the group's Git repository.  
> Include the full Docker command to start the image available at the group's GitLab Container Registry using the production database.  

The source code can be found [here](https://git.fe.up.pt/lbaw/lbaw2223/lbaw22122).

The final release can be found at: https://lbaw22122.lbaw.fe.up.pt.

Commands to run the project on localhost(linux):

~~~~
#run the composer
docker-compose up

# update database
php artisan db:seed

# in another terminal
php artisan serve

# common error fix: kill the docker image if it is already running
docker ps
docker kill id

# download composer if not installed 
composer install
# or
composer update


# web app https://localhost:8000 
# pgadmin database http://localhost:4321/

~~~~



### 2. Usage

> URL to the product: http://lbaw22122.lbaw.fe.up.pt  

#### 2.1. Administration Credentials


| Username | Password |
| -------- | -------- |
| admin@example.com    |  1234 |

#### 2.2. User Credentials

| Type          | Email  | Password |
| ------------- | --------- | -------- |
| Authenticated User | user@example.com    |   1234 |
| Event Moderator   | moderator@example.com    | 1234 |

### 3. Application Help

Help has been implemented in forms, giving the user a real time feedback about the inputs he typed, if they were wrong, and displaying a message on what was supposed to be submitted.

There is also a FAQ (Frequently Asked Questions) page where the user can find answers that could help him use the app.

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


Some Priorities were changed when we learned about product requirements(features in A9 checklist). User Stories were implemented by order of importance. During production we have had realised that some of the User Stories are unnecessary or of less importance. Giving up some of the User Stories allowed us to focus on more important ones, resulting in having more User Stories (_35_) than initially planned (_29_ see ER component)

_**Rejected User Stories:**_

| Rejected |               |
| --------- | ------------- |
| au13      | Invite        |
| au10      | Preferences   |
| em01      | Announcement  |
| em05      | Block Content |
| ad03      | Message       |

_**New User Stories:**_

| Additional User Stories: |                                                                   |
| ------------------------ | ----------------------------------------------------------------- |
| high au13                | Full-text search with multiple weighted fields                    |
| high au12                | Advanced search using filters                                     |
| high ep2                 | Like button with AJAX                                             |
| high au10                | Change password                                                   |
| high au14                | Private events                                                    |
| medium au15              | search by tags                                                    |
| medium ee03              | interactive notification for owner of public event (Join Request) |
| medium au16              | images for users and events                                       |
| high ad03                | search by users                                                   |


### 8. Implementation Details

#### 8.1. Libraries Used

_Libraries used:_
* Laravel's notification library (https://laravel.com/docs/master/notifications#database-notifications) is used to manage notifications. This is a standard Laravel's library that does not require additional installation.

* alpine.js (https://alpinejs.dev/) is a lightweight, JavaScript framework. It is used to make a successful return messages (e.g. after an event is created successfuly). Installation require adding one line of code.

#### 8.2 User Stories

> This subsection should include all high and medium priority user stories, sorted by order of implementation. Implementation should be sequential according to the order identified below. 
>
> If there are new user stories, also include them in this table. 
> The owner of the user story should have the name in **bold**.
> This table should be updated when a user story is completed and another one started. 


| US Identifier | Name                                           | Module                  | Priority | Team Members           | State |
| ------------- | ---------------------------------------------- | ----------------------- | -------- | ---------------------- | ----- |
| us01          | Search                                         | User                    | High     | **Mikhail**                | 100%  |
| us02          | View event                                     | User                    | High     | **Valter, David, Mikhail** | 100%  |
| vi01          | Log In                                         | Visitor                 | High     | **Valter, David**          | 100%  |
| vi02          | Sign Up                                        | Visitor                 | High     | **Valter, David**          | 100%  |
| au01          | Home                                           | Authenticated User      | High     | **Michael**                | 100%  |
| au02          | Events                                         | Authenticated User      | High     | **Michael**                | 100%  |
| au03          | Create Event                                   | Authenticated User      | High     | **Valter, Joao**          | 100%  |
| au04          | Log Out                                        | Authenticated User      | High     | **Valter**                 | 100%  |
| au05          | Participate                                    | Authenticated User      | High     | **Michael**                | 100%  |
| au06          | Edit Profile                                   | Authenticated User      | High     | **Valter**                 | 100%  |
| au07          | Delete Profile                                 | Authenticated User      | High     | **Valter**                 | 100%  |
| au08          | View Profile                                   | Authenticated User      | High     | **Valter, David, Mikhail** | 100%  |
| au09          | Recover Password                               | Authenticated User      | High     | **Valter**                 | 50%  |
| au10          | Change Password                                | Authenticated User      | High     | **David**                  | 100%  |
| au11          | Notifications                                  | Authenticated User      | High     | **David**                  | 100%  |
| au12          | Advanced search using filters                  | Authenticated User      | High     | **David**                  | 100%  |
| au13          | Full-text search with multiple weighted fields | Authenticated User      | High     | **Mikhail, David**         | 100%  |
| au14          | Create Private Events                          | Authenticated User      | High     | **Mikhail**                | 100%  |
| ep01          | Comment Events                                 | Event Participant       | High     | **Valter, Mikhail**        | 100%  |
| ep02          | Like comments (AJAX)                           | Event Participant       | High     | **Valter**                 | 100%  |
| ad01          | Block,Unblock, Delete                          | Administrator           | High     | **Mikhail**                | 100%  |
| ad02          | Delete Event                                   | Administrator           | High     | **Mikhail, Valter**        | 100%  |
| ad03          | Search by Users                                | Administrator           | High     | **Mikhail**                | 100%  |
| us03          | About Us                                       | User                    | Medium   | **David**                  | 100%  |
| us04          | FAQ                                            | User                    | Medium   | **David**                  | 100%  |
| us05          | Send a request to Join a Private event         | User                    | Medium   | **Mikhail, David**         | 100%  |
| au15          | Search by Tags                                 | Authenticated User      | Medium   | **David**                  | 100%  |
| au16          | Add Images on Profile and Event                | Authenticated User      | Medium   | **Mikhail, Joao**          | 100%  |
| em01          | Add/Accept User                                | Event Moderator         | Medium   | **Mikhail**                | 100%  |
| em02          | Create Polls                                   | Event Moderator         | Medium   | **Mikhail**                | 100%  |
| em03          | Block User                                     | Event Moderator         | Medium   | **Mikhail**                | 100%  |
| ee01          | Event Changes                                  | Event Organiser (Owner) | Medium   | **Mikhail**                | 100%  |
| ee02          | Assign Moderator role                          | Event Organiser (Owner) | Medium   | **Mikhail**                | 100%  |
| ee03          | Managing Join Requests                         | Event Organiser (Owner) | Medium   | **Mikhail, David**         | 100%  |
| ep03          | Vote in Polls                                  | Event Participant       | Medium   | **Mikhail, Joao**          | 100%  |


---


## A10: Presentation

The purpose of this project was to develop a web application for an event management platform.

The goal of this artefact is to promote, present and demonstrate the product developed.

### 1. Product presentation


After registering to the platform, the user can create public and private events, comment on events, participate on events and polls. There's also administrator functionality, administrator can block, unblock and delete undesirable users. Event Owners can assign Event Moderators that can help the Owner with organising the event.

The link to the final product is the following: http://lbaw22122.lbaw.fe.up.pt


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
GROUP22122, 03/01/2023

* João Sousa, up201904739@up.pt    
* Mikhail Ermolaev, up202203498@up.pt
* David Burchakov, up202203777@up.pt (editor)
* Válter Castro, up201706546@up.pt
