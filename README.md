# Magento-2-Faq-Extension
Magento 2 FAQ extension is a solution to save time for both store owners and customers. The extensions enhances a page concluding frequently asked questions with the answers so it is easier for customers to search for something they concern about that suppliers are not available to explain to them immediately. 
# Documentation:
* Product page: https://www.mage-world.com/easy-faq-magento-extension.html
* User guide: https://docs.mage-world.com/doku.php?id=magento_2:faq
* Support: https://support.mage-world.com/hc/en-us/requests/new
# How to install: 
* Conditions:
If you have a dev site, please install on it to test first.
If you don't have a dev site, please backup source code and database of live site before installation.
A ftp client software: Filezilla, Winscp.
* Step 1: Download source code from MageWorld.

After you complete your order, please go to My Downloads to download extension.

* Step 2: Unzip extension package and upload them to Magento root folde.

Unzip file that you've just downloaded and use FileZilla (WinSCP) to upload to Magento root folde.

* Step3: Run setting up command line.

Login to ssh, go to Magento root folder and run these command lines:

<code>
php bin/magento setup:upgrade

php bin/magento setup:static-content:deploy

php bin/magento cache:flush
</code>
