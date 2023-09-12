<?php
defined('_JEXEC') or die('Restricted access');

class PlgSystemJsCssControl extends JPlugin
{
    protected $_request;
    protected $_exclude_js_files;
    protected $_exclude_css_files;

    function __construct(&$subject, $config)
    {
        // Do not execute in the administration
        $app = JFactory::getApplication();

        if($app->isAdmin())
        {
            return;
        }

        parent::__construct($subject, $config);
        $this->loadLanguage('plg_system_jscsscontrol', JPATH_ADMINISTRATOR);

        $this->set('_request', JFactory::getApplication()->input);
    }

    /**
     * Does the first check before the head is compiled
     */
    public function onBeforeCompileHead()
    {
        $js = $this->params->get('js');
        $css = $this->params->get('css');

        if(!empty($js) OR !empty($css))
        {
            $document = JFactory::getDocument();

            // Exclude JavaScript files
            if(!empty($js))
            {
                $this->_exclude_js_files = $this->getFilesToExclude($js);
            }

            if(!empty($this->_exclude_js_files))
            {
                $loaded_files = $document->_scripts;
                $this->excludeFilesOnBeforeCompileHead($this->_exclude_js_files, $loaded_files);
                $document->_scripts = $loaded_files;
            }

            // Exclude CSS files
            if(!empty($css))
            {
                $this->_exclude_css_files = $this->getFilesToExclude($css);
            }

            if(!empty($this->_exclude_css_files))
            {
                $loaded_files = $document->_styleSheets;
                $this->excludeFilesOnBeforeCompileHead($this->_exclude_css_files, $loaded_files);
                $document->_styleSheets = $loaded_files;
            }
        }

        // Debug mode
        $debug = $this->params->get('debug');

        if(!empty($debug))
        {
            $debug_output = $this->getDebugInformation();
            JFactory::getApplication()->enqueueMessage(JTEXT::sprintf('PLG_JSCSSCONTROL_DEBUGOUTPUT', $debug_output, $debug_output));
        }
    }

    /**
     * Checks the output to remove also files from the template and other extensions
     */
    public function onAfterRender()
    {
        if(!empty($this->_exclude_js_files) OR !empty($this->_exclude_css_files))
        {
            // Remove JS and CSS from output
            $body = JResponse::getBody();

            if(!empty($this->_exclude_js_files))
            {
                preg_match_all('@<script[^>]*src=["|\'][^>]*\.js(\?[^>]*)?["|\'][^>]*/?>.*</script>@isU', $body, $matches_js);
                $this->excludeFilesOnAfterRender($body, $this->_exclude_js_files, $matches_js);
            }

            if(!empty($this->_exclude_css_files))
            {
                preg_match_all('@<link[^>]*href=["|\'][^>]*\.css(\?[^>]*)?["|\'][^>]*/?>@isU', $body, $matches_css);
                $this->excludeFilesOnAfterRender($body, $this->_exclude_css_files, $matches_css);
            }

            JResponse::setBody($body);
        }
    }

    private function getFilesToExclude($type)
    {
        $exclude_files = array();

        $params = array_map('trim', explode("\n", $type));
        $lines = array();

        foreach($params as $params_line)
        {
            $lines[] = array_map('trim', explode('|', $params_line));
        }

        foreach($lines as $line)
        {
            $exclude_file = true;

            if(isset($line[1]))
            {
                $parameters = $line[1];
            }

            if(!empty($parameters))
            {
                $parameters = array_map('trim', explode(',', $parameters));

                foreach($parameters as $parameter)
                {
                    $parameter = array_map('trim', explode('=', $parameter));

                    $exclude_file = $this->checkParameters($parameter);

                    if($exclude_file == false)
                    {
                        break;
                    }
                }
            }

            if($exclude_file == true)
            {
                $exclude_files[] = $line[0];
            }

            unset($parameters);
        }

        return $exclude_files;
    }

    private function excludeFilesOnBeforeCompileHead(&$exclude_files, &$loaded_files)
    {
        $loaded_files_keys = array_keys($loaded_files);

        foreach($loaded_files_keys as $loaded_file)
        {
            foreach($exclude_files as $exclude_file)
            {
                if(preg_match('@'.preg_quote($exclude_file).'@', $loaded_file))
                {
                    unset($loaded_files[$loaded_file]);
                    unset($exclude_files[array_search($exclude_file, $exclude_files)]);
                    break;
                }
            }
        }
    }

    private function excludeFilesOnAfterRender(&$body, &$exclude_files, $matches)
    {
        foreach($matches[0] as $match)
        {
            foreach($exclude_files as $exclude_file)
            {
                if(preg_match('@'.preg_quote($exclude_file).'@', $match))
                {
                    $body = str_replace($match, '', $body);
                    unset($exclude_files[array_search($exclude_file, $exclude_files)]);
                    break;
                }
            }
        }
    }

    private function checkParameters($parameter)
    {
        $name = $this->_request->get($parameter[0], array(0), 'array');

        if($name[0] == $parameter[1])
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function getDebugInformation()
    {
        $debug_array = array();

        $debug_array['option'] = $this->_request->getWord('option');
        $debug_array['view'] = $this->_request->getWord('view');
        $debug_array['task'] = $this->_request->getCmd('task');
        $debug_array['func'] = $this->_request->getWord('func');
        $debug_array['layout'] = $this->_request->getWord('layout');
        $debug_array['Itemid'] = $this->_request->getCmd('Itemid');
        $debug_array['id'] = $this->_request->getCmd('id');

        $debug_array = array_filter($debug_array);

        $debug_output = array();

        foreach($debug_array as $key => $value)
        {
            if(!empty($value))
            {
                $debug_output[] = $key.'='.$value;
            }
        }

        $debug_output = implode(',', $debug_output);

        return $debug_output;
    }

}
