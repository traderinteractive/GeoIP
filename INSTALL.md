# Installing the Service

## Downloading the code

Installation and setup is painless.

```
composer create-project dominionenterprises/geoip
```

## Configuring Apache
You can use the [example.conf](example.conf) file to configure an Apache server.

## Updating The Database
### Manual Updates
MaxMind releases a new database on the first Tuesday or every month. To update your copy, run:
```
make update-database
```

#### Scheduled Updates
If you would like to automatically update the database, the easiest way to do so, would be to add a crontab entry for `make update-database`

Add the following line to your crontab.

```
0 0  * * 3 [`date +\%d` -le 7] && make -C /path/to/GeoIP/ update-database > /dev/null 2>&1
```

This line will run the script on the first Wednesday of every month.

Why Wednesday, when MaxMind release it's databases on Tuesdays?

Well, because I don't know what time they release them and there is no way to guarantee that the one we are downloading is the new one. So lets give them the benefit of the doubt and wait until Wednesday to grab the new one.
