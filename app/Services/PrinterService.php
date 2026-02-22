<?php

namespace App\Services;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;

class PrinterService
{
    protected $printerName;

    public function __construct()
    {
        // This is the name of the printer installed in your OS
        $this->printerName = "KPrinter_82f4_BLE"; // Adjust to match your system printer
    }

    /**
     * Print text to the printer.
     *
     * @param string $text
     * @return bool|string Returns true if success, or error message string if failed
     */
    public function printText(string $text)
    {
        try {
            // For Windows
            $connector = new WindowsPrintConnector($this->printerName);

            // For Linux/CUPS, uncomment below
            // $connector = new CupsPrintConnector($this->printerName);

            $printer = new Printer($connector);

            $printer->text($text . "\n");
            $printer->cut();
            $printer->close();

            return true;
        } catch (\Exception $e) {
            // Return error message instead of logging
            return "Print error: " . $e->getMessage();
        }
    }
}
