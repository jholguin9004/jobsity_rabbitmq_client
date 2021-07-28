This project connects to the RabbitMQ server, get messages and send them.

## Project instalation
First you need to clone the repository in your local enviroment.  
When you have the project in your enviromen then:

**1. Go to the project's path**:  
`cd /rebbitClientProject/root/path`  

**2. Install all dependencies**  
`composer install`  

**3. Copy .env file**  
`cp .env.sample .env`  

**4. Configure enviroment variables.**  
**4.1 RabbitMQ**  
If you are going to use the RabbitMQ container provided, you have only to change the RMQ_HOST param.  
To get the container IP enter this in your console:  
`docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' rabbitmq`  
> If you have your own RabbitMQ installation, modify all RMQ_* variables as you need.
> Must be the same configuration than Jobsity Enviroment.

**4.2. SMTP**  
Modify all SMTP varabiles according to your SMTP account.  

**5. Generate containers**  
`docker-compose up -d`  

## Start sending emails
This command line will send any pending messages that exists in RabbitMQ server.  

`docker exec -it rabbitmq_client php index.php`  
