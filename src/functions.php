<?php

function balrog_split_raw_post($filename, $contents)
{
    preg_match('#---\n(.+)---\n(.+)#s', $contents, $matches);
    if (!$matches) {
        throw new \RuntimeException(sprintf('Could not parse front matter in blog post %s', basename($filename)));
    }

    list($_, $front, $body) = $matches;

    return [
        'front' => $front,
        'body'  => $body,
    ];
}

function balrog_render_php($baseDir, $filename, $vars)
{
    extract($vars);
    return include $baseDir.'/layouts'.$filename;
}

function balrog_sort($array, $comparator)
{
    usort($array, $comparator);
    return $array;
}
