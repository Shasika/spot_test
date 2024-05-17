# Laravel API for Order Processing

This Laravel project implements a PHP REST API for processing new orders with authentication and integrates with a third-party API endpoint. The project follows the MVC design pattern and utilizes Laravel framework for efficient development.

## Table of Contents

- [Stage 01](#stage-01)
- [Stage 02](#stage-02)
- [Installation](#installation)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [Web Form](#web-form)
- [Queueing API Requests](#queueing-api-requests)
- [License](#license)

## Stage 01

### 1. Create a PHP REST API endpoint for "New Order" processing with authentication

- API endpoint: `/api/new-order`
- HTTP Method: POST
- Request Body Parameters:
  - Customer Name
  - Order Value
- Data stored in MySQL database
- API response includes:
  - Order ID (Ex: ORD-0001)
  - Process ID (randomly picked from ID pool between 1-10)
  - Status

### 2. Submit Order Details to 3rd Party API Endpoint

- API Type: REST
- Method: POST/JSON
- Endpoint URL: https://wibip.free.beeceptor.com/order
- Parameters submitted:


## Stage 02

### 3. Queueing API Requests for High Demand

- Implement a queuing mechanism for API requests to handle high demand.
- Configure the system to queue new orders until the configured number of parallel requests are reached.

### 4. Simple Web Form and Indexed DB

- Create a web form with 3 input parameters: Customer Name, Order Value, Order Date.
- Upon submission, store values in the browser-based Indexed DB.
- Implement a data table to view information from Indexed DB.


## Getting Started

These instructions will help you set up and run the project on your local machine.

### Prerequisites

- [PHP 7.4](https://www.php.net/manual/en/install.php)
- [Composer](https://getcomposer.org/download/)
- [Node.js v14.6](https://nodejs.org/)
- [MySQL 8](https://www.mysql.com/)

### Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/Shasika/spot_test.git
   ```


2. Navigate to the project directory:

   ```sh
   cd your-project
   ```


3. Install composer dependencies:

   ```sh
   composer install
   ```

4. Install npm dependencies:

   ```sh
   npm install
   ```


5. Create a .env file:

   ```sh
   cp .env.example .env
   ```


6. Generate an application key:

   ```sh
   php artisan key:generate
   ```


7. Install JWT:

   ```sh
   php artisan jwt:secret
   ```


8. Configure your database settings in the .env file:

   ```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

9. Artisan commands:

   ```sh
   php artisan config:clear
   php artisan config:cache
   composer dump-autoload
   ````

10. Run migrations and seed the database:

   ```sh
    php artisan migrate:refresh --seed
    ```

11. Start the artisan server:

    ```sh
    php artisan serve
    ```

12. Start the npm:

    ```sh
    npm run watch
    ```
    

13. Start the queue process:

    ```sh
    php artisan queue:work
    ```



## Usage

Follow the API documentation to use the "New Order" endpoint and submit order details to the 3rd party API. Access the web form to store and view data in the Indexed DB.

## Stage 01
In this project directory (postman_collection/spot_test.json) I have attached Postman collection for authenticate and order creation processes. Anyone can import it to Postman.

### 1. Login to the system using the following login details.
I have use JWT Authentication mechanism for authenticate users and I already added the admin user to database using Laravel Seedr
- Login Details:
  - Email: admin@gmail.com
  - Password: 123456


### 2. Order creation

- Subsequently, the order will be saved to the 'orders' table with the order status as ORDERED when hit "Create New Order" API with required details.

![New Order](https://pos.shasikam.com/create_new_order.png)


## Stage 02

### 1. Submit the order details to the 3rd-party API endpoint.

- For handling high demand, API requests are queued. The queuing mechanism ensures that new orders are processed efficiently.
- The application will check all orders with the 'ORDERED' and 'FAILED' status using a scheduled run. The current interval is set to 5 minutes. 

- Retrieve orders and divide them into chunks of 5 units each. Update the status of these orders to 'PROCESSING' and send them to the job queue. (You have the flexibility to adjust the chunk size as needed.). 

- When the job is running, send the details to the 3rd-party API endpoint.

- If the data fails to be sent to the 3rd-party API endpoint within the job, update the order status to 'FAILED'.

- If the data is successfully sent to the 3rd-party API endpoint within the job, update the order status to 'SUBMITTED'.

- This process repeats every 5 minutes, attempting to send orders with 'FAILED' and 'ORDERED' statuses to the 3rd-party API.

- When you need to submit order data to external endpoint, run command "php artisan command:submit_order_data". (we neeed to run this command manaully, because of we haven't configured any server level configuration for run this schedules automatically like "Supervisor")



### Web Form
- Access the Indexed DB data and store new data in the Indexed DB.
- Log in to the application and it automatically navigate to the dashboard page. Here, you can manage the Indexed DB. 

- Login Details:
  - Email: admin@gmail.com
  - Password: 123456

- If anyone needed to login as new user, then they can user register as a new user and login to the system

![Indexed DB](https://pos.shasikam.com/indexed_db_example.png)




