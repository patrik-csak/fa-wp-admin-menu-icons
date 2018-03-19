<?php

namespace Fawpami;

class Styles
{
    public function add()
    {
        wp_add_inline_style(
            'admin-menu',
            '#adminmenu div.wp-menu-image--fawpami.svg { background-size: 20px 20px }'
        );
    }
}
