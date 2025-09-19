Description: A social workout tracker web application completed in a group for CS 4750 (Database Systems) at the University of Virginia, extended beyond education for personal practice and usage. Document your workouts, add friends, and get inspired for your next workout with public, personal, and friend feeds!

Interactive Website: https://struva-workout-tracker-309878984293.us-east4.run.app/

1. To run the project locally using Docker: 
```bash
docker compose up --build
```

2. To examine the database, set environment variables and then run: 
```bash
mysql --host=$DB_HOST --port=$DB_PORT --user=$DB_USER --password=$DB_PASS --ssl-ca=$DB_CA $DB_NAME
```
