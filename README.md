# Expenses calculator
A simple web app for keeping track of expenses, running on docker containers.

# Prerequisites
You should install [Docker](https://www.docker.com/) in order to successfully launch the application. Depending on the OS you intend to run the project on, this may include a bit of work. Please refer to the [Docker installation guide](https://docs.docker.com/get-docker/) for more details.  

Installing Docker via Docker Desktop should also provide you with docker-compose, which is the other required dependency. If something unexpected happens (or if you are using Linux), you can manually install it by following [this guide](https://docs.docker.com/compose/install/).

# How to launch
After installing the mentioned packages, running `docker-compose up` in a terminal (bash, cmd, powershell, etc.) opened in the main project directory (the one with [docker-compose.yaml](docker-compose.yaml)) should start the app. When it starts up, visiting http://localhost:8888 [^1] in a web browser of your choice should display the calculator.

[PHPMyAdmin](https://www.phpmyadmin.net/) is also provided should you want to view/change the data, stored by the app, manually.  
Its web interface is accessible on http://localhost:8889 [^1] while the app is running. To login, use `root` as the username. You can find (and change) the default password (`Privz3toGesl0`) in the [.env](.env) file.

[^1]: If docker-compose displays an error such as `Bind for 0.0.0.0:8888 failed: port is already allocated`, another application may be occupying one or more ports the calculator is configured to use. To remedy such a situation, alter line 43 or 44 of [docker-compose.yaml](docker-compose.yaml), depending on the problematic port, by changing the number **on the left-hand side of the colon** to a port number not already being used on your system. For example, setting line 43 to `- "1234:8888"` should instruct docker-compose to use port `1234` instead, in which case the app will then be available on http://localhost:1234.