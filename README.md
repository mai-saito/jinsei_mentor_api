# Jinsei Mentor API
Jinsei Mentor API is a Japanese RESTful API which shows/stores/updates/deletes data of users' life events to create their chronological timelines.

This need to be integrated with a front-end interface which will show users' timelines as a format of line chart.
*Front-end interface is still under development.

## API
### Timelines
* index: get all the list of timelines
* show: get the specific timeline data
* store: create a new record of timeline and related life events data
* update: update the record of timeline and related life events data
* delete: delete the record of timeline and related life events data

## API for future development
### Timelines
* search: filter and search timelines with conditions
* addComment: add a comment to the timeline
* deleteComment: delete a comment to the timeline
### Login/Logout
*considering to add a user login function using third party authorization API so that only logged in users can create timelines.
