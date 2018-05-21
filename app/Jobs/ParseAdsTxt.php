<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use PHPUnit\Runner\Exception;

class ParseAdsTxt
{
    use Dispatchable;

    public $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $records = explode("\n", $this->content);

        $records = $this->stripComments($records);

        if (is_null($records) || empty($records)) {
            throw new Exception('No valid records found.');
        }

        $this->validateRecords($records);
    }

    private function stripComments($records)
    {
        $filteredRecords = [];

        foreach ($records as $record) {
            $record = trim($record);

            if (strlen($record) < 1) {
                break;
            }

            $index = strpos($record, '#');

            if ($index > 0) {
                $filteredRecords[] = substr($record, 0, $index);
            } elseif ($index === false) {
                $filteredRecords[] = $record;
            }
        }

        return $filteredRecords;
    }

    private function validateRecords($records)
    {
        foreach ($records as $record) {
            if (strpos($record, '=') !== false) {
                $this->validateVariableDeclaration($record);
            } elseif (strpos($record, ',') !== false) {
                $this->validateFields($record);
            }
        }
    }

    private function validateFields($record)
    {
        $fields = explode(',', $record);

        if (count($fields) < 3 || count($fields) > 4) {
            throw new Exception('Wrong number of fields in record.');
        }

        // TODO: maybe regular expressions could be used to validate fields.
        // i.e. first field seems to be a domain and next fields valid alfanumeric.
    }

    private function validateVariableDeclaration($record)
    {
        $fields = explode('=', $record);

        if (count($fields) !== 2) {
            throw new Exception('Invalid variable declaration in record.');
        }

        // TODO: use regular expressions could be used to validate variable name and assigned value.
    }
}
