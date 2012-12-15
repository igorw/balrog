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

function balrog_sort($array, $comparator)
{
    usort($array, $comparator);
    return $array;
}

function balrog_front_controller($baseDir)
{
    $environment = Lisphp_Environment::full();
    $scope = new Lisphp_Scope($environment);

    $scope['require'] = new Lisphp_Runtime_PHPFunction(function ($file) use ($scope) {
        $program = Lisphp_Program::load(__DIR__.'/'.$file.'.lisphp');
        return $program->execute($scope);
    });
    $scope['base-dir'] = $baseDir;

    $filename = __DIR__.'/front-controller.lisphp';
    $program = Lisphp_Program::load($filename);
    $program->execute($scope);
}
