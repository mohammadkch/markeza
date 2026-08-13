<?php

if (! function_exists('sanitize_blog_rich_text')) {
    function sanitize_blog_rich_text(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        $allowedTags = '<p><br><strong><b><em><i><u><ul><ol><li><a>';
        $html = strip_tags($html, $allowedTags);

        $document = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="utf-8" ?><div id="blog-content-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $document->getElementById('blog-content-root');
        if ($root === null) {
            return '';
        }

        foreach ($root->getElementsByTagName('*') as $element) {
            foreach (iterator_to_array($element->attributes ?? []) as $attribute) {
                if ($element->tagName !== 'a' || $attribute->name !== 'href') {
                    $element->removeAttribute($attribute->name);
                }
            }

            if ($element->tagName === 'a') {
                $href = trim($element->getAttribute('href'));
                if (! preg_match('~^(https?://|mailto:|tel:|/)~i', $href)) {
                    $element->removeAttribute('href');
                } elseif (preg_match('~^https?://~i', $href)) {
                    $element->setAttribute('rel', 'noopener noreferrer');
                }
            }
        }

        $clean = '';
        foreach ($root->childNodes as $child) {
            $clean .= $document->saveHTML($child);
        }

        return trim($clean);
    }
}

if (! function_exists('render_blog_rich_text')) {
    function render_blog_rich_text(string $content): string
    {
        if ($content === strip_tags($content)) {
            return nl2br(esc($content));
        }

        return sanitize_blog_rich_text($content);
    }
}
