<?php
namespace UpstatePHP\Website\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use UpstatePHP\Website\Services\SystemBackup;

class Backup extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'upstatephp:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the site and send it offsite.';

    /**
     * @var SystemBackup
     */
    private $systemBackup;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SystemBackup $systemBackup)
    {
        parent::__construct();
        $this->systemBackup = $systemBackup;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info('Generating backup ' . $this->systemBackup->getBackupName());

        $fullBackup = $this->systemBackup->doFullBackup();
        $this->systemBackup->sendBackupOffsite($fullBackup, true);

        $this->info('Backup complete.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
//        return [
//            ['example', InputArgument::REQUIRED, 'An example argument.'],
//        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
//        return [
//            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
//        ];
    }

}
