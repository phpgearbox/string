<?php
////////////////////////////////////////////////////////////////////////////////
// __________ __             ________                   __________
// \______   \  |__ ______  /  _____/  ____ _____ ______\______   \ _______  ___
//  |     ___/  |  \\____ \/   \  ____/ __ \\__  \\_  __ \    |  _//  _ \  \/  /
//  |    |   |   Y  \  |_> >    \_\  \  ___/ / __ \|  | \/    |   (  <_> >    <
//  |____|   |___|  /   __/ \______  /\___  >____  /__|  |______  /\____/__/\_ \
//                \/|__|           \/     \/     \/             \/            \/
// -----------------------------------------------------------------------------
//          Designed and Developed by Brad Jones <brad @="bjc.id.au" />
// -----------------------------------------------------------------------------
////////////////////////////////////////////////////////////////////////////////

/*
 * Include our local composer autoloader just in case
 * we are called with a globally installed version of robo.
 */
require_once(__DIR__.'/vendor/autoload.php');

use Gears\String\Str;
use Symfony\Component\Yaml\Yaml;
use phpDocumentor\Reflection\DocBlockFactory;

class RoboFile extends Robo\Tasks
{
    public function test()
    {
        exit
        (
            $this->taskPHPUnit()
            ->arg('./tests')
            ->option('coverage-clover', './build/logs/clover.xml')
            ->run()->getExitCode()
        );
    }

    public function docGenerate()
    {
        $couscousMenuItems = [];

        $docBlockParser = DocBlockFactory::createInstance();

        $rClass = new ReflectionClass('\\Gears\\String\\Str');
        foreach ($rClass->getTraits() as $rTrait)
        {
            foreach ($rTrait->getMethods() as $rMethod)
            {
                $docBlock = $docBlockParser->create($rMethod->getDocComment());

                $parameters = [];
                $paramTags = $docBlock->getTagsByName('param');
                foreach ($rMethod->getParameters() as $rParam)
                {
                    $paramTag = null;
                    foreach ($paramTags as $v)
                    {
                        if ($v->getVariableName() === $rParam->getName())
                        {
                            $paramTag = $v; break;
                        }
                    }

                    $parameters[] =
                    [
                        'name' => $rParam->getName(),
                        'type' => $paramTag !== null ? (string)$paramTag->getType() : '',
                        'default' => $rParam->isOptional() ? $rParam->getDefaultValue() : '',
                        'description' => $paramTag !== null ? (string)$paramTag->getDescription() : ''
                    ];
                }

                $returnTag = $docBlock->getTagsByName('return')[0];

                $examples = '';
                $examplesFile = './docs/Methods/'.$rMethod->getName().'.examples.md';
                if (file_exists($examplesFile))
                {
                    $examples = file_get_contents($examplesFile);
                }

                exec('git log '.$rMethod->getFileName(), $changelog);
                $changelog = implode("\n", $changelog);

                $engine = Foil\engine(['folders' => ['./docs/views'], 'autoescape' => false]);
                $docContents = $engine->render('method',
                [
                    'method' =>
                    [
                        'name' => $rMethod->getName(),
                        'summary' => (string)$docBlock->getSummary(),
                        'description' => (string)$docBlock->getDescription(),
                        'parameters' => $parameters,
                        'return' =>
                        [
                            'type' => $returnTag->getType(),
                            'description' => $returnTag->getDescription()
                        ],
                        'examples' => $examples,
                        'changelog' => $changelog
                    ]
                ]);

                $docFile = './docs/Methods/'.$rMethod->getName().'.md';

                file_put_contents($docFile, $docContents);

                $couscousMenuItems[$rMethod->getName()] =
                [
                    'text' => $rMethod->getName(),
                    'relativeUrl' => 'docs/Methods/'.Str::s($rMethod->getName())->toLowerCase().'.html'
                ];
            }
        }

        $couscous = Yaml::parse(file_get_contents('couscous.yml'));
        $couscous['menu']['sections']['methods']['items'] = $couscousMenuItems;
        file_put_contents('couscous.yml', Yaml::dump($couscous, 100));
    }
}
