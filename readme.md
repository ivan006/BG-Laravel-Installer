Web Skills - Laravel App Installer (example is for subdomain) 

https://www.youtube.com/watch?v=DP8FuPcGix8&feature=youtu.be


# For use with Symphony apps

Just do step 1 and 2 and fix kernal locations

## To fix kernal locations
- Orient to "public/index.php"
- Replace 
  - `require dirname(__DIR__).'/vendor/autoload.php';` with
  - with `require '/usr/home/bluegpyuty/red.bluegemify.co.za_app'.'/vendor/autoload.php';`
- Also replace
  - `(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');`
  - with `(new Dotenv())->bootEnv('/usr/home/bluegpyuty/red.bluegemify.co.za_app'.'/.env');`
- Upload this to the root of your webroot not to your home dir


