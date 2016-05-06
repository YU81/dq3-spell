# DQ3 spell
- [![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

## what is it?
- This API for the complete list of spell or one of the spell only return one randomly used in Dragon Quest 3.
- Data are quoted from https://www.d-navi.info/dq3/jumon .

## deploy
### Heroku
- php artisan key:generate
- heroku create some-app-name
- configure git remote heroku as official instruction https://devcenter.heroku.com/articles/git
- git push heroku master
- heroku config:set $(cat .env | egrep "^APP_KEY")
- access http://YOUR_APP_NAME/spell http://YOUR_APP_NAME/spell/random
