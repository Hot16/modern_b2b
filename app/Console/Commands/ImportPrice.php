<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\ImportController;
use Illuminate\Console\Command;

class ImportPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import price';

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
    public function handle()
    {
        $import = new ImportController();
        $res = $import->import();
        $summ = '';
        $summ .= $res['status'] . "\n";
        if (isset($res['summary'])){
            foreach ($res['summary'] as $k=>$v){
                if (is_array($v)){
                    continue;
                }
                $summ .= $k . ' - ' . $v . "\n";
            }

        }
        echo $summ;
    }
}
