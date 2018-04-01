<div class="page-header">
    <center><img src="http://reak.in/reak_logo_small.png" alt="REAK-logo" /></center>
    <h1>Phalcon Boilerplate Project</h1>
</div>

<h4>What is this about ?</h4>
<p>
    This is a boilerplate project compatible with devtools, utilizing the libraries and experience we have to good use.<br />
    We at REAK <a href="https://reak.in">[http://reak.in]</a> have open sourced are internal boilerplate to provide a jumpstart platform which includes a number of integrations necessary to build a viable long term project.
</p>

<h4>What so special about this ?</h4>
<p>
    The boilerplate provides you an easy platform to build your applications on, The features are listed below
    <ul>
        <li><strong>Devtool compatible</strong> - Our boilerplate is compatible with devtool so you can easily create new controllers, services, models etc</li>
        <li><strong>In-built ACL Management</strong> - Say goodbye to if/else conditions for session. Our ACL function checks user access with the defined list and handles appropriately</li>
        <li><strong>In-built error handling</strong> - Routing code is already implemented for 404 and 403 messages</li>
        <li><strong>Testing</strong> - We have packed PHPUnit for easy testing of application, Best thing it's already integrated</li>
        <li><strong>Composer</strong> - Composer is installed and loaded, Just install any package and use it in the application</li>
        <li><strong>Multi-Env Support</strong> - Multi-environment support right out of the box, say goodbye to changing config on server.</li>
    </ul>
</p>

<h1>Documentation</h1>

<ul>
<li><h3>Devtool Compatibility</h3>
    <p>
        This boilerplate is compatible with phalcon devtool, so you can easily create new controllers, models etc<br />
        <code>
            phalcon controller demo
        </code>
        <br /><br />
        * Make sure you create .phalcon folder first in the project directory
    </p>
</li>
<li><h3>ACL Management</h3>
    <p>
        This project has built-in ACL management system, <code>ControllerBase.php::defineAcl()</code> has allow definitions for the user types which is driven by session.<br />
        <pre><code>
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
        </code></pre>
        <br /><br />
        This is an allow array, which means this would whitelist controllers, functions for the defined user type. Non-registered users of the portal are termed guests.
        <br /><br />
        You can add multiple user types inside the array, just be sure to use <code>session["type"]</code> to identify user.
        <br />By default guests are defined as users with no <code>session["type"]</code> set.
        <br /><br />
        <code>ControllerBase::checkAcl()</code> function has the logic code on how the ACL authorizes user.
        <br />ACL Denied redirects the user to forbidden (403) page set in <code>UtilityController::forbiddenAction</code>
    </p>
</li>
<li><h3>Error Handling</h3>
    <p>
        Out of the box support 404 support<br />
        404 error is defined in <code>config/services.php</code>
        <br /><br />
        404 handler is at UtilityController::notfoundAction, Templates or other logging actions can be performed there.
        <pre><code>
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
        </code></pre>
    </p>
</li>
<li><h3>Testing Suite</h3>
    <p>
        PHPUnit has been included with composer support<br />
        Tests are located at : <code>app/tests</code>
        <br /><br />
        <ul>
            <li><strong>controllers Folder</strong>
                <p>
                    The controllers folder inside tests, houses tests for each of them controllers.<br />
                    Tests should be written inside controller folder, in relevant directories.
                </p>
            </li>
            <li><strong>phpunit.xml</strong>
                <p>
                    Contains phpunit configuration, Ideal configuration is already active.
                </p>
            </li>
            <li><strong>TestHelper.php</strong>
                <p>
                    Bootstrap file, contains all relevant includes for unit test to work properly along with Loaders.
                </p>
            </li>
            <li><strong>UnitTestCase.php</strong>
                <p>
                    Master class file which should be called in all unittests file inside controller/ , Includes setUp() instructions and DI loading.
                </p>
            </li>
        </ul>
        
    </p>
</li>
<li><h3>Composer Integration</h3>
    <p>
        Composer is already loaded and integrated, a test package Hello World, can be found in <code>composer.json</code>, called in <code>TestController::testcomposerAction</code>
        <br /><br />
        Composer integration can be found at <code>app/public/index.php</code><br />
        <pre><code>
                require_once(BASE_PATH . "/../vendor/autoload.php");
        </code></pre>
    </p>
</li>
<li><h3>Multi-Env Support</h3>
    <p>
        This project has easy deployment configuration enabled, <code>app/config/system.ini</code>
        <br />Inside that file, you can set environment and appropriate file will be loaded.
        <br /><br />
        Individual configs are in <code>app/config</code> folder<br />
        <ul>
            <li><strong>config.php</strong> - This is development config file</li>
            <li><strong>config-production.php</strong> - As the name suggests it will be loaded when environment is set to prodction is ini.</li>
        </ul>
        <br /><br />
        <p>A new section <code>metadata</code> has been added in config where <code>appUrl</code> and <code>fileUploadPath</code> are defined, this can be used inside your application<br />
        You can call it with <code>$this->config->metadata->appUrl</code>
        <br />
        Inside view, <code>&lbrace;&lbrace;appUrl&rbrace;&rbrace;</code> can be used to get full application URL.
        </p>
    </p>
</li>
</ul>

</p>