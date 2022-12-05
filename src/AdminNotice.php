<?php

namespace Fawpami;

class AdminNotice
{
    /**
     * @param string $message
     * @param string $style 'error', 'info', 'success', 'warning', or ''
     */
    public function __construct(
        public string $message,
        public string $style = '',
    ) {
    }
}
