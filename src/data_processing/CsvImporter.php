<?php


namespace nerodemiurgo\data_processing;

use nerodemiurgo\ex\FileFormatException;
use nerodemiurgo\ex\SourceFileException;

class CsvImporter
{
    private string $filename;
    private string $sqltablename;
    private array $columns;
    private array $result = [];
    public mixed $fp;

    public function __construct($filename, $sqltablename, $columns)
    {
        $this->filename = realpath("../../data") . $filename;
        $this->sqltablename = $sqltablename;
        $this->columns = $columns;
    }

    /**
     * @throws SourceFileException
     * @throws FileFormatException
     */
    public function import(): void
    {
        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверные заголовки столбцов");
        }

        if (!file_exists($this->filename)) {
            throw new SourceFileException("Файл не существует");
        }

        $this->fp = fopen($this->filename, 'r');

        if (!$this->fp) {
            throw new SourceFileException("Не удалось открыть файл на чтение");
        }

        $header_data = $this->getHeaderData();

        if (count($header_data) !== count($this->columns)) {
            throw new FileFormatException("Число столбцов файла не соответствует количеству заголовков");
        }


        while ($line = $this->getNextLine()) {
            $this->result[] = $line;
        }
    }

    public function getData(): array
    {
        return $this->result;
    }

    public function getHeaderData(): ?array
    {
        rewind($this->fp);
        return fgetcsv($this->fp);
    }

    private function getNextLine(): ?array
    {
        $result = null;

        if (!feof($this->fp)) {
            $result = fgetcsv($this->fp);
        }

        return $result;
    }

    private function validateColumns(array $columns): bool
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Создает массив из CSV
     * @throws FileFormatException
     */
    public function makeArrayFromCsv(): array
    {
        try {
            $this->import();
        } catch (SourceFileException $e) {
            print("Ошибка импорта файла: " . $e);
        }
        return $this->getData();
    }

    /**
     * Собирает файл sql
     * @throws FileFormatException
     */
    public function makeSql(): string
    {
        $data = $this->makeArrayFromCsv();
        $columns_name = $this->columns;
        $columns_name_string = $columns_name[0];
        $line_counter = count($data);
        $columns_counter = count($columns_name);
        $data_sql = "";

        for ($i = 1; $i < $columns_counter; $i++) {
            $columns_name_string = $columns_name_string . ", " . $columns_name[$i];
        }

        for ($i = 0; $i < $line_counter; $i++) {
            $line_data_string = "'" . $data[$i][0];
            for ($d = 1; $d < $columns_counter; $d++) {
                $line_data_string = $line_data_string . "', '" . $data[$i][$d];
            }
            $insert_line = "INSERT INTO " . $this->sqltablename . " (" . $columns_name_string . ") VALUES (" . $line_data_string . "');";
            $data_sql = $data_sql . "\n" . $insert_line;
        }

        $sql_file_name = "../../data/sql/" . $this->sqltablename . ".sql";
        $fp_for_sql = fopen($sql_file_name, "w");
        fwrite($fp_for_sql, $data_sql);
        fclose($fp_for_sql);
        return $data_sql;
    }
}
