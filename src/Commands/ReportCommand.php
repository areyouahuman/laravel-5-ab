<?php namespace RCAlmeida\AB\Commands;

use Illuminate\Console\Command;
use RCAlmeida\AB\Models\Report;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\Table;

class ReportCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ab:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Print the A/B testing report.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $rows = Report::getReport();
        $table = new Table($this->output);
        $table->setHeaders(array_shift($rows));
        array_walk($rows, function($row) use ($table) {
            $table->addRow($row);
        });
        $table->render();

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}
