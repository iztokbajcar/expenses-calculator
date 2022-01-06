# Expenses calculator
A simple web app for keeping track of expenses, running on docker containers.

# Prerequisites
You should install [Docker](https://www.docker.com/) in order to successfully launch the application. Depending on the OS you intend to run the project on, this may include a bit of work. Please refer to the [Docker installation guide](https://docs.docker.com/get-docker/) for more details.  

Installing Docker via Docker Desktop should also provide you with docker-compose, which is the other required dependency. If something unexpected happens (or if you are using Linux), you can manually install it by following [this guide](https://docs.docker.com/compose/install/).

# How to launch
After installing the mentioned packages, running `docker-compose up` in a terminal (bash, cmd, powershell, etc.) opened in the main project directory (the one with [docker-compose.yaml](docker-compose.yaml)) should start the app. When it starts up, visiting http://localhost:8888[^1] in a web browser of your choice should display the calculator in all its glory.

[^1]: Test?