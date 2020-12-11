<?php

namespace App\Models\Traits;

use League\HTMLToMarkdown\HtmlConverter;

trait UsesMarkdown {
    public function getMarkdown($fields)
    {
        $converter = new HtmlConverter(array('strip_tags' => true));
        $converter->getConfig()->setOption('bold_style', '*');
        $converter->getConfig()->setOption('use_autolinks', false);

        foreach ($fields as $field)
            $html = $this->attributes[$field]."\n";

        $markdown = $converter->convert($html);

        return $markdown;
    }
}

