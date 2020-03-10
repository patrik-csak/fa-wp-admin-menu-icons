<?php

namespace Fawpami;

class Styles
{
    public function add(): void
    {
        $css = <<<CSS
#adminmenu div.wp-menu-image--fawpami.svg { background-size: 20px 20px }
CSS;

        wp_add_inline_style('admin-menu', $css);
    }
}
