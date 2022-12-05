<?php

namespace Fawpami;

class Scripts
{
    /** @var string[] */
    private static array $menuPages = [];

    /** @var string[] */
    private static array $postTypes = [];

    public static function registerMenuPage(string $page): void
    {
        self::$menuPages[] = $page;
    }

    public static function registerPostType(string $postType): void
    {
        self::$postTypes[] = $postType;
    }

    public static function print(): void
    {
        $statements = [];

        foreach (self::$menuPages as $menuPage) {
            $statements[] = self::getAddClassJs(self::getMenuPageClass($menuPage));
        }

        foreach (self::$postTypes as $postType) {
            $statements[] = self::getAddClassJs(self::getPostTypeClass($postType));
        }

        $statements = implode("\n", $statements);

        echo <<<HTML
<!-- FA WP Admin Menu Icons icon styles -->
<script>
(function (){
    function main() {
        $statements
    }

    if (document.readyState !== 'loading') {
        main();
    } else {
        document.addEventListener('DOMContentLoaded', main);
    }
})();
</script>
HTML;
    }

    private static function getAddClassJs(string $class): string
    {
        return <<<JS
if (document.querySelectorAll('.$class .svg')[0]) {
    document.querySelectorAll('.$class .svg')[0]
        .classList
        .add('wp-menu-image--fawpami');
}
JS;
    }

    private static function getMenuPageClass(string $page): string
    {
        return "toplevel_page_$page";
    }

    private static function getPostTypeClass(string $postType): string
    {
        return "menu-icon-$postType";
    }
}
