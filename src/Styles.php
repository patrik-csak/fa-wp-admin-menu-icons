<?php

namespace Fawpami;

class Styles
{
    public static function add(): void
    {
        wp_add_inline_style(
            'admin-menu',
            <<<'CSS'
/* FA WP Admin Menu Icons icon styles */
#adminmenu div.wp-menu-image--fawpami.svg {
    background-size: 16px 16px;
}
CSS,
        );
    }
}
