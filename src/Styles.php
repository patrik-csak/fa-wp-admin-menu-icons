<?php

namespace Fawpami;

class Styles
{
    public static function add(): void
    {
        wp_add_inline_style(
            'admin-menu',
            '#adminmenu div.wp-menu-image--fawpami.svg { background-size: 20px 20px }',
        );
    }
}
