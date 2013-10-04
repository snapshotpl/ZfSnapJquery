<?php

namespace ZfSnapJquery\Libraries;

/**
 * Library interface
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
interface LibraryIterface
{
    /**
     * @return array|string|null
     */
    public function getScripts();

    /**
     * @return array|string|null
     */
    public function getStyles();

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled = true);
}
