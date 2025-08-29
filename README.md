Group Members / Contributors: Justin Brady (https://github.com/jbrady1203), Glenn Hogan (https://github.com/glennhogan), and Matthew Nicoud (https://github.com/mnicoud55).

Description: A social workout tracker web application completed for CS 4750 (Database Systems) at the University of Virginia, extended beyond education for personal practice and usage.

Interactive Website: https://www.cs.virginia.edu/~jmb4zz/CS4750_final_deliverable/login.php

1. To run the project locally using docker: 
```bash
docker compose up --build
```

2. To examine the database, set environment variables and then run: 
```bash
mysql --host=$DB_HOST --port=$DB_PORT --user=$DB_USER --password=$DB_PASS --ssl-ca=$DB_CA $DB_NAME
```
