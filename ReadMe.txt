1. Create the folder
	- app/code/VendorName/ModuleName
	- etc/module.xml
	- etc/registration.php

2. Create data
	- etc/db_schema.xml
	- bin/magento setup:db-declaration:generate-whitelist --module-name=VendorName_ModuleName
	
	

Create Admin Configuration
	- etc/adminhtml/system.xml

Set default value configuration for module
	- etc/config.xml

Create Admin Menu
	- etc/adminhtml/menu.xml

Create Admin ACL Access Control Lists
	- etc/acl.xml

