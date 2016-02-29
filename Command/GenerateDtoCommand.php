<?php

namespace WsSys\DtoGeneratorBundle\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use WsSys\DtoGeneratorBundle\Generator\XsdToDtoGenerator;

/**
 * Command to generate the Dtos
 */
class GenerateDtoCommand extends GeneratorCommand
{
    /**
     * All the supported Types eg: xsd, json
     * @var array 
     */
    protected $supportedTypes = array('xsd');
    
    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
    	$this
        ->setName('ws:generator:generate:dto')
        ->setAliases(array('ws:generator:dto:generate'))
        ->setDescription('Convert Xml/Json into PHP.')
        ->setDefinition(array(
            new InputArgument(
                'src', InputArgument::REQUIRED, 'The path of the souce XSD or JSON.'
            ),
            new InputArgument(
                'destination', InputArgument::REQUIRED, 'The path to save DTOs.'
            ),
            new InputArgument(
                'destination-namespace', InputArgument::REQUIRED, 'The target namespace for DTOs'
            ),
            new InputArgument(
                'src-type', InputArgument::REQUIRED, 'The type of the source eg: XSD'
            ),
        ))
        ->setHelp("Generate DTOs from Given source (Json/Xml).");
    }
    
    /**
     * Execute Command
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return type
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('src-type');
        
        if (!in_array($type, $this->supportedTypes)) {
            throw new \LogicException('We don\'t know yet, how to generate DTOs from ' . $type . '.');
        }
        
        $src = $input->getArgument('source');
        $destination = $input->getArgument('destination');
        $destinationNS = $input->getArgument('destination-namespace');

        if (!is_dir($destination)) {
            throw new \Exception("Destination must be a directory.");
        }
        
        $generator = $this->getGenerator();
        $generator->setSource($src)
                    ->setDestination($destination)
                    ->setDestinationNamespace($destinationNS)
                    ->generate();
                
        $output->writeln('Generated All the DTOs');
    }
    
    /**
     * {@inheritdoc}
     * @param BundleInterface $bundle
     * 
     * @return array
     */
    protected function getSkeletonDirs(BundleInterface $bundle = null)
    {
        $skeletonDirs = array();
        $skeletonDirs[] = __DIR__.'/../Resources/skeleton';
        return $skeletonDirs;
    }
    
    /**
     * creates a generator
     * @return XsdToDtoGenerator
     */
    protected function createGenerator()
    {
        return new XsdToDtoGenerator($this->getContainer()->get('filesystem'));
    }
}