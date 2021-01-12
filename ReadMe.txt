1. Create the folder
	- app/code/VendorName/ModuleName
	- etc/module.xml
	- etc/registration.php

2. Create data
	- etc/db_schema.xml
	- bin/magento setup:db-declaration:generate-whitelist --module-name=VendorName_ModuleName

3. Model, ResourceModel, Collection
	- Model/model_name.php
	- Model/ResourceModel/model_name.php
	- Model/ResourceModel/Model_name/Collection.php

4. Controller for layout (define Block and Teamplate), UI Component, Data_provider from di.xml
	- Controller/{controller_name}/{action_name}.php
	- view/{area}/layout/{router_id}_{controller_name}_{action_name}.xml
	- Block/{BlockName}.php
	- view/{area}/templates/{template}.phtml
	- view/{area}/ui_component/{UiComponent_name}.xml
	- etc/di.xml
. 
	
5. Create Admin Configuration
	- etc/adminhtml/system.xml
   Set default value configuration for module
	- etc/config.xml
   Create Admin Menu
	- etc/adminhtml/menu.xml
   Create Admin ACL Access Control Lists
	- etc/acl.xml

6. Create routes admin
	- etc/adminhtml/routes.xml
   Create Controller	
	- Controller/Adminhtml/Post/Index.php
