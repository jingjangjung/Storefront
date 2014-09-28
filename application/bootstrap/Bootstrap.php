<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public $frontController;


    protected function _initLogging()
    {
        // logging bootstrap resource depends on the front controller
        $this->bootstrap('frontController');

        // creating an instance of Zend_Log with set up of different environments
        $logger = new Zend_Log();
        $writer = 'production' == $this->getEnvironment() ?
            new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/app.log') :
            new Zend_Log_Writer_Firebug();
        $logger->addWriter($writer);

        // filtering for critial issues only under production environment
        if('production' == $this->getEnvironment())
        {
            $filter = new Zend_Log_Filter_Priority(Zend_Log::CRIT);
            $logger->addFilter($filter);
        }

        // assigning the logger to a propected property of Bootstrap
        $this->_logger = $logger;
        Zend_Registry::set('log', $logger);
    }


    protected function _initLocale()
    {
        $locale = new Zend_Locale('en_GB');
        Zend_Registry::set('Zend_Locate', $locale);
    }


    protected function _initViewSettings()
    {
        $this->bootstrap('view');
        $this->_view = $this->getResource('view');

        // setting encoding and doctype
        $this->_view->setEncoding('UTF-8');
        $this->_view->doctype('XHTML1_STRICT');

        // setting content type and language (metadata)
        $this->_view
            ->headMeta()
            ->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');

        $this->_view
            ->headMeta()
            ->appendHttpEquiv('Content-Language', 'en-US');

        // settings css links
        $this->_view
            ->headStyle()
            ->setStyle('@import "/css/access.css";');

        $this->_view
            ->headLink()
            ->appendStylesheet('/css/reset.css');

        $this->_view
            ->headLink()
            ->appendStylesheet('/css/main.css');

        $this->_view
            ->headLink()
            ->appendStylesheet('/css/form.css');

        // title
        $this->_view->headTitle('Storefront');

        // separator string for segments
        $this->_view->headTitle()->setSeparator(' - ');
    }


    protected function __initDbProfiler()
    {
        $this->_logger->info('Bootstrap ' . __METHOD__);

        // disabling the profiler in a production environment
        if('production' !== $this->getEnvironment())
        {
            $this->bootstrap('db');
            $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
            $profiler->setEnabled(true);

            $this->getPluginResource('db')
                ->getAdapter()
                ->setProfiler($profiler);
        }
    }


    protected function _initDefaultModuleAutoloader()
    {
        $this->_logger->info('Bootstrap ' . __METHOD__);

        // instantiating a the autoloader based on module directory
        $this->_resourceLoader = new Zend_Application_Module_Autoloader(
            array(
                'namespace' => 'Storefront',
                'basePath' => APPLICATION_PATH . '/modules/storefront'
            )
        );

        // customizing resource types
        $this->_resourceLoader->addResourceTypes(
            array(
                'modelResource' => array(
                    'path' => 'models/resources',
                    'namespace' => 'Resource'
                ),
                'service' => array(
                    'path' => 'services',
                    'namespace' => 'Service'
                )
        ));
    }
}