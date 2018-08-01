![REAK-logo](http://reak.in/reak_logo_small.png)

Phalcon Boilerplate Project
===========================

#### What is this about ?

This is a boilerplate project compatible with devtools, utilizing the libraries and experience we have to good use.  
We at REAK [\[http://reak.in\]](https://reak.in) have open sourced are internal boilerplate to provide a jumpstart platform which includes a number of integrations necessary to build a viable long term project.

#### What so special about this ?

The boilerplate provides you an easy platform to build your applications on, The features are listed below

*   **Devtool compatible** \- Our boilerplate is compatible with devtool so you can easily create new controllers, services, models etc
*   **In-built ACL Management** \- Say goodbye to if/else conditions for session. Our ACL function checks user access with the defined list and handles appropriately
*   **In-built error handling** \- Routing code is already implemented for 404 and 403 messages
*   **Testing** \- We have packed PHPUnit for easy testing of application, Best thing it's already integrated
*   **Composer** \- Composer is installed and loaded, Just install any package and use it in the application
*   **Multi-Env Support** \- Multi-environment support right out of the box, say goodbye to changing config on server.

Documentation
=============

*   Devtool Compatibility
    
    This boilerplate is compatible with phalcon devtool, so you can easily create new controllers, models etc  
    `phalcon controller demo`  
      
    \* Make sure you create .phalcon folder first in the project directory
    
*   ### ACL Management
    
    This project has built-in ACL management system, `ControllerBase.php::defineAcl()` has allow definitions for the user types which is driven by session.  
    
        
                        // Allow array
                        return $acl = array(
                            "admin" =>  array(
                                "index/*",
                                "utility/*",
                                "test/*",
                            ),
                            "guest"  =>  array(
                                "index/*",
                                "utility/forbidden",
                                "utility/notfound",
                                "test/*",
                            )
                        );
                
    
      
      
    This is an allow array, which means this would whitelist controllers, functions for the defined user type. Non-registered users of the portal are termed guests.  
      
    You can add multiple user types inside the array, just be sure to use `session["type"]` to identify user.  
    By default guests are defined as users with no `session["type"]` set.  
      
    `ControllerBase::checkAcl()` function has the logic code on how the ACL authorizes user.  
    ACL Denied redirects the user to forbidden (403) page set in `UtilityController::forbiddenAction`
    
*   ### Error Handling
    
    Out of the box support 404 support  
    404 error is defined in `config/services.php`  
      
    404 handler is at UtilityController::notfoundAction, Templates or other logging actions can be performed there.
    
        
                        $di->setShared(
                            "dispatcher",
                            function () {
                                // Create an EventsManager
                                $eventsManager = new EventsManager();
                        
                                // Attach a listener
                                $eventsManager->attach(
                                    "dispatch:beforeException",
                                    function (Event $event, $dispatcher, Exception $exception) {
                                        // Handle 404 exceptions
                                        if ($exception instanceof DispatchException) {
                                            $dispatcher->forward(
                                                [
                                                    "controller" => "utility",
                                                    "action"     => "notfound",
                                                ]
                                            );
                        
                                            return false;
                                        }
                                    }
                                );
                        
                                $dispatcher = new MvcDispatcher();
                        
                                // Bind the EventsManager to the dispatcher
                                $dispatcher->setEventsManager($eventsManager);
                        
                                return $dispatcher;
                            }
                        );
                
    
*   ### Testing Suite
    
    PHPUnit has been included with composer support  
    Tests are located at : `app/tests`  
      
    
    *   **controllers Folder**
        
        The controllers folder inside tests, houses tests for each of them controllers.  
        Tests should be written inside controller folder, in relevant directories.
        
    *   **phpunit.xml**
        
        Contains phpunit configuration, Ideal configuration is already active.
        
    *   **TestHelper.php**
        
        Bootstrap file, contains all relevant includes for unit test to work properly along with Loaders.
        
    *   **UnitTestCase.php**
        
        Master class file which should be called in all unittests file inside controller/ , Includes setUp() instructions and DI loading.
        
    
*   ### Composer Integration
    
    Composer is already loaded and integrated, a test package Hello World, can be found in `composer.json`, called in `TestController::testcomposerAction`  
      
    Composer integration can be found at `app/public/index.php`  
    
        
                        require_once(BASE_PATH . "/../vendor/autoload.php");
                
    
*   ### Multi-Env Support
    
    This project has easy deployment configuration enabled, `app/config/system.ini`  
    Inside that file, you can set environment and appropriate file will be loaded.  
      
    Individual configs are in `app/config` folder  
    
    *   **config.php** \- This is development config file
    *   **config-production.php** \- As the name suggests it will be loaded when environment is set to prodction is ini.
    
      
      
    
    A new section `metadata` has been added in config where `appUrl` and `fileUploadPath` are defined, this can be used inside your application  
    You can call it with `$this->config->metadata->appUrl`  
    Inside view, `{{appUrl}}` can be used to get full application URL.

### Initial Steps:
    * Clone The Repo
    * Install composer & update 
            cmd: `sudo apt-get install composer`
    * Make a folder "cache" inside app root folder and give read-write permission
    * Update phalcon dev-tools by
            cmd: `git clone git://github.com/phalcon/cphalcon.git`
    * Change db configuration in config.php file
    * Set migration 
        Initial steps to migrate
        cmd: `phalcon migration`
        Run migration by 
        cmd: `phalcon migration --action=run`
        Generate migration by
        cmd: `phalcon migration --action=generate`
        
