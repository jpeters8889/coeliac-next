<?php
// @formatter:off
// phpcs:ignoreFile

/**
 * A helper file for Laravel, to provide autocomplete information to your IDE
 * Generated for Laravel 10.35.0.
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 * @see https://github.com/barryvdh/laravel-ide-helper
 */

    namespace Barryvdh\Debugbar\Facades { 
            /**
     * 
     *
     * @method static void alert(mixed $message)
     * @method static void critical(mixed $message)
     * @method static void debug(mixed $message)
     * @method static void emergency(mixed $message)
     * @method static void error(mixed $message)
     * @method static void info(mixed $message)
     * @method static void log(mixed $message)
     * @method static void notice(mixed $message)
     * @method static void warning(mixed $message)
     * @see \Barryvdh\Debugbar\LaravelDebugbar
     */ 
        class Debugbar {
                    /**
         * Enable the Debugbar and boot, if not already booted.
         *
         * @static 
         */ 
        public static function enable()
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->enable();
        }
                    /**
         * Boot the debugbar (add collectors, renderer and listener)
         *
         * @static 
         */ 
        public static function boot()
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->boot();
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function shouldCollect($name, $default = false)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->shouldCollect($name, $default);
        }
                    /**
         * Adds a data collector
         *
         * @param \DebugBar\DataCollector\DataCollectorInterface $collector
         * @throws DebugBarException
         * @return \Barryvdh\Debugbar\LaravelDebugbar 
         * @static 
         */ 
        public static function addCollector($collector)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->addCollector($collector);
        }
                    /**
         * Handle silenced errors
         *
         * @param $level
         * @param $message
         * @param string $file
         * @param int $line
         * @param array $context
         * @throws \ErrorException
         * @static 
         */ 
        public static function handleError($level, $message, $file = '', $line = 0, $context = [])
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->handleError($level, $message, $file, $line, $context);
        }
                    /**
         * Starts a measure
         *
         * @param string $name Internal name, used to stop the measure
         * @param string $label Public name
         * @static 
         */ 
        public static function startMeasure($name, $label = null)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->startMeasure($name, $label);
        }
                    /**
         * Stops a measure
         *
         * @param string $name
         * @static 
         */ 
        public static function stopMeasure($name)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->stopMeasure($name);
        }
                    /**
         * Adds an exception to be profiled in the debug bar
         *
         * @param \Exception $e
         * @deprecated in favor of addThrowable
         * @static 
         */ 
        public static function addException($e)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->addException($e);
        }
                    /**
         * Adds an exception to be profiled in the debug bar
         *
         * @param \Throwable $e
         * @static 
         */ 
        public static function addThrowable($e)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->addThrowable($e);
        }
                    /**
         * Returns a JavascriptRenderer for this instance
         *
         * @param string $baseUrl
         * @param string $basePathng
         * @return \Barryvdh\Debugbar\JavascriptRenderer 
         * @static 
         */ 
        public static function getJavascriptRenderer($baseUrl = null, $basePath = null)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getJavascriptRenderer($baseUrl, $basePath);
        }
                    /**
         * Modify the response and inject the debugbar (or data in headers)
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         * @param \Symfony\Component\HttpFoundation\Response $response
         * @return \Symfony\Component\HttpFoundation\Response 
         * @static 
         */ 
        public static function modifyResponse($request, $response)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->modifyResponse($request, $response);
        }
                    /**
         * Check if the Debugbar is enabled
         *
         * @return boolean 
         * @static 
         */ 
        public static function isEnabled()
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->isEnabled();
        }
                    /**
         * Collects the data from the collectors
         *
         * @return array 
         * @static 
         */ 
        public static function collect()
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->collect();
        }
                    /**
         * Injects the web debug toolbar into the given Response.
         *
         * @param \Symfony\Component\HttpFoundation\Response $response A Response instance
         * Based on https://github.com/symfony/WebProfilerBundle/blob/master/EventListener/WebDebugToolbarListener.php
         * @static 
         */ 
        public static function injectDebugbar($response)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->injectDebugbar($response);
        }
                    /**
         * Disable the Debugbar
         *
         * @static 
         */ 
        public static function disable()
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->disable();
        }
                    /**
         * Adds a measure
         *
         * @param string $label
         * @param float $start
         * @param float $end
         * @static 
         */ 
        public static function addMeasure($label, $start, $end)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->addMeasure($label, $start, $end);
        }
                    /**
         * Utility function to measure the execution of a Closure
         *
         * @param string $label
         * @param \Closure $closure
         * @return mixed 
         * @static 
         */ 
        public static function measure($label, $closure)
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->measure($label, $closure);
        }
                    /**
         * Collect data in a CLI request
         *
         * @return array 
         * @static 
         */ 
        public static function collectConsole()
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->collectConsole();
        }
                    /**
         * Adds a message to the MessagesCollector
         * 
         * A message can be anything from an object to a string
         *
         * @param mixed $message
         * @param string $label
         * @static 
         */ 
        public static function addMessage($message, $label = 'info')
        {
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->addMessage($message, $label);
        }
                    /**
         * Checks if a data collector has been added
         *
         * @param string $name
         * @return boolean 
         * @static 
         */ 
        public static function hasCollector($name)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->hasCollector($name);
        }
                    /**
         * Returns a data collector
         *
         * @param string $name
         * @return \DebugBar\DataCollector\DataCollectorInterface 
         * @throws DebugBarException
         * @static 
         */ 
        public static function getCollector($name)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getCollector($name);
        }
                    /**
         * Returns an array of all data collectors
         *
         * @return \DebugBar\array[DataCollectorInterface] 
         * @static 
         */ 
        public static function getCollectors()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getCollectors();
        }
                    /**
         * Sets the request id generator
         *
         * @param \DebugBar\RequestIdGeneratorInterface $generator
         * @return \Barryvdh\Debugbar\LaravelDebugbar 
         * @static 
         */ 
        public static function setRequestIdGenerator($generator)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->setRequestIdGenerator($generator);
        }
                    /**
         * 
         *
         * @return \DebugBar\RequestIdGeneratorInterface 
         * @static 
         */ 
        public static function getRequestIdGenerator()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getRequestIdGenerator();
        }
                    /**
         * Returns the id of the current request
         *
         * @return string 
         * @static 
         */ 
        public static function getCurrentRequestId()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getCurrentRequestId();
        }
                    /**
         * Sets the storage backend to use to store the collected data
         *
         * @param \DebugBar\StorageInterface $storage
         * @return \Barryvdh\Debugbar\LaravelDebugbar 
         * @static 
         */ 
        public static function setStorage($storage = null)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->setStorage($storage);
        }
                    /**
         * 
         *
         * @return \DebugBar\StorageInterface 
         * @static 
         */ 
        public static function getStorage()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getStorage();
        }
                    /**
         * Checks if the data will be persisted
         *
         * @return boolean 
         * @static 
         */ 
        public static function isDataPersisted()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->isDataPersisted();
        }
                    /**
         * Sets the HTTP driver
         *
         * @param \DebugBar\HttpDriverInterface $driver
         * @return \Barryvdh\Debugbar\LaravelDebugbar 
         * @static 
         */ 
        public static function setHttpDriver($driver)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->setHttpDriver($driver);
        }
                    /**
         * Returns the HTTP driver
         * 
         * If no http driver where defined, a PhpHttpDriver is automatically created
         *
         * @return \DebugBar\HttpDriverInterface 
         * @static 
         */ 
        public static function getHttpDriver()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getHttpDriver();
        }
                    /**
         * Returns collected data
         * 
         * Will collect the data if none have been collected yet
         *
         * @return array 
         * @static 
         */ 
        public static function getData()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getData();
        }
                    /**
         * Returns an array of HTTP headers containing the data
         *
         * @param string $headerName
         * @param integer $maxHeaderLength
         * @return array 
         * @static 
         */ 
        public static function getDataAsHeaders($headerName = 'phpdebugbar', $maxHeaderLength = 4096, $maxTotalHeaderLength = 250000)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getDataAsHeaders($headerName, $maxHeaderLength, $maxTotalHeaderLength);
        }
                    /**
         * Sends the data through the HTTP headers
         *
         * @param bool $useOpenHandler
         * @param string $headerName
         * @param integer $maxHeaderLength
         * @return \Barryvdh\Debugbar\LaravelDebugbar 
         * @static 
         */ 
        public static function sendDataInHeaders($useOpenHandler = null, $headerName = 'phpdebugbar', $maxHeaderLength = 4096)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->sendDataInHeaders($useOpenHandler, $headerName, $maxHeaderLength);
        }
                    /**
         * Stacks the data in the session for later rendering
         *
         * @static 
         */ 
        public static function stackData()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->stackData();
        }
                    /**
         * Checks if there is stacked data in the session
         *
         * @return boolean 
         * @static 
         */ 
        public static function hasStackedData()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->hasStackedData();
        }
                    /**
         * Returns the data stacked in the session
         *
         * @param boolean $delete Whether to delete the data in the session
         * @return array 
         * @static 
         */ 
        public static function getStackedData($delete = true)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getStackedData($delete);
        }
                    /**
         * Sets the key to use in the $_SESSION array
         *
         * @param string $ns
         * @return \Barryvdh\Debugbar\LaravelDebugbar 
         * @static 
         */ 
        public static function setStackDataSessionNamespace($ns)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->setStackDataSessionNamespace($ns);
        }
                    /**
         * Returns the key used in the $_SESSION array
         *
         * @return string 
         * @static 
         */ 
        public static function getStackDataSessionNamespace()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->getStackDataSessionNamespace();
        }
                    /**
         * Sets whether to only use the session to store stacked data even
         * if a storage is enabled
         *
         * @param boolean $enabled
         * @return \Barryvdh\Debugbar\LaravelDebugbar 
         * @static 
         */ 
        public static function setStackAlwaysUseSessionStorage($enabled = true)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->setStackAlwaysUseSessionStorage($enabled);
        }
                    /**
         * Checks if the session is always used to store stacked data
         * even if a storage is enabled
         *
         * @return boolean 
         * @static 
         */ 
        public static function isStackAlwaysUseSessionStorage()
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->isStackAlwaysUseSessionStorage();
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function offsetSet($key, $value)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->offsetSet($key, $value);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function offsetGet($key)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->offsetGet($key);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function offsetExists($key)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->offsetExists($key);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function offsetUnset($key)
        {            //Method inherited from \DebugBar\DebugBar         
                        /** @var \Barryvdh\Debugbar\LaravelDebugbar $instance */
                        return $instance->offsetUnset($key);
        }
         
    }
     
}

    namespace Intervention\Image\Facades { 
            /**
     * 
     *
     */ 
        class Image {
                    /**
         * Overrides configuration settings
         *
         * @param array $config
         * @return self 
         * @static 
         */ 
        public static function configure($config = [])
        {
                        /** @var \Intervention\Image\ImageManager $instance */
                        return $instance->configure($config);
        }
                    /**
         * Initiates an Image instance from different input types
         *
         * @param mixed $data
         * @return \Intervention\Image\Image 
         * @static 
         */ 
        public static function make($data)
        {
                        /** @var \Intervention\Image\ImageManager $instance */
                        return $instance->make($data);
        }
                    /**
         * Creates an empty image canvas
         *
         * @param int $width
         * @param int $height
         * @param mixed $background
         * @return \Intervention\Image\Image 
         * @static 
         */ 
        public static function canvas($width, $height, $background = null)
        {
                        /** @var \Intervention\Image\ImageManager $instance */
                        return $instance->canvas($width, $height, $background);
        }
                    /**
         * Create new cached image and run callback
         * (requires additional package intervention/imagecache)
         *
         * @param \Closure $callback
         * @param int $lifetime
         * @param boolean $returnObj
         * @return \Image 
         * @static 
         */ 
        public static function cache($callback, $lifetime = null, $returnObj = false)
        {
                        /** @var \Intervention\Image\ImageManager $instance */
                        return $instance->cache($callback, $lifetime, $returnObj);
        }
         
    }
     
}

    namespace Laravel\Nova { 
            /**
     * 
     *
     * @method static bool runsMigrations()
     */ 
        class Nova {
         
    }
     
}

    namespace Spatie\Geocoder\Facades { 
            /**
     * 
     *
     */ 
        class Geocoder {
                    /**
         * 
         *
         * @static 
         */ 
        public static function setApiKey($apiKey)
        {
                        /** @var \Spatie\Geocoder\Geocoder $instance */
                        return $instance->setApiKey($apiKey);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function setLanguage($language)
        {
                        /** @var \Spatie\Geocoder\Geocoder $instance */
                        return $instance->setLanguage($language);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function setRegion($region)
        {
                        /** @var \Spatie\Geocoder\Geocoder $instance */
                        return $instance->setRegion($region);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function setBounds($bounds)
        {
                        /** @var \Spatie\Geocoder\Geocoder $instance */
                        return $instance->setBounds($bounds);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function setCountry($country)
        {
                        /** @var \Spatie\Geocoder\Geocoder $instance */
                        return $instance->setCountry($country);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function getCoordinatesForAddress($address)
        {
                        /** @var \Spatie\Geocoder\Geocoder $instance */
                        return $instance->getCoordinatesForAddress($address);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function getAllCoordinatesForAddress($address)
        {
                        /** @var \Spatie\Geocoder\Geocoder $instance */
                        return $instance->getAllCoordinatesForAddress($address);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function getAddressForCoordinates($lat, $lng)
        {
                        /** @var \Spatie\Geocoder\Geocoder $instance */
                        return $instance->getAddressForCoordinates($lat, $lng);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function getAllAddressesForCoordinates($lat, $lng)
        {
                        /** @var \Spatie\Geocoder\Geocoder $instance */
                        return $instance->getAllAddressesForCoordinates($lat, $lng);
        }
         
    }
     
}

    namespace Spatie\LaravelIgnition\Facades { 
            /**
     * 
     *
     * @see \Spatie\FlareClient\Flare
     */ 
        class Flare {
                    /**
         * 
         *
         * @static 
         */ 
        public static function make($apiKey = null, $contextDetector = null)
        {
                        return \Spatie\FlareClient\Flare::make($apiKey, $contextDetector);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function setApiToken($apiToken)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->setApiToken($apiToken);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function apiTokenSet()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->apiTokenSet();
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function setBaseUrl($baseUrl)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->setBaseUrl($baseUrl);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function setStage($stage)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->setStage($stage);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function sendReportsImmediately()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->sendReportsImmediately();
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function determineVersionUsing($determineVersionCallable)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->determineVersionUsing($determineVersionCallable);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function reportErrorLevels($reportErrorLevels)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->reportErrorLevels($reportErrorLevels);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function filterExceptionsUsing($filterExceptionsCallable)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->filterExceptionsUsing($filterExceptionsCallable);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function filterReportsUsing($filterReportsCallable)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->filterReportsUsing($filterReportsCallable);
        }
                    /**
         * 
         *
         * @param array<class-string<ArgumentReducer>|ArgumentReducer>|\Spatie\Backtrace\Arguments\ArgumentReducers|null $argumentReducers
         * @static 
         */ 
        public static function argumentReducers($argumentReducers)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->argumentReducers($argumentReducers);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function withStackFrameArguments($withStackFrameArguments = true)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->withStackFrameArguments($withStackFrameArguments);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function version()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->version();
        }
                    /**
         * 
         *
         * @return array<int, FlareMiddleware|class-string<FlareMiddleware>> 
         * @static 
         */ 
        public static function getMiddleware()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->getMiddleware();
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function setContextProviderDetector($contextDetector)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->setContextProviderDetector($contextDetector);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function setContainer($container)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->setContainer($container);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function registerFlareHandlers()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->registerFlareHandlers();
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function registerExceptionHandler()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->registerExceptionHandler();
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function registerErrorHandler()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->registerErrorHandler();
        }
                    /**
         * 
         *
         * @param \Spatie\FlareClient\FlareMiddleware\FlareMiddleware|array<FlareMiddleware>|\Spatie\FlareClient\class-string<FlareMiddleware>|callable $middleware
         * @return \Spatie\FlareClient\Flare 
         * @static 
         */ 
        public static function registerMiddleware($middleware)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->registerMiddleware($middleware);
        }
                    /**
         * 
         *
         * @return array<int,FlareMiddleware|class-string<FlareMiddleware>> 
         * @static 
         */ 
        public static function getMiddlewares()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->getMiddlewares();
        }
                    /**
         * 
         *
         * @param string $name
         * @param string $messageLevel
         * @param array<int, mixed> $metaData
         * @return \Spatie\FlareClient\Flare 
         * @static 
         */ 
        public static function glow($name, $messageLevel = 'info', $metaData = [])
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->glow($name, $messageLevel, $metaData);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function handleException($throwable)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->handleException($throwable);
        }
                    /**
         * 
         *
         * @return mixed 
         * @static 
         */ 
        public static function handleError($code, $message, $file = '', $line = 0)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->handleError($code, $message, $file, $line);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function applicationPath($applicationPath)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->applicationPath($applicationPath);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function report($throwable, $callback = null, $report = null)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->report($throwable, $callback, $report);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function reportMessage($message, $logLevel, $callback = null)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->reportMessage($message, $logLevel, $callback);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function sendTestReport($throwable)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->sendTestReport($throwable);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function reset()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->reset();
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function anonymizeIp()
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->anonymizeIp();
        }
                    /**
         * 
         *
         * @param array<int, string> $fieldNames
         * @return \Spatie\FlareClient\Flare 
         * @static 
         */ 
        public static function censorRequestBodyFields($fieldNames)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->censorRequestBodyFields($fieldNames);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function createReport($throwable)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->createReport($throwable);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function createReportFromMessage($message, $logLevel)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->createReportFromMessage($message, $logLevel);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function stage($stage)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->stage($stage);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function messageLevel($messageLevel)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->messageLevel($messageLevel);
        }
                    /**
         * 
         *
         * @param string $groupName
         * @param mixed $default
         * @return array<int, mixed> 
         * @static 
         */ 
        public static function getGroup($groupName = 'context', $default = [])
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->getGroup($groupName, $default);
        }
                    /**
         * 
         *
         * @static 
         */ 
        public static function context($key, $value)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->context($key, $value);
        }
                    /**
         * 
         *
         * @param string $groupName
         * @param array<string, mixed> $properties
         * @return \Spatie\FlareClient\Flare 
         * @static 
         */ 
        public static function group($groupName, $properties)
        {
                        /** @var \Spatie\FlareClient\Flare $instance */
                        return $instance->group($groupName, $properties);
        }
         
    }
     
}

    namespace Illuminate\Support { 
            /**
     * 
     *
     */ 
        class Arr {
                    /**
         * 
         *
         * @see \App\Providers\MacroServiceProvider::boot()
         * @param array|null $values
         * @static 
         */ 
        public static function average($values)
        {
                        return \Illuminate\Support\Arr::average($values);
        }
         
    }
            /**
     * 
     *
     * @template TKey of array-key
     * @template-covariant TValue
     * @implements \ArrayAccess<TKey, TValue>
     * @implements \Illuminate\Support\Enumerable<TKey, TValue>
     */ 
        class Collection {
                    /**
         * 
         *
         * @see \Barryvdh\Debugbar\ServiceProvider::register()
         * @static 
         */ 
        public static function debug()
        {
                        return \Illuminate\Support\Collection::debug();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\After::__invoke()
         * @param mixed $currentItem
         * @param mixed $fallback
         * @static 
         */ 
        public static function after($currentItem, $fallback = null)
        {
                        return \Illuminate\Support\Collection::after($currentItem, $fallback);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\At::__invoke()
         * @param mixed $index
         * @static 
         */ 
        public static function at($index)
        {
                        return \Illuminate\Support\Collection::at($index);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Before::__invoke()
         * @param mixed $currentItem
         * @param mixed $fallback
         * @static 
         */ 
        public static function before($currentItem, $fallback = null)
        {
                        return \Illuminate\Support\Collection::before($currentItem, $fallback);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\ChunkBy::__invoke()
         * @param \Closure $callback
         * @param bool $preserveKeys
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function chunkBy($callback, $preserveKeys = false)
        {
                        return \Illuminate\Support\Collection::chunkBy($callback, $preserveKeys);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\CollectBy::__invoke()
         * @param mixed $key
         * @param mixed $default
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function collectBy($key, $default = null)
        {
                        return \Illuminate\Support\Collection::collectBy($key, $default);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\ContainsAll::__invoke()
         * @param mixed $values
         * @return bool 
         * @static 
         */ 
        public static function containsAll($values = [])
        {
                        return \Illuminate\Support\Collection::containsAll($values);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\ContainsAny::__invoke()
         * @param mixed $values
         * @return bool 
         * @static 
         */ 
        public static function containsAny($values = [])
        {
                        return \Illuminate\Support\Collection::containsAny($values);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\EachCons::__invoke()
         * @param int $chunkSize
         * @param bool $preserveKeys
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function eachCons($chunkSize, $preserveKeys = false)
        {
                        return \Illuminate\Support\Collection::eachCons($chunkSize, $preserveKeys);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Eighth::__invoke()
         * @static 
         */ 
        public static function eighth()
        {
                        return \Illuminate\Support\Collection::eighth();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Extract::__invoke()
         * @param mixed $keys
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function extract($keys)
        {
                        return \Illuminate\Support\Collection::extract($keys);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Fifth::__invoke()
         * @static 
         */ 
        public static function fifth()
        {
                        return \Illuminate\Support\Collection::fifth();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\FilterMap::__invoke()
         * @param callable $callback
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function filterMap($callback)
        {
                        return \Illuminate\Support\Collection::filterMap($callback);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\FirstOrPush::__invoke()
         * @param mixed $callback
         * @param mixed $value
         * @param mixed $instance
         * @static 
         */ 
        public static function firstOrPush($callback, $value, $instance = null)
        {
                        return \Illuminate\Support\Collection::firstOrPush($callback, $value, $instance);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Fourth::__invoke()
         * @static 
         */ 
        public static function fourth()
        {
                        return \Illuminate\Support\Collection::fourth();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\FromPairs::__invoke()
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function fromPairs()
        {
                        return \Illuminate\Support\Collection::fromPairs();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\GetCaseInsensitive::__invoke()
         * @param mixed|null $key
         * @return mixed|null 
         * @static 
         */ 
        public static function getCaseInsensitive($key)
        {
                        return \Illuminate\Support\Collection::getCaseInsensitive($key);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\GetNth::__invoke()
         * @param int $nth
         * @static 
         */ 
        public static function getNth($nth)
        {
                        return \Illuminate\Support\Collection::getNth($nth);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Glob::__invoke()
         * @param string $pattern
         * @param int $flags
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function glob($pattern, $flags = 0)
        {
                        return \Illuminate\Support\Collection::glob($pattern, $flags);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\GroupByModel::__invoke()
         * @param mixed $callback
         * @param bool $preserveKeys
         * @param mixed $modelKey
         * @param mixed $itemsKey
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function groupByModel($callback, $preserveKeys = false, $modelKey = 0, $itemsKey = 1)
        {
                        return \Illuminate\Support\Collection::groupByModel($callback, $preserveKeys, $modelKey, $itemsKey);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\HasCaseInsensitive::__invoke()
         * @param mixed|null $key
         * @return bool 
         * @static 
         */ 
        public static function hasCaseInsensitive($key)
        {
                        return \Illuminate\Support\Collection::hasCaseInsensitive($key);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Head::__invoke()
         * @static 
         */ 
        public static function head()
        {
                        return \Illuminate\Support\Collection::head();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\IfMacro::__invoke()
         * @param mixed|null $if
         * @param mixed|null $then
         * @param mixed|null $else
         * @return mixed|null 
         * @static 
         */ 
        public static function if($if, $then = null, $else = null)
        {
                        return \Illuminate\Support\Collection::if($if, $then, $else);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\IfAny::__invoke()
         * @param callable $callback
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function ifAny($callback)
        {
                        return \Illuminate\Support\Collection::ifAny($callback);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\IfEmpty::__invoke()
         * @param callable $callback
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function ifEmpty($callback)
        {
                        return \Illuminate\Support\Collection::ifEmpty($callback);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\InsertAfter::__invoke()
         * @param mixed $after
         * @param mixed $item
         * @param mixed $key
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function insertAfter($after, $item, $key = null)
        {
                        return \Illuminate\Support\Collection::insertAfter($after, $item, $key);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\InsertAfterKey::__invoke()
         * @param mixed $afterKey
         * @param mixed $item
         * @param mixed $key
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function insertAfterKey($afterKey, $item, $key = null)
        {
                        return \Illuminate\Support\Collection::insertAfterKey($afterKey, $item, $key);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\InsertAt::__invoke()
         * @param int $index
         * @param mixed $item
         * @param mixed $key
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function insertAt($index, $item, $key = null)
        {
                        return \Illuminate\Support\Collection::insertAt($index, $item, $key);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\InsertBefore::__invoke()
         * @param mixed $before
         * @param mixed $item
         * @param mixed $key
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function insertBefore($before, $item, $key = null)
        {
                        return \Illuminate\Support\Collection::insertBefore($before, $item, $key);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\InsertBeforeKey::__invoke()
         * @param mixed $beforeKey
         * @param mixed $item
         * @param mixed $key
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function insertBeforeKey($beforeKey, $item, $key = null)
        {
                        return \Illuminate\Support\Collection::insertBeforeKey($beforeKey, $item, $key);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Ninth::__invoke()
         * @static 
         */ 
        public static function ninth()
        {
                        return \Illuminate\Support\Collection::ninth();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\None::__invoke()
         * @param mixed $key
         * @param mixed $value
         * @return bool 
         * @static 
         */ 
        public static function none($key, $value = null)
        {
                        return \Illuminate\Support\Collection::none($key, $value);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Paginate::__invoke()
         * @param int $perPage
         * @param string $pageName
         * @param int|null $page
         * @param int|null $total
         * @param array $options
         * @return \Illuminate\Pagination\LengthAwarePaginator 
         * @static 
         */ 
        public static function paginate($perPage = 15, $pageName = 'page', $page = null, $total = null, $options = [])
        {
                        return \Illuminate\Support\Collection::paginate($perPage, $pageName, $page, $total, $options);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\ParallelMap::__invoke()
         * @param callable $callback
         * @param mixed $workers
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function parallelMap($callback, $workers = null)
        {
                        return \Illuminate\Support\Collection::parallelMap($callback, $workers);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Path::__invoke()
         * @param mixed $key
         * @param mixed $default
         * @static 
         */ 
        public static function path($key, $default = null)
        {
                        return \Illuminate\Support\Collection::path($key, $default);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\PluckMany::__invoke()
         * @param mixed $keys
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function pluckMany($keys)
        {
                        return \Illuminate\Support\Collection::pluckMany($keys);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\PluckManyValues::__invoke()
         * @param mixed $keys
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function pluckManyValues($keys)
        {
                        return \Illuminate\Support\Collection::pluckManyValues($keys);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\PluckToArray::__invoke()
         * @param mixed $value
         * @param mixed $key
         * @return array 
         * @static 
         */ 
        public static function pluckToArray($value, $key = null)
        {
                        return \Illuminate\Support\Collection::pluckToArray($value, $key);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Prioritize::__invoke()
         * @param callable $callable
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function prioritize($callable)
        {
                        return \Illuminate\Support\Collection::prioritize($callable);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Recursive::__invoke()
         * @param float $maxDepth
         * @param int $depth
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function recursive($maxDepth = INF, $depth = 0)
        {
                        return \Illuminate\Support\Collection::recursive($maxDepth, $depth);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Rotate::__invoke()
         * @param int $offset
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function rotate($offset)
        {
                        return \Illuminate\Support\Collection::rotate($offset);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Second::__invoke()
         * @static 
         */ 
        public static function second()
        {
                        return \Illuminate\Support\Collection::second();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\SectionBy::__invoke()
         * @param mixed $key
         * @param bool $preserveKeys
         * @param mixed $sectionKey
         * @param mixed $itemsKey
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function sectionBy($key, $preserveKeys = false, $sectionKey = 0, $itemsKey = 1)
        {
                        return \Illuminate\Support\Collection::sectionBy($key, $preserveKeys, $sectionKey, $itemsKey);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Seventh::__invoke()
         * @static 
         */ 
        public static function seventh()
        {
                        return \Illuminate\Support\Collection::seventh();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\SimplePaginate::__invoke()
         * @param int $perPage
         * @param string $pageName
         * @param int|null $page
         * @param array $options
         * @return \Illuminate\Pagination\Paginator 
         * @static 
         */ 
        public static function simplePaginate($perPage = 15, $pageName = 'page', $page = null, $options = [])
        {
                        return \Illuminate\Support\Collection::simplePaginate($perPage, $pageName, $page, $options);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Sixth::__invoke()
         * @static 
         */ 
        public static function sixth()
        {
                        return \Illuminate\Support\Collection::sixth();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\SliceBefore::__invoke()
         * @param mixed $callback
         * @param bool $preserveKeys
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function sliceBefore($callback, $preserveKeys = false)
        {
                        return \Illuminate\Support\Collection::sliceBefore($callback, $preserveKeys);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Tail::__invoke()
         * @param bool $preserveKeys
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function tail($preserveKeys = false)
        {
                        return \Illuminate\Support\Collection::tail($preserveKeys);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Tenth::__invoke()
         * @static 
         */ 
        public static function tenth()
        {
                        return \Illuminate\Support\Collection::tenth();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Third::__invoke()
         * @static 
         */ 
        public static function third()
        {
                        return \Illuminate\Support\Collection::third();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\ToPairs::__invoke()
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function toPairs()
        {
                        return \Illuminate\Support\Collection::toPairs();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Transpose::__invoke()
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function transpose()
        {
                        return \Illuminate\Support\Collection::transpose();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\TryCatch::__invoke()
         * @static 
         */ 
        public static function try()
        {
                        return \Illuminate\Support\Collection::try();
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\Validate::__invoke()
         * @param mixed $callback
         * @return bool 
         * @static 
         */ 
        public static function validate($callback)
        {
                        return \Illuminate\Support\Collection::validate($callback);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\WeightedRandom::__invoke()
         * @param callable|string $weightAttribute
         * @param mixed $default
         * @static 
         */ 
        public static function weightedRandom($weightAttribute, $default = null)
        {
                        return \Illuminate\Support\Collection::weightedRandom($weightAttribute, $default);
        }
                    /**
         * 
         *
         * @see \Spatie\CollectionMacros\Macros\WithSize::__invoke()
         * @param int $size
         * @return \Illuminate\Support\Collection 
         * @static 
         */ 
        public static function withSize($size)
        {
                        return \Illuminate\Support\Collection::withSize($size);
        }
                    /**
         * 
         *
         * @see \Laravel\Nova\NovaServiceProvider::registerCollectionMacros()
         * @static 
         */ 
        public static function isAssoc()
        {
                        return \Illuminate\Support\Collection::isAssoc();
        }
         
    }
     
}

    namespace Illuminate\Http { 
            /**
     * 
     *
     */ 
        class Request {
                    /**
         * 
         *
         * @see \Illuminate\Foundation\Providers\FoundationServiceProvider::registerRequestValidation()
         * @param array $rules
         * @param mixed $params
         * @static 
         */ 
        public static function validate($rules, ...$params)
        {
                        return \Illuminate\Http\Request::validate($rules, ...$params);
        }
                    /**
         * 
         *
         * @see \Illuminate\Foundation\Providers\FoundationServiceProvider::registerRequestValidation()
         * @param string $errorBag
         * @param array $rules
         * @param mixed $params
         * @static 
         */ 
        public static function validateWithBag($errorBag, $rules, ...$params)
        {
                        return \Illuminate\Http\Request::validateWithBag($errorBag, $rules, ...$params);
        }
                    /**
         * 
         *
         * @see \Illuminate\Foundation\Providers\FoundationServiceProvider::registerRequestSignatureValidation()
         * @param mixed $absolute
         * @static 
         */ 
        public static function hasValidSignature($absolute = true)
        {
                        return \Illuminate\Http\Request::hasValidSignature($absolute);
        }
                    /**
         * 
         *
         * @see \Illuminate\Foundation\Providers\FoundationServiceProvider::registerRequestSignatureValidation()
         * @static 
         */ 
        public static function hasValidRelativeSignature()
        {
                        return \Illuminate\Http\Request::hasValidRelativeSignature();
        }
                    /**
         * 
         *
         * @see \Illuminate\Foundation\Providers\FoundationServiceProvider::registerRequestSignatureValidation()
         * @param mixed $ignoreQuery
         * @param mixed $absolute
         * @static 
         */ 
        public static function hasValidSignatureWhileIgnoring($ignoreQuery = [], $absolute = true)
        {
                        return \Illuminate\Http\Request::hasValidSignatureWhileIgnoring($ignoreQuery, $absolute);
        }
                    /**
         * 
         *
         * @see \Inertia\ServiceProvider::registerRequestMacro()
         * @static 
         */ 
        public static function inertia()
        {
                        return \Illuminate\Http\Request::inertia();
        }
         
    }
     
}

    namespace Illuminate\Routing { 
            /**
     * 
     *
     * @mixin \Illuminate\Routing\RouteRegistrar
     */ 
        class Router {
                    /**
         * 
         *
         * @see \Inertia\ServiceProvider::registerRouterMacro()
         * @param mixed $uri
         * @param mixed $component
         * @param mixed $props
         * @static 
         */ 
        public static function inertia($uri, $component, $props = [])
        {
                        return \Illuminate\Routing\Router::inertia($uri, $component, $props);
        }
                    /**
         * 
         *
         * @see \Laravel\Ui\AuthRouteMethods::auth()
         * @param mixed $options
         * @static 
         */ 
        public static function auth($options = [])
        {
                        return \Illuminate\Routing\Router::auth($options);
        }
                    /**
         * 
         *
         * @see \Laravel\Ui\AuthRouteMethods::resetPassword()
         * @static 
         */ 
        public static function resetPassword()
        {
                        return \Illuminate\Routing\Router::resetPassword();
        }
                    /**
         * 
         *
         * @see \Laravel\Ui\AuthRouteMethods::confirmPassword()
         * @static 
         */ 
        public static function confirmPassword()
        {
                        return \Illuminate\Routing\Router::confirmPassword();
        }
                    /**
         * 
         *
         * @see \Laravel\Ui\AuthRouteMethods::emailVerification()
         * @static 
         */ 
        public static function emailVerification()
        {
                        return \Illuminate\Routing\Router::emailVerification();
        }
         
    }
     
}

    namespace Illuminate\Testing { 
            /**
     * 
     *
     * @mixin \Illuminate\Http\Response
     */ 
        class TestResponse {
                    /**
         * 
         *
         * @see \Inertia\Testing\TestResponseMacros::assertInertia()
         * @param \Closure|null $callback
         * @static 
         */ 
        public static function assertInertia($callback = null)
        {
                        return \Illuminate\Testing\TestResponse::assertInertia($callback);
        }
                    /**
         * 
         *
         * @see \Inertia\Testing\TestResponseMacros::inertiaPage()
         * @static 
         */ 
        public static function inertiaPage()
        {
                        return \Illuminate\Testing\TestResponse::inertiaPage();
        }
         
    }
     
}

    namespace Laravel\Nova\Fields { 
            /**
     * 
     *
     * @phpstan-type TFieldValidationRules \Stringable|string|\Illuminate\Contracts\Validation\ValidationRule|\Illuminate\Contracts\Validation\Rule|\Illuminate\Contracts\Validation\InvokableRule|callable
     * @phpstan-type TValidationRules array<int, TFieldValidationRules>|\Stringable|string|(callable(string, mixed, \Closure):(void))
     * @method static static make(mixed $name, string|\Closure|callable|object|null $attribute = null, callable|null $resolveCallback = null)
     */ 
        class Field {
                    /**
         * 
         *
         * @see \App\Nova\NovaMacros::handle()
         * @static 
         */ 
        public static function deferrable()
        {
                        return \Laravel\Nova\Fields\Field::deferrable();
        }
         
    }
     
}

    namespace Illuminate\Database\Eloquent\Relations { 
            /**
     * 
     *
     */ 
        class BelongsToMany {
         
    }
            /**
     * 
     *
     */ 
        class Relation {
                    /**
         * 
         *
         * @see \Laravel\Nova\Query\Mixin\BelongsToMany::getDefaultPivotAttributes()
         * @static 
         */ 
        public static function getDefaultPivotAttributes()
        {
                        return \Illuminate\Database\Eloquent\Relations\Relation::getDefaultPivotAttributes();
        }
                    /**
         * 
         *
         * @see \Laravel\Nova\Query\Mixin\BelongsToMany::applyDefaultPivotQuery()
         * @param mixed $query
         * @static 
         */ 
        public static function applyDefaultPivotQuery($query)
        {
                        return \Illuminate\Database\Eloquent\Relations\Relation::applyDefaultPivotQuery($query);
        }
         
    }
     
}


namespace  { 
            class Debugbar extends \Barryvdh\Debugbar\Facades\Debugbar {}
            class Image extends \Intervention\Image\Facades\Image {}
            class Nova extends \Laravel\Nova\Nova {}
            class Geocoder extends \Spatie\Geocoder\Facades\Geocoder {}
            class Flare extends \Spatie\LaravelIgnition\Facades\Flare {}
     
}




