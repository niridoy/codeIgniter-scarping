<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Panther\Client;

#[AsCommand(
    name: 'CompanyCrawler',
    description: 'Add a short description for your command',
)]
class CompanyCrawlerCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }
      

        // require __DIR__.'/vendor/autoload.php'; // Composer's autoloader
        
        $client = Client::createChromeClient();
        // Or, if you care about the open web and prefer to use Firefox
        $client = Client::createFirefoxClient();
        
        $client->request('GET', 'https://api-platform.com'); // Yes, this website is 100% written in JavaScript
        $client->clickLink('Get started');
        
        // Wait for an element to be present in the DOM (even if hidden)
        $crawler = $client->waitFor('#installing-the-framework');
        // Alternatively, wait for an element to be visible
        $crawler = $client->waitForVisibility('#installing-the-framework');
        
        echo $crawler->filter('#installing-the-framework')->text();
        $client->takeScreenshot('screen.png'); // Yeah, screenshot!

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
