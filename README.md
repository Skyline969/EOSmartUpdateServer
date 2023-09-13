# EOSmartUpdateServer
The server component for EOSmartUpdate. It will watch for updates to EndlessOnline Recharged and download them automatically, then make them available for distribution via the EOSmartUpdateClient.

The server downloads the latest version of the client, extracts it into the updates folder, and then calculates MD5 hashes of the files contained within the update. It saves these hashes in a .md5list file that the EOSmartUpdateClient uses to cross-reference with its local files. Finally, the server then updates the file updates/latest.txt to point to the newest version.

The client then downloads only the files it needs from the server, saving time and bandwidth.

## Usage
Place the contents of the release into a directory on your webserver. Set up a cron job to run maintenance/download_latest_client.php on a regular basis - every 15 minutes should be enough. The server will then monitor for new updates and download them as they are released. The web server takes care of the rest.

**NOTE:** Make sure your permissions are correct, or files may fail to download.

Once you have the server setup, clone the EOSmartUpdateClient repo and adjust the baseURL variable to point to your EOSmartUpdateServer URL.

## Requirements
* Web Server of your choice
* PHP
* php-zip

## Donations
If you like my work, feel free to buy me a beer. Donations are never mandatory or even expected but are always appreciated.

<a href="https://www.paypal.me/skyline969"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="Donate"/></a>