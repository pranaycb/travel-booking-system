## How to run this application?
#### Step:1
Clone this repo
```
git clone https://github.com/pranaycb/travel-booking-system.git
```

#### Step:2
Login to your phpmyadmin and create a database and import the sql file (located inside the `database-file` directory). 
After then, open database.php file (located inside the `configs` directory) and change the following credentials according to your database configuration.
```
define('BASE_URL', 'http://localhost/tms/'); //site base url
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tms');
```

#### Step:3
If you wanted to send sms when new booking is created you have to register an account in smsq https://smsq.com.bd/ and recharge your account to send sms.
After registering an account you will get your api credentials. Add those credentials in the smsq.php file (located inside `configs` directory).
```
define("SMSQ_API_KEY", "YOUR API KEY");
define("SMSQ_CLIENT_ID", "YOUR CLIENT ID");
define("SMSQ_SENDER_ID", "YOUR SENDER ID");
```

#### Step:4
Now you are good to go. Browse the project url and you will find your application up and running.


### Need Help?
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

If you have any problem regarding the file please feel free to contact me via email pranaycb.ctg@gmail.com

Happy Coding 🤗🤗
