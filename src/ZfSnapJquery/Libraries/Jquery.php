<?php

namespace ZfSnapJquery\Libraries;

/**
 * Jquery
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Jquery implements LibraryIterface
{
    const CDN_JQUERY = 'http://code.jquery.com/jquery-%s.min.js';
    const CDN_GOOGLE = '//ajax.googleapis.com/ajax/libs/jquery/%s/jquery.min.js';
    const CDN_MICROSOFT = 'http://ajax.aspnetcdn.com/ajax/jQuery/jquery-%s.min.js';
    const CDN_CDNJS = '//cdnjs.cloudflare.com/ajax/libs/jquery/%s/jquery.min.js';
    const CDN_DEFAULT = self::CDN_JQUERY;
    const VERSION_DEFAULT = '2.0.3';

    /**
     * @var bool
     */
    private $enabled = true;

    /**
     * @var bool
     */
    private $noConflictMode = false;

    /**
     * @var string
     */
    private $version = self::VERSION_DEFAULT;

    /**
     * @var string
     */
    private $cdnScript = self::CDN_DEFAULT;

    /**
     * @return bool
     */
    public function isNoConflictMode()
    {
        return (bool) $this->noConflictMode;
    }

    /**
     * @param bool $noConflictMode
     * @return Jquery
     */
    public function setNoConflictMode($noConflictMode)
    {
        $this->noConflictMode = (bool) $noConflictMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return Jquery
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getCdnScript()
    {
        if (strpos($this->cdnScript, '%s') === false) {
            return $this->cdnScript;
        }
        return sprintf($this->cdnScript, $this->getVersion());
    }

    /**
     * @param string $cdnScript
     * @return Jquery
     */
    public function setCdnScript($cdnScript)
    {
        $this->cdnScript = $cdnScript;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return Jquery
     */
    public function setEnabled($enabled = true)
    {
        $this->enabled = (bool) $enabled;
        return $this;
    }

    /**
     * @return array|string|null
     */
    public function getScripts()
    {
        if ($this->isEnabled()) {
            $script = $this->getCdnScript();

            return $script;
        }
        return null;
    }

    /**
     * @return array|string|null
     */
    public function getStyles()
    {
        return null;
    }
}
