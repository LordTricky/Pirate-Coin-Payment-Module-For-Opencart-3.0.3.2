# Pirate-Coin-Payment-Module-For-Opencart-3.0.3.2
PHP Payment Module For Pirate Coin in Opencart 3.0.3.2

Dependancies = PHP-JSON, PHP-CURL, PHP-ZIP
<pre>apt-get install php-json, php-curl, php-zip</pre>

<strong>Install Guide.</strong>

Assuming you already have a Domain Name and webhosting in place.

<strong>Step 1.</strong>

Install the latest version of Opencart from the opencart website which comes with its own installation guide https://www.opencart.com/
You will need a mysql user and database for this.

<strong>Step 2.</strong>

Install your pirate coin wallet, i used Verus Agama with komodo cli, this can be installed on your server (insecure) or on your home PC (secure) If using a home PC you will need either a static IP address or if no static IP you will need to use some kind of dynamic DNS updater. More info on dynamic DNS can be found here https://freedns.afraid.org

<strong>Step 3.</strong>

ONLY APPLIES IF YOUR WALLET IS NOT RUNNING FROM THE SAME SERVER AS YOUR WEBSITE.
Find the pirate.conf file (C:\Users\{username}\AppData\Roaming\Komodo\PIRATE in windows) and add "rpcallowip={your servers ip address} and restart your wallet.

<strong>Step 4.</strong>

Upload this payment module via FTP, you should not be prompted to overwrite any files.

<strong>Step 5.</strong>

Login to your new opencart admin panel https://{your domain name}/admin and goto system - localisation - currencies and add a new currency, name it "Pirate" with the code "ARR", then in symbol right you want to add " Arrr" Do not miss the space, Decimal places "8", Value "1" (we will revist this later) and Status "enabled".

<strong>Step 6.</strong>

Still in opencart admin, goto extensions - extensions and the select payments from the drop down menu where it says "choose the extension type", Scroll down the page and you will find the newly added Pirate module, click the green box with a plus symbol to install the Pirate module, the green box will then turn red once installation is complete. 

<strong>Step 7.</strong>

Click the blue box (next to the now red 1) to edit the module, here you will need to add your wallet credentials found in pirate.conf as reffered to in step 3. RPC User, RPC Password RPC Port all need to match those from pirate.conf, RPC Host is either "localhost" if the wallet is running on the same machine as your website, your static IP if the wallet is running on your home PC, or the dynamic address setup with a service like https://freedns.afraid.org/ under "pirate currency" you simply select the new pirate currency you created in step 5 form the drop down menu, QR code you will want to select "google API", Order total can be ignored this is used to set a minimum order value before anybody can pay with this module, order status set to "pending" GEO Zone leave as "all zones", set status to "enabled", sort order set to "0" if you want this payment module to be the first selectable for customers placing an order.

<strong>Step 8.</strong>

Click the Blue box at the top right of the page to save your settings. If you are pricing your stock in fixxed Pirate Coin prices you are now finished, the module is fully installed, ready to go and can now be tested with test orders.

<strong>Step 9.</strong>

If you are pricing your items in fiat currency and accepting payment in Pirate coin you will need to edit the matching cronjob file (add your database credentials) and add that file to your crontab to run as often as you would like the prices updated.



I will be adding more currencies, and alternate sources for the cronjob price valuations.

I also have this module available and compatible with Opencart version 2.2.

Arrr Donations Welcome<br>
zs1uly9cl890gxry2uwuye4cvaavvys3fh847n73ts47xlq76f45yqlpacxhv8ypde0r49j25xquvg
